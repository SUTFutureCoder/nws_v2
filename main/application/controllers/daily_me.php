<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 个人中心
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Daily_me extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
    }
    
    /**    
     *  @Purpose:    
     *  个人中心页面显示   
     *  @Method Name:
     *  Index()    
     *  @Parameter: 
     *  @Return: 
    */   
    public function Index(){
        $this->load->library('session');
        if (!$this->session->userdata('user_number')){
            header('Location: ' . base_url());
            return 0;
        }
        //获取/插入基本信息
        $this->load->model('user_model');        
        $this->load->library('encrypt');
        $this->load->library('secure');
        $user_info = array();
        $user_info = $this->user_model->GetUserBasic($this->session->userdata('user_number'));
        $user_info['user_key'] = $this->encrypt->encode($this->session->userdata('user_key'));
        $user_info['user_section'] = $this->user_model->GetUserSection($this->session->userdata('user_number'));
        $user_info['user_role'] = $this->session->userdata('user_role');
        $user_info = array_merge($user_info, $this->user_model->GetUserProperty($this->session->userdata('user_number')));
        $this->load->view('daily_me_view', $user_info);  
    }
    
    /**    
     *  @Purpose:    
     *  用户照片上传   
     *  @Method Name:
     *  PhotoUpload()    
     *  @Parameter: 
     *  file         文件
     *  user_number  用户学号
     *  user_key     用户密钥
     *  @Return: 
     *  0 错误信息
     *  1 文件后缀名
    */   
    public function PhotoUpload(){
        $this->load->library('encrypt');
        $this->load->library('secure');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('user_model');
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode(array(
                '0' => 0,
                '1' => '密钥无法通过安检'
            ));
            return 0;
        }
        $config['file_name'] = $this->input->post('user_number', TRUE);
        $config['upload_path'] = 'upload/photo/';        
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2040';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        //$this->upload->do_upload('userfile');
        if ($this->upload->do_upload('userfile'))
        {
            $data = $this->upload->data();                
            $this->user_model->SetPhotoExt($this->input->post('user_number', TRUE), $data['file_ext']);
            
            echo json_encode(array(
                '0' => 1,
                '1' => $data['file_ext']
            ));
            return 0;
        }
        else
        {
            echo json_encode(array(
                '0' => 0,
                '1' => $this->upload->display_errors()
                )); 
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  个人信息更新   
     *  @Method Name:
     *  SetUserInfo()    
     *  @Parameter: 
     *  POST user_key 用户密钥
     *  POST user_number 用户学号
     *  POST user_telephone 用户电话号码
     *  POST user_qq 用户QQ号
     *  POST user_talent 用户特长
     *  POST user_friendsearch_enable 是否允许被搜索到
     *  POST user_pro_birthday 用户出生日期
     *  POST user_pro_old 用户年龄
     *  POST user_pro_hometown 用户家乡
     *  POST user_pro_bloodtype 用户血型
     *  POST user_pro_nick 用户昵称
     *  POST user_pro_ename 用户网名
     *  POST user_pro_homepage 用户主页
     *  POST user_pro_language 用户掌握外语
     *  POST user_pro_selfintro 用户自我介绍
     *  POST user_pro_lock 用户隐私锁
     *  @Return: 
     *  iframe|目标|状态码|状态说明|出错id
     *  iframe| |0|密钥无法通过检查
     *  iframe| |1|成功更新
     *  iframe| |2|学号位数不合法
     *  iframe| |3|手机号码不合法或为空|
     *  iframe| |4|QQ号为不能超过15位的整数|
     *  iframe| |5|用户特长必须在998个字符以内|
     *  iframe| |6|可被好友搜索到传值错误
     *  iframe| |7|日期必须为用-分割的三组数字|
     *  iframe| |8|日期格式不合法|
     *  iframe| |9|年龄不能超过3位数|
     *  iframe| |10|家乡不能超过98个字符|
     *  iframe| |11|请输入英文字符的血型且不能查过2个字符|
     *  iframe| |12|昵称不能超过98个字符|
     *  iframe| |13|网名不能超过98个字符|
     *  iframe| |14|主页地址不能超过998个字符|
     *  iframe| |15|掌握语言不能超过98个字符|
     *  iframe| |16|自我介绍不能超过398个字符|
     *  iframe| |17|高级信息隐私锁传值错误
     *  iframe| |18|用户基础信息已最新
     *  iframe| |19|用户高级信息已最新
     * 
    */   
    public function SetUserInfo(){
        $this->load->library('encrypt');
        $this->load->library('basic');
        $this->load->library('secure');
        $this->load->model('user_model');
        $clean = array();
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 0,
                '3' => '密钥无法通过安检'
            ));
            return 0;
        }
        
        if ($this->basic->user_number_length != strlen($this->input->post('user_number', TRUE)) || 
                !ctype_digit($this->input->post('user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 2,
                '3' => '学号位数不合法，应为' . $this->basic->user_number_length . '位'
            ));
            return 0;
        }
        $user_number = $this->input->post('user_number', TRUE);
        
        if (empty($this->input->post('user_telephone', TRUE)) || 
                11 != strlen($this->input->post('user_telephone', TRUE)) ||
                !ctype_digit($this->input->post('user_telephone', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 3,
                '3' => '手机号码位数不合法或为空，应为11位',
                '4' => 'user_telephone'
            ));
            return 0;
        }
        $clean['basic']['user_telephone'] = $this->input->post('user_telephone', TRUE);
        
        if (!ctype_digit($this->input->post('user_qq', TRUE)) || 
                15 <= strlen($this->input->post('user_qq', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 4,
                '3' => 'QQ号为不能超过15位的整数',
                '4' => 'user_qq'
            ));
            return 0;
        }
        $clean['basic']['user_qq'] = $this->input->post('user_qq', TRUE);
        
        if (iconv_strlen($this->input->post('user_talent', TRUE), 'utf-8') > 998){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 5,
                '3' => '用户特长必须在998个字符以内',
                '4' => 'user_talent'
            ));
            return 0;
        }
        $clean['basic']['user_talent'] = $this->input->post('user_talent', TRUE);
        
        switch ($this->input->post('user_friendsearch_enable', TRUE)){
            case 'true':
                $clean['basic']['user_friendsearch_enable'] = 1;
                break;
            case 'false':
                $clean['basic']['user_friendsearch_enable'] = 0;
                break;
            default :
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 6,
                    '3' => '可被好友搜索到传值错误'
                ));
                return 0;
                break;
        }
        
        if (!empty($this->input->post('user_pro_birthday', TRUE))){
            $time_parts = explode('-', $this->input->post('user_pro_birthday', TRUE));
            $date_check = array('1' => 31, '2' => 28, '3' => 31, '4' => 30, '5' => 31, '6' => 30, '7' => 31, '8' => 31, '9' => 30, '10' => 31, '11' => 30, '12' => 31);
            if (!ctype_digit($time_parts[0]) || !$time_parts[0] ||
                    !ctype_digit($time_parts[1]) || !$time_parts[1] ||
                    !ctype_digit($time_parts[2]) || !$time_parts[2]){
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 7,
                    '3' => '日期必须为用-分割的三组数字',
                    '4' => 'user_pro_birthday'
                ));
                return 0;
            }
            if (($time_parts[0] % 4 == 0 && $time_parts[1] % 100 != 0) || ($time_parts[1] % 400 == 0)){
                $date_check['2']++;
            }
            if (0 >= intval($time_parts[2]) || intval($time_parts[2]) > $date_check[intval($time_parts[1])]){
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 8,
                    '3' => '日期格式不合法',
                    '4' => 'user_pro_birthday'
                ));
                return 0;
            }
        }
        
        $clean['pro']['user_pro_birthday'] = $this->input->post('user_pro_birthday', TRUE);
        
        if (!empty($this->input->post('user_pro_old', TRUE)) && 
                (!ctype_digit($this->input->post('user_pro_old', TRUE)) || 3 < strlen($this->input->post('user_pro_old', TRUE)))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 9,
                '3' => '年龄不能超过3位数',
                '4' => 'user_pro_old'
            ));
            return 0;
        }
        $clean['pro']['user_pro_old'] = $this->input->post('user_pro_old', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_hometown', TRUE), 'utf-8') > 98){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 10,
                '3' => '家乡不能超过98个字符',
                '4' => 'user_pro_hometown'
            ));
            return 0;
        }
        $clean['pro']['user_pro_hometown'] = $this->input->post('user_pro_hometown', TRUE);
        
        if (!empty($this->input->post('user_pro_bloodtype', TRUE)) && 
                (!ctype_alpha($this->input->post('user_pro_bloodtype', TRUE)) || 2 < strlen($this->input->post('user_pro_bloodtype', TRUE)))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 11,
                '3' => '请输入英文字符的血型且不能查过2个字符',
                '4' => 'user_pro_bloodtype'
            ));
            return 0;
        }
        $clean['pro']['user_pro_bloodtype'] = $this->input->post('user_pro_bloodtype', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_nick', TRUE), 'utf-8') > 98){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 12,
                '3' => '昵称不能超过98个字符',
                '4' => 'user_pro_nick'
            ));
            return 0;
        }
        $clean['pro']['user_pro_nick'] = $this->input->post('user_pro_nick', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_ename', TRUE), 'utf-8') > 98){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 13,
                '3' => '网名不能超过98个字符',
                '4' => 'user_pro_ename'
            ));
            return 0;
        }
        $clean['pro']['user_pro_ename'] = $this->input->post('user_pro_ename', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_homepage', TRUE), 'utf-8') > 998){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 14,
                '3' => '主页地址不能超过998个字符',
                '4' => 'user_pro_homepage'
            ));
            return 0;
        }
        $clean['pro']['user_pro_homepage'] = $this->input->post('user_pro_homepage', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_language', TRUE), 'utf-8') > 98){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 15,
                '3' => '掌握语言不能超过98个字符',
                '4' => 'user_pro_language'
            ));
            return 0;
        }
        $clean['pro']['user_pro_language'] = $this->input->post('user_pro_language', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_selfintro', TRUE), 'utf-8') > 398){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 16,
                '3' => '自我介绍不能超过398个字符',
                '4' => 'user_pro_selfintro'
            ));
            return 0;
        }
        $clean['pro']['user_pro_selfintro'] = $this->input->post('user_pro_selfintro', TRUE);
        
        switch ($this->input->post('user_pro_lock', TRUE)){
            case 'true':
                $clean['pro']['user_pro_lock'] = 1;
                break;
            case 'false':
                $clean['pro']['user_pro_lock'] = 0;
                break;
            default :
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 17,
                    '3' => '高级信息隐私锁传值错误'
                ));
                return 0;
                break;
        }
        
        if ($this->user_model->UpdateUserBasic($user_number, $clean['basic'])){
            if ($this->user_model->UpdateUserProperty($user_number, $clean['pro'])){
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 1,
                    '3' => '修改用户信息成功'
                ));
                return 0;
            }else {
                echo json_encode(array(
                    '0' => 'iframe',
                    '1' => $this->input->post('src', TRUE),
                    '2' => 19,
                    '3' => '用户高级信息已最新'
                ));
                return 0;
            }
        }else {
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 18,
                '3' => '用户基础信息已最新'
            ));
            return 0;
        }        
    }
}
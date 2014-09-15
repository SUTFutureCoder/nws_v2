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
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }
        //获取/插入基本信息
        $this->load->model('user_model');        
        $this->load->library('encrypt');
        $this->load->library('secure');
        $user_info = array();
        $user_info = $this->user_model->GetUserBasic($this->session->userdata('user_id'));
        $user_info['user_key'] = $this->encrypt->encode($this->session->userdata('user_key'));
        $user_info['user_section'] = $this->user_model->GetUserSection($this->session->userdata('user_id'));
        $user_info['user_role'] = $this->session->userdata('user_role');
        $user_info = array_merge($user_info, $this->user_model->GetUserProperty($this->session->userdata('user_id')));
        $this->load->view('daily_me_view', $user_info);  
    }
    
    /**    
     *  @Purpose:    
     *  用户照片上传   
     *  @Method Name:
     *  PhotoUpload()    
     *  @Parameter: 
     *  file         文件
     *  user_id      用户账户
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
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE)) || 
                !ctype_digit($this->input->post('user_id', TRUE))){
            echo json_encode(array(
                '0' => 0,
                '1' => '密钥无法通过安检'
            ));
            return 0;
        }
        $config['file_name'] = $this->input->post('user_id', TRUE);
        $config['upload_path'] = 'upload/photo/';        
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2040';
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);
        //$this->upload->do_upload('userfile');
        if ($this->upload->do_upload('userfile'))
        {
            $data = $this->upload->data();                
            $this->user_model->SetPhotoExt($this->input->post('user_id', TRUE), $data['file_ext']);
            
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
     *  POST user_id 用户账号
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
     *  iframe| |18|用户信息已最新
     *  iframe| |19|用户输入联系方式已被使用
     * 
    */   
    public function SetUserInfo(){
        $this->load->library('encrypt');
        $this->load->library('basic');
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->model('user_model');
        $clean = array();
        
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE)) ||
                !ctype_digit($this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (!ctype_digit($this->input->post('user_id', TRUE)) || 
                10 < strlen($this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '账号位数不合法，应为小于等于10位的整数');
        }
        $user_id = $this->input->post('user_id', TRUE);
        
        if (empty($this->input->post('user_telephone', TRUE)) || 
                11 != strlen($this->input->post('user_telephone', TRUE)) ||
                !ctype_digit($this->input->post('user_telephone', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '手机号码位数不合法或为空，应为11位', 'user_telephone');
        }
        
        if ($this->user_model->CheckTeleConflict($user_id, $this->input->post('user_telephone'))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 19, '用户联系方式已被使用,请更改', 'user_telephone');
        }
        $clean['basic']['user_telephone'] = $this->input->post('user_telephone', TRUE);
        
        if (!ctype_digit($this->input->post('user_qq', TRUE)) || 
                15 <= strlen($this->input->post('user_qq', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 4, 'QQ号为不能超过15位的整数', 'user_qq');
        }
        $clean['basic']['user_qq'] = $this->input->post('user_qq', TRUE);
        
        if (iconv_strlen($this->input->post('user_talent', TRUE), 'utf-8') > 998){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 5, '用户特长必须在998个字符以内', 'user_talent');
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
                $this->data->Out('iframe', $this->input->post('src', TRUE), 6, '可被好友搜索到传值错误');                
                break;
        }
        
        if (!empty($this->input->post('user_pro_birthday', TRUE))){
            $time_parts = explode('-', $this->input->post('user_pro_birthday', TRUE));
            $date_check = array('1' => 31, '2' => 28, '3' => 31, '4' => 30, '5' => 31, '6' => 30, '7' => 31, '8' => 31, '9' => 30, '10' => 31, '11' => 30, '12' => 31);
            if (!ctype_digit($time_parts[0]) || !$time_parts[0] ||
                    !ctype_digit($time_parts[1]) || !$time_parts[1] ||
                    !ctype_digit($time_parts[2]) || !$time_parts[2]){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 7, '日期必须为用-分割的三组数字', 'user_pro_birthday');
            }
            if (($time_parts[0] % 4 == 0 && $time_parts[1] % 100 != 0) || ($time_parts[1] % 400 == 0)){
                $date_check['2']++;
            }
            if (0 >= intval($time_parts[2]) || intval($time_parts[2]) > $date_check[intval($time_parts[1])]){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 8, '日期格式不合法', 'user_pro_birthday');
            }
        }
        
        $clean['pro']['user_pro_birthday'] = $this->input->post('user_pro_birthday', TRUE);
        
        if (!empty($this->input->post('user_pro_old', TRUE)) && 
                (!ctype_digit($this->input->post('user_pro_old', TRUE)) || 3 < strlen($this->input->post('user_pro_old', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 9, '年龄不能超过3位数', 'user_pro_old');
        }
        $clean['pro']['user_pro_old'] = $this->input->post('user_pro_old', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_hometown', TRUE), 'utf-8') > 98){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 10, '家乡不能超过98个字符', 'user_pro_hometown');            
        }
        $clean['pro']['user_pro_hometown'] = $this->input->post('user_pro_hometown', TRUE);
        
        if (!empty($this->input->post('user_pro_bloodtype', TRUE)) && 
                (!ctype_alpha($this->input->post('user_pro_bloodtype', TRUE)) || 2 < strlen($this->input->post('user_pro_bloodtype', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 11, '请输入英文字符的血型且不能查过2个字符', 'user_pro_bloodtype');
        }
        $clean['pro']['user_pro_bloodtype'] = $this->input->post('user_pro_bloodtype', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_nick', TRUE), 'utf-8') > 98){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 12, '昵称不能超过98个字符', 'user_pro_nick');            
        }
        $clean['pro']['user_pro_nick'] = $this->input->post('user_pro_nick', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_ename', TRUE), 'utf-8') > 98){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 13, '网名不能超过98个字符', 'user_pro_ename');
        }
        $clean['pro']['user_pro_ename'] = $this->input->post('user_pro_ename', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_homepage', TRUE), 'utf-8') > 998){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 14, '主页地址不能超过998个字符', 'user_pro_homepage');            
        }
        $clean['pro']['user_pro_homepage'] = $this->input->post('user_pro_homepage', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_language', TRUE), 'utf-8') > 98){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 15, '掌握语言不能超过98个字符', 'user_pro_language');
        }
        $clean['pro']['user_pro_language'] = $this->input->post('user_pro_language', TRUE);
        
        if (iconv_strlen($this->input->post('user_pro_selfintro', TRUE), 'utf-8') > 398){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 16, '自我介绍不能超过398个字符', 'user_pro_selfintro');
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
                $this->data->Out('iframe', $this->input->post('src', TRUE), 17, '高级信息隐私锁传值错误');                
                break;
        }
        
        $change = 0;
        $this->user_model->UpdateUserBasic($user_id, $clean['basic']) || $this->user_model->UpdateUserProperty($user_id, $clean['pro']) ? $change = 1 : $change = 0;
        
        if ($change){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, '更新信息成功');            
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), 19, '用户信息已最新');            
        }
    }
}
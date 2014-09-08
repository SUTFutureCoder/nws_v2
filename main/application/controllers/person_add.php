<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 用户添加
 * 
 * :NOTICE:仅限管理员权限
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Person_add extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('role_model');
        $this->load->model('section_model');
        if (!$this->session->userdata('user_number')){
            header('Location: ' . base_url());
            return 0;
        }        
        
        $this->load->view('person_add_view', array(
            'user_number' => $this->session->userdata('user_number'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'role' => $this->role_model->GetRoleNameList(),
            'section' => $this->section_model->GetSectionNameList()
        ));
    }
    
    /**    
     *  @Purpose:    
     *  处理传入的添加用户值
     * 
     *  @Method Name:
     *  AddPersonNormal()    
     *  @Parameter: 
     *  POST $user_number 用户学号
     *  POST $user_key 用户密钥
     *  POST $add_user_role 添加用户角色
     *  POST $add_user_section 添加用户部门
     *  POST $add_user_number 添加用户学号
     *  POST $add_user_name 添加用户姓名
     *  POST $add_user_sex 添加用户性别
     *  POST $add_user_qq 添加用户QQ
     *  POST $add_user_talent 添加用户特长
     *  POST $add_user_telephone 添加用户联系方式
     * 
     *  @Return: 
     *  iframe|目标|状态码|状态说明|出错id
     *  iframe| |0|密钥无法通过检查
     *  iframe| |1|成功更新
     *  iframe| |2|学号位数不合法|
     *  iframe| |3|用户权限不足
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
     * :NOTICE:用户权限必须为管理员
     * 
    */   
    public function AddPersonNormal(){
        $this->load->library('encrypt');
        $this->load->library('basic');
        $this->load->library('secure');
        $this->load->model('section_model');
        $this->load->model('role_model');
        $this->load->model('user_model');
        $clean  = array();
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
                !ctype_digit($this->input->post('user_number', TRUE)) ||
                $this->basic->user_number_length != strlen($this->input->post('add_user_number', TRUE)) || 
                !ctype_digit($this->input->post('add_user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 2,
                '3' => '学号位数不合法，应为' . $this->basic->user_number_length . '位'
            ));
            return 0;
        }
        
        if ('管理员' != $this->secure->CheckRole($this->input->post('user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 3,
                '3' => '用户权限不足'
            ));
            return 0;
        }
//        $clean['basic']['user_number'] = $this->input->post('user_number', TRUE);
        $clean['basic']['user_number'] = $this->input->post('add_user_number', TRUE);
        
        //开始检验正常传入表单
        if (20 < strlen($this->input->post('add_user_role', TRUE)) || 
                !$this->user_model->SetUserRole($this->input->post('add_user_number', TRUE), $this->input->post('add_user_role', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 4,
                '3' => '用户社团角色错误'
            ));
            return 0;
        }
        
//        $this->user_model->SetUserRole($this->input->post('add_user_number', TRUE), $this->input->post('add_user_role', TRUE));
        $this->user_model->SetUserSection($this->input->post('add_user_number', TRUE), $this->input->post('add_user_section', TRUE));
            if (11 != strlen($this->input->post('add_user_telephone', TRUE)) ||
                !ctype_digit($this->input->post('add_user_telephone', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 5,
                '3' => '联系方式需要为11位数字',
                '4' => 'user_telephone'
            ));
            return 0;
        }
        $clean['basic']['user_telephone'] = $this->input->post('add_user_telephone', TRUE);
        
        if (15 < strlen($this->input->post('add_user_qq', TRUE)) ||
                !ctype_digit($this->input->post('add_user_qq', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 6,
                '3' => 'QQ号码为不超过15位的数字',
                '4' => 'user_qq'
            ));
            return 0;
        }
        $clean['basic']['user_qq'] = $this->input->post('add_user_qq', TRUE);
        
        if (398 < iconv_strlen($this->input->post('add_user_talent', TRUE), 'utf-8')){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 7,
                '3' => '特长不能超过398个字符',
                '4' => 'user_talent'
            ));
            return 0;
        }
        $clean['basic']['user_talent'] = $this->input->post('add_user_talent', TRUE);
        
        if (10 < iconv_strlen($this->input->post('add_user_name', TRUE), 'utf-8')){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 8,
                '3' => '姓名不能超过10个字符',
                '4' => 'user_name'
            ));
            return 0;
        }
        $clean['basic']['user_name'] = $this->input->post('add_user_name', TRUE);
        
        if (4 < iconv_strlen($this->input->post('add_user_sex', TRUE), 'utf-8') ||
                !$this->input->post('add_user_sex', TRUE)){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 9,
                '3' => '性别不能超过4个字符',
            ));
            return 0;
        }
        $clean['basic']['user_sex'] = $this->input->post('add_user_sex', TRUE);
        
        $clean['basic']['user_reg_time'] = 'Y-m-d';
        $clean['basic']['user_password'] = $this->encrypt->encode($this->input->post('add_user_number', TRUE) . substr($this->input->post('add_user_telephone', TRUE), 7, 4));
        //此处可更改
//        $clean['basic']['user_section'] = $this->input->post('add_user_section', TRUE);
        if ($this->user_model->SetUserBasic($clean['basic'])){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 1,
                '3' => '添加成功'
            ));
            return 0;
        }
    }
}
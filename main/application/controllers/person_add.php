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
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }        
        
        $this->load->view('person_add_view', array(
            'user_id' => $this->session->userdata('user_id'),
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
     *  POST $user_id 用户账号
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
     *  iframe| |1|添加成功
     *  iframe| |2|学号位数不合法|
     *  iframe| |3|检测到学号重复|
     *  iframe| |4|用户权限不足
     *  iframe| |5|用户社团角色错误
     *  iframe| |6|联系方式需要为11位数字|
     *  iframe| |7|联系方式检测到重复|
     *  iframe| |8|QQ号码为不超过15位的数字|
     *  iframe| |9|特长不能超过398个字符|
     *  iframe| |10|姓名不能超过10个字符|
     *  iframe| |11|性别不能超过4个字符|    
     *  iframe| |12|用户部门参数错误
     *  iframe| |13|用户部门关联设置错误
     *  
     * :NOTICE:用户权限必须为管理员
     * 
    */   
    public function AddPersonNormal(){
        $this->load->library('encrypt');
        $this->load->library('basic');
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->model('section_model');
        $this->load->model('role_model');
        $this->load->model('user_model');
        $clean  = array();
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (10 < strlen($this->input->post('user_id', TRUE)) || 
                !ctype_digit($this->input->post('user_id', TRUE)) ||
                $this->basic->user_number_length != strlen($this->input->post('add_user_number', TRUE)) || 
                !ctype_digit($this->input->post('add_user_number', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '学号位数不合法，应为' . $this->basic->user_number_length . '位', 'user_number');            
        }
        
        if ($this->user_model->CheckNumberConflict($this->input->post('add_user_number', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '检测到学号重复', 'user_number');
        }
        
        if ('管理员' != $this->secure->CheckRole($this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 4, '用户权限不足');            
        }
//        $clean['basic']['user_number'] = $this->input->post('user_number', TRUE);
        $clean['basic']['user_number'] = $this->input->post('add_user_number', TRUE);
        
        //开始检验正常传入表单
        if (11 != strlen($this->input->post('add_user_telephone', TRUE)) ||
            !ctype_digit($this->input->post('add_user_telephone', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 6, '联系方式需要为11位数字', 'user_telephone'); 
        }
        
        if ($this->user_model->CheckTeleConflict(NULL, $this->input->post('add_user_telephone', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 7, '联系方式检测到重复', 'user_telephone');             
        }
        $clean['basic']['user_telephone'] = $this->input->post('add_user_telephone', TRUE);
        
        if (15 < strlen($this->input->post('add_user_qq', TRUE)) ||
                !ctype_digit($this->input->post('add_user_qq', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 8, 'QQ号码为不超过15位的数字', 'user_qq'); 
        }
        $clean['basic']['user_qq'] = $this->input->post('add_user_qq', TRUE);
        
        if (398 < iconv_strlen($this->input->post('add_user_talent', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 9, '特长不能超过398个字符', 'user_talent'); 
        }
        $clean['basic']['user_talent'] = $this->input->post('add_user_talent', TRUE);
        
        if (10 < iconv_strlen($this->input->post('add_user_name', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 10, '姓名不能超过10个字符', 'user_name'); 
        }
        $clean['basic']['user_name'] = $this->input->post('add_user_name', TRUE);
        
        if (4 < iconv_strlen($this->input->post('add_user_sex', TRUE), 'utf-8') ||
                !$this->input->post('add_user_sex', TRUE)){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 11, '性别不能超过4个字符');
        }
        $clean['basic']['user_sex'] = $this->input->post('add_user_sex', TRUE);
        
        $clean['basic']['user_reg_time'] = 'Y-m-d';
        $clean['basic']['user_password'] = $this->encrypt->encode($this->input->post('add_user_number', TRUE) . substr($this->input->post('add_user_telephone', TRUE), 7, 4));
        //此处可更改
//        $clean['basic']['user_section'] = $this->input->post('add_user_section', TRUE);
        if ($user_id = $this->user_model->SetUserBasic($clean['basic'])){
            if (20 < strlen($this->input->post('add_user_role', TRUE)) || 
                !$this->user_model->SetUserRole($user_id, $this->input->post('add_user_role', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 5, '用户社团角色错误');
            }
            //        $this->user_model->SetUserRole($this->input->post('add_user_number', TRUE), $this->input->post('add_user_role', TRUE));
            if (!$this->section_model->CheckSectionExist($this->input->post('add_user_section', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 12, '用户部门参数错误');                
            }
            
            if (!$this->user_model->SetUserSection($user_id, $this->input->post('add_user_section', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 13, '用户部门关联设置失败，请勿重复关联'); 
            }
            
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, '添加成功');            
        }        
    }
}
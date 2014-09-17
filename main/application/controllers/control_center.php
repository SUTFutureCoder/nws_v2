<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 *  显示控制面板主界面 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Control_center extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  控制面板显示
     *  获取用户和社团基础信息
     *  @Method Name:
     *  Index()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
     *
    */
    public function Index(){
        $version = array();
        $section = array();
        $this->load->library('basic');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('control_center_model');
        $this->load->model('message_model');
        $this->load->model('user_model');
        if (empty($this->session->userdata('user_id'))){
            header("Content-Type: text/html;charset=utf-8");
            echo '<script>alert("会话已过期，请重新登录")</script>';
            echo '<script>window.location.href= \'' . base_url() . '\';</script>'; 
        }
        $init = $user_num_alert = $role_authorizee_alert = 0;
        //用于全体用户的提示信息        
        !$this->control_center_model->GetUserPropertySet($this->session->userdata('user_id')) ? $user_property_alert = 1 : $user_property_alert = 0;
        
        
        //推送信息
        $mess_push = array();
        $mess_push = $this->message_model->GetMessagePush();
        if ('管理员' == $this->session->userdata('user_role')){
            
            //进行套件基本信息获取[仅限管理员]
            $version = $this->control_center_model->GetVersion();
            $section = $this->control_center_model->GetSectionList();
            $role = $this->control_center_model->GetRoleNum();
            
            //提示条出现规则
            $role_authorizee = $this->control_center_model->GetRoleAuthorizeeNum();
            $user_num = $this->control_center_model->GetUserNum();
            
            !(isset($section[0]) && 1 <= $role) ? $init = 1 : $init = 0;
            !$role_authorizee ? $role_authorizee_alert = 1 : $role_authorizee = 0;
            1 == $user_num ? $user_num_alert = 1 : $user_num_alert = 0;
        }  
            //if (!isset($section[0]))
        $this->load->view('control_center_view', array(
            'user_role' => $this->session->userdata('user_role'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'user_name' => $this->session->userdata('user_name'),
            'organ_name' => $this->basic->organ_name,
            'ver_code' => $version[0]['ver_code'],
            'release_time' => $version[0]['release_time'],
            'init' => $init,
            'role_authorizee_alert' => $role_authorizee_alert,
            'user_num_alert' => $user_num_alert,
            'user_property_alert' => $user_property_alert,
            'mess_push' => $mess_push
            //'release_time' => $section[0]['section_name']
        ));   
        
    }
    
    /**    
     *  @Purpose:    
     *  社团部门初始化
     *  仅限管理员权限
     *  
     *  @Method Name:
     *  SectionSetup()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      array data_data(
     *          array(
     *              'section_id','section_name'
     *          )
     *      )
     *  )   
     *  @Return: 
     *  状态码|状态
     *      SetSectionList_1|成功录入部门列表
     *      SetSectionList_2|身份验证失败
     *      SetSectionList_3|插入数据库失败
     * 
     * :NOTICE 仅限管理员权限:
    */
    public function SectionSetup() {
        $this->load->library('secure');
        $this->load->library('encrypt');
        $this->load->model('control_center_model');        
        $user_id = $this->encrypt->decode($this->input->post('user_key', TRUE));
        if ('管理员' != $this->secure->CheckRole($user_id)){
            echo json_encode(array(
                    '0' => 'SetSectionList_2',
                    '1' => '身份验证失败'
                ));
            return 0;
        }      
        
        if (!$this->control_center_model->SetSectionList($this->input->post('data_array', TRUE))){
            echo json_encode(array(
                    '0' => 'SetSectionList_3',
                    '1' => '插入数据库失败'
                ));
            return 0;
        }else {
            echo json_encode(array(
                    '0' => 'SetSectionList_1',
                    '1' => '录入部门列表成功'
                ));
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  社团职位初始化
     *  仅限管理员权限
     *  
     *  @Method Name:
     *  RoleSetup()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      array data_data(
     *          array(
     *              'role_id','role_name'
     *          )
     *      )
     *  )   
     *  @Return: 
     *  状态码|状态
     *      SetRoleList_1|成功录入职位列表
     *      SetRoleList_2|身份验证失败
     *      SetRoleList_3|插入数据库失败
     * 
     * :NOTICE 仅限管理员权限:
    */
    public function RoleSetup() {
        $this->load->library('secure');
        $this->load->library('encrypt');
        $this->load->model('control_center_model');        
        $user_id = $this->encrypt->decode($this->input->post('user_key', TRUE));
        if ('管理员' != $this->secure->CheckRole($user_id) || !$user_id){
            echo json_encode(array(
                    '0' => 'SetRoleList_2',
                    '1' => '身份验证失败'
                ));
            return 0;
        }      
        
        if (!$this->control_center_model->SetRoleList($this->input->post('data_array', TRUE))){
            echo json_encode(array(
                    '0' => 'SetRoleList_3',
                    '1' => '插入数据库失败'
                ));
            return 0;
        }else {
            echo json_encode(array(
                    '0' => 'SetRoleList_1',
                    '1' => '录入职位列表成功'
                ));
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  管理员基础信息初始化
     *  仅限管理员权限
     *  
     *  @Method Name:
     *  AdminInfoSetup()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码     *      
     *          array(
     *              'admin_section','admin_sex','admin_major'
     *          )
     *      
     *  )   
     *  @Return: 
     *  状态码|状态
     *      SetRoleList_1|成功录入管理员基础信息
     *      SetRoleList_2|身份验证失败
     *      SetRoleList_3|插入数据库失败
     *      SetRoleList_4|信息不合法
     * 
     * :NOTICE 仅限管理员权限:
    */
    public function AdminInfoSetup() {
        $this->load->library('secure');
        $this->load->library('encrypt');
        $this->load->model('control_center_model'); 
        $this->load->model('user_model');
        $this->load->model('section_model');
        $user_id = $this->encrypt->decode($this->input->post('user_key', TRUE));
        if ('管理员' != $this->secure->CheckRole($user_id) || !$user_id){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_2',
                    '1' => '身份验证失败'
                ));
            return 0;
        }      
        $clean = array();
        if (!($this->input->post('admin_section', TRUE) && $this->section->CheckSectionExist($this->input->post('admin_section', TRUE)))){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_4',
                    '1' => '管理员部门信息有误'
                ));
            return 0;
        }
        //设置部门关联
        if (!$this->user_model->SetUserSection($user_id, $this->input->post('admin_section', TRUE))){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_3',
                    '1' => '插入数据库失败'
                ));
            return 0;
        }
        
        if (!($this->input->post('admin_sex', TRUE) && 4 >= iconv_strlen($this->input->post('admin_sex', TRUE), 'utf-8'))){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_4',
                    '1' => '性别信息有误'
                ));
            return 0;
        }
        
        if (!($this->input->post('admin_major', TRUE) && 50 >= iconv_strlen($this->input->post('admin_major', TRUE), 'utf-8'))){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_4',
                    '1' => '专业信息不可为空且不能超过50个字符'
                ));
            return 0;
        }
        
        $data = array(
            'user_sex' => $this->input->post('admin_sex', TRUE),
            'user_major' => $this->input->post('admin_major', TRUE)
        );
       
        
        if (!$this->control_center_model->SetAdminInfo($user_id, $data)){
            echo json_encode(array(
                    '0' => 'SetAdminInfo_3',
                    '1' => '插入数据库失败'
                ));
            return 0;
        }else {
            echo json_encode(array(
                    '0' => 'SetAdminInfo_1',
                    '1' => '录入职位列表成功'
                ));
            return 0;
        }
    }
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 授权、解权管理 FOR 管理员
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Authorizee_manage extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('authorizee');
        $this->load->model('user_model');
        $this->load->model('authorizee_model');
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_update_authorizee', $this->session->userdata('user_id'))){
            echo ('<script>alert(\'用户无权限\')</script>');
            return 0;
        }
        
        
        //[以权限类型分类]
        //array(3) { [1]=> array(7) { [0]=> array(2) { ["authorizee_id"]=> string(1) "1" 
   
        $authorizee_group = array();
        $authorizee_list = $this->authorizee_model->GetAuthorizeeList();
        foreach ($authorizee_list as $key => $value){
            $authorizee_group[$value['authorizee_column_id']][] = array(
                'authorizee_id' => $value['authorizee_id'],
                'authorizee_describe' => $value['authorizee_describe']
            );            
        }
        
        
        $this->load->view('authorizee_manage_view', array(
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'user_id' => $this->session->userdata('user_id'),
            'type' => $this->authorizee_model->GetAuthorizeeTypeList(),
            'authorizee_group' => $authorizee_group,
            'role' => $this->role_model->GetRoleNameList()
        ));
                
    }
    
    /**    
     *  @Purpose:    
     *  获取指定角色的权限
     *  
     *  @Method Name:
     *  GetRoleAuthorizeeList()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码,
     *      'user_id'  用户id
     *      'role_type'角色类型
     *  )   
     *  @Return: 
     *  状态码|状态
     *      0|密钥无法通过安检
     *      1|array 该角色权限列表   
     *      2|用户无权限
     *      3|错误的角色类型
     *      
     * 
    */
    public function GetRoleAuthorizeeList(){
        $this->load->library('secure');
        $this->load->library('encrypt');
        $this->load->library('data');
        $this->load->library('authorizee');        
        $this->load->model('authorizee_model');
        $this->load->model('role_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_get_role_authorizee', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '用户无权限');
        }
        
        if (!$this->role_model->CheckRoleName($this->input->post('role_type'))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '错误的角色类型');
        }
        
        $this->data->Out('iframe', $this->input->post('src', TRUE), 1, $this->authorizee->GetRoleAuthorizeeListId($this->input->post('role_type', TRUE)), 'GetRoleAuthorizee');
    }
    
    /**    
     *  @Purpose:    
     *  设置指定角色的权限
     *  
     *  @Method Name:
     *  GetRoleAuthorizeeList()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码,
     *      'user_id'  用户id
     *      'role_type'角色类型
     *  )   
     *  @Return: 
     *  状态码|状态
     *      0|密钥无法通过安检
     *      1|成功
     *      2|用户无读取权限
     *      3|用户无修改权限
     *      4|错误的角色类型
     *      
     *      
     * 
    */
    public function SetRoleAuthorizee(){
        $this->load->library('secure');
        $this->load->library('encrypt');
        $this->load->library('data');
        $this->load->library('authorizee');        
        $this->load->model('authorizee_model');
        $this->load->model('role_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_get_role_authorizee', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '用户无读取权限');
        }
        
        $authorizee_list = array();
        $authorizee_list = explode(',', $this->input->post('authorizee_list', TRUE));
        
        function filter ($f){
            if (!ctype_digit($f)){
                return FALSE;
            } else {
                return TRUE;
            }
        }
        $authorizee_list = array_filter($authorizee_list, 'filter');
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_update_authorizee', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '用户无修改权限');
        }
        
        if (!$this->role_model->CheckRoleName($this->input->post('role_type'))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 4, '错误的角色类型');
        }
        
        if ($this->authorizee_model->UpdateRoleAuthorizee($this->role_model->Name2Id($this->input->post('role_type')), $authorizee_list)){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, '修改' . $this->input->post('role_type') . '权限成功!');
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), 5, '修改失败，请检查是否尚未更改');
        }
        
    }
}
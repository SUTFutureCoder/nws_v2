<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 部员角色变动
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Authorizee_prompt extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  显示修改角色页
     *  
     *  @Method Name:
     *  index()
     * 
    */
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
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_update_role', $this->session->userdata('user_id'))){
            echo ('<script>alert(\'用户无权限\')</script>');
            return 0;
        }
        
        $this->load->view('authorizee_prompt', array(
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'user_id' => $this->session->userdata('user_id'),
            'role' => $this->role_model->GetRoleNameList()
        ));                
    }
    
    
    /**    
     *  @Purpose:    
     *  获取指定用户基础信息用以确认
     *  
     *  @Method Name:
     *  GetPromptUserBasic()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码,
     *      'user_id'  用户id
     *      'update_user_number' 目标用户学号
     *  )   
     *  @Return: 
     *  状态码|状态
     *      -1|密钥无法通过安检
     *      -2|用户无权限
     *      -3|提供的学号必须是数字
     *      -4|检索失败，请检查用户是否存在
     * 
     *      1|用户基本信息
     *      
     * 
    */
    public function GetPromptUserBasic(){
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('user_model');
        
        if (!$this->input->post('user_id', TRUE) || $this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
            return 0;
        }
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_update_role', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '用户无权限');
        }
        
        $clean = array();
        if (!ctype_digit($this->input->post('update_user_number', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '提供的学号必须是数字');
            return 0;
        } else {
            $clean['user_number'] = $this->input->post('update_user_number', TRUE);
        }
        
        $data = array();
        
        if ($data = $this->user_model->GetUserBasic($clean['user_number'], 'user_number')){
            $data['user_section'] = $this->user_model->GetUserSection($data['user_id']);
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'GetPromptUserBasic', $data);
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), -4, '检索失败，请检查用户是否存在');
            return 0;
        }
    }
    
    
    /**    
     *  @Purpose:    
     *  修改角色
     *  
     *  @Method Name:
     *  UpdateRole()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码,
     *      'user_id'  用户id
     *      'update_user_number' 目标用户学号
     *      'role'     目标角色
     *  )   
     *  @Return: 
     *  状态码|状态
     *      -1|密钥无法通过安检
     *      -2|用户无权限
     *      -3|提供的学号必须是数字
     *      -4|检索失败，请检查用户是否存在
     *      -5|角色名不合法
     * 
     *      1|用户基本信息
     *      
     * 
    */
    public function UpdateRole(){
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('user_model');
        
        if (!$this->input->post('user_id', TRUE) || $this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
            return 0;
        }
        
        if (!$this->authorizee->CheckAuthorizee('authorizee_update_role', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '用户无权限');
        }
        
        $clean = array();
        if (!ctype_digit($this->input->post('update_user_number', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '提供的学号必须是数字');
            return 0;
        } else {
            $clean['user_number'] = $this->input->post('update_user_number', TRUE);
        }
        
        if (null === ($this->input->post('role', TRUE)) || iconv_strlen($this->input->post('role', TRUE), 'utf-8') > 10){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -5, '角色名不合法');
            return 0;
        } else {
            $clean['role'] = $this->input->post('role', TRUE);
        }
        
        if ($user_id = $this->user_model->ConvertToId($clean['user_number'], 'user_number')){            
            if ($this->user_model->SetUserRole($user_id, $clean['role'])){   
                if ($this->input->post('user_id', TRUE) != $user_id){
                    $this->data->Out('iframe', $this->input->post('src', TRUE), 1, '修改成功');                             
                } else {
                    $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '修改成功，请重新登录');                             
                }
                
                //发送录用信息
                //WAIT
                
                return 0;    
            } else {
                $this->data->Out('iframe', $this->input->post('src', TRUE), -6, '修改失败');
                return 0;
            }
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), -5, '请检查用户是否存在');
            return 0;
        }
        
    }
}


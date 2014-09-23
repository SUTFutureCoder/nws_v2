<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 修改密码
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Daily_change_pass extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('authorizee');
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }
        $this->load->view('daily_change_pass_view', array(
            'user_id' => $this->session->userdata('user_id'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'authorizee_update_password' => $this->authorizee->CheckAuthorizee('authorizee_update_password', $this->session->userdata('user_id'))
        ));        
    }
    
    
    /**    
     *  @Purpose:    
     *  修改用户密码
     * 
     *  @Method Name:
     *  ChangePass()    
     *  @Parameter: 
     *  POST $user_id 本人的user_id
     *  POST $user_mixed user_id/user_telephone 当拥有修改他人密码权限时可以传入
     *  POST $user_password_old 旧密码 ctype_graph
     *  POST $user_password_new 新密码
     *  POST $user_password_confirm 新密码确认
     *  POST $user_key 用户密钥
     *  
     *  @Return: 
     *  0|密钥无法通过安检
     *  1|
     *  2|用户账户不合法
     *  3|传入用户账户不合法
     *  4|两次输入密码不同
     *  6|
     *  7|新密码不能超过18个字符
     *  8|
     *  9|没有更改其他用户密码的权限
     *  
    */       
    public function ChangePass(){
        $this->load->library('encrypt');
        $this->load->library('data');
        $this->load->library('secure');
        $this->load->library('authorizee');
        $this->load->model('user_model');
        
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if ($this->input->post('user_id', TRUE) && ctype_digit($this->input->post('user_id', TRUE)) && 
                11 >= strlen($this->input->post('user_id', TRUE))){
            $user_mixed = $this->input->post('user_id', TRUE);                                
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '用户账户不合法');
        }       
                
        //权限判断
        
        //高权限允许更改其他用户密码
        if ($this->input->post('user_mixed', TRUE) != 'undefined'){
            if (!$this->authorizee->CheckAuthorizee('authorizee_update_password', $this->input->post('user_id', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 9, $this->input->post('user_mixed', TRUE));
            }
            if (ctype_digit($this->input->post('user_mixed', TRUE))){                
                $user_mixed = $this->input->post('user_mixed', TRUE);  
                if (18 < strlen($this->input->post('user_password_new_other', TRUE))){
                    $this->data->Out('iframe', $this->input->post('src', TRUE), 7, '新密码不能超过18个字符', 'user_password_new_other');
                } else {
                    $update_pass_result = $this->secure->UpdateUserPass($user_mixed, $this->input->post('user_password_new_other', TRUE));
                    switch ($update_pass_result[0]){
                        case 0:
                        case 2:
                            $this->data->Out('iframe', $this->input->post('src', TRUE), 8, $update_pass_result[1],'user_password_new_other');
                        break;

                        case 1:
                            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, $update_pass_result[1]); //密钥不需要
                        break;
                    }
                }                
            } else {
                $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '目标用户账户不合法', 'user_mixed');
            }
        }
        
        if ($this->input->post('user_password_old', TRUE)){            
//            if ($this->secure->UpdateUserPass($user_mixed, $this->input->post('user_password_old', TRUE)))
            $check_pass_result = $this->secure->CheckUserPass($user_mixed, $this->input->post('user_password_old', TRUE));
            if (1 != $check_pass_result[0]){                
                $this->data->Out('iframe', $this->input->post('src', TRUE), 6, $check_pass_result[1], 'user_password_old');
            } else {
                if ($this->input->post('user_password_new', TRUE) != $this->input->post('user_password_confirm', TRUE)){
                    $this->data->Out('iframe', $this->input->post('src', TRUE), 4, '两次输入密码不同', 'user_password_new');
                } else {
                    if (18 < strlen($this->input->post('user_password_new', TRUE))){
                        $this->data->Out('iframe', $this->input->post('src', TRUE), 7, '新密码不能超过18个字符', 'user_password_new');
                    } else {
                        $update_pass_result = $this->secure->UpdateUserPass($user_mixed, $this->input->post('user_password_new', TRUE));
                        switch ($update_pass_result[0]){
                            case 0:
                            case 2:
                                $this->data->Out('iframe', $this->input->post('src', TRUE), 8, $update_pass_result[1],'user_password_new');
                            break;
                        
                            case 1:
                                $this->data->Out('iframe', $this->input->post('src', TRUE), 1, $update_pass_result[1]); //密钥不需要
                            break;
                        }
                    }
                }
            }
        }
    }
}
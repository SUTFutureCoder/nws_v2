<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 测试场
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Test extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function TestCheckAuthorizee(){
        $this->load->library('authorizee');
        $this->authorizee->CheckAuthorizee('act_add', 1);
    }
    
    public function TestGetUserAuthorizeeList(){
        $this->load->library('authorizee');
        $this->authorizee->GetUserAuthorizeeList(1);
    }
    
    public function TestGetAuthorizeeTypeList(){
        $this->load->model('authorizee_model');
        header('Content-type: text/html; charset=utf-8');
        var_dump($this->authorizee_model->GetAuthorizeeTypeList());        
    }
    
    public function TestGetAuthorizeeList(){
        $this->load->model('authorizee_model');
        header('Content-type: text/html; charset=utf-8');
        var_dump($this->authorizee_model->GetAuthorizeeList());        
    }
    
    public function TestGetRoleAuthorizeeList(){
        $this->load->library('authorizee');
        var_dump($this->authorizee->GetRoleAuthorizeeList('管理员'));
    }
}
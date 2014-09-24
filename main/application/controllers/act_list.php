<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动列表
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_list extends CI_Controller{
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
        //权限获取
        
        $this->load->view('act_list_view', array(
            'user_id' => $this->session->userdata('user_id'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'authorizee_act_update' => $this->authorizee->CheckAuthorizee('act_update', $this->session->userdata('user_id')),
            'authorizee_act_dele' => $this->authorizee->CheckAuthorizee('act_dele', $this->session->userdata('user_id')),
            'authorizee_act_global_list' => $this->authorizee->CheckAuthorizee('act_global_list', $this->session->userdata('user_id')),
            'authorizee_act_propagator' => $this->authorizee->CheckAuthorizee('act_propagator', $this->session->userdata('user_id'))
        ));
    }
}
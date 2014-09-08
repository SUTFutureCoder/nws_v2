<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 用于信息的发送、接收、推送
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Message_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取推送消息
     *  
     *  @Method Name:
     *  GetMessagePush($user_number)    
     *  @Parameter: 
     *     
     *  @Return: 
     *  array(
     *  'mess_push_id', 'mess_push_user_number', 'mess_push_section_limit', 'mess_push_title',
     *  'mess_push_title', 'mess_push_content', 'mess_push_style', 'mess_push_time', 'mess_push_end_time', 'mess_push_dele',
     *  'mess_push_dele_time'
     * );
     *
    */
    public function GetMessagePush(){
        //building
        //通过user_number获取用户权限
        //↑$this->load->library('secure');
        //authorizee中包含：阅读所有推送信息、阅读本部推送信息的1/0字段
        //目前无条件获取所有推送
        $this->load->database();
        $this->db->where('mess_push_time <=', date('Y-m-d H:i:s'));
        //允许提前设置推送内容
        $this->db->where('mess_push_end_time >=', date('Y-m-d H:i:s'));
        $this->db->where('mess_push_dele', 0);
        $query = $this->db->get('message_push');
        return $query->result_array();
    }
}
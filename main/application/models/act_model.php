<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动相关数据交互
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    
    /**    
     *  @Purpose:    
     *  获取活动类型列表   
     *  @Method Name:
     *  GetActTypeList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *     array(
     *      array(
     *     ));
     * 
     *  
    */ 
    public function GetActTypeList(){
        $this->load->database();
        $query = $this->db->get('activity_type');
        return $query->result_array();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入活动类型转换为类型id   
     *  @Method Name:
     *  TypeToId($act_type)    
     *  @Parameter: 
     *  $act_type 活动类型文字
     *  @Return: 
     *      0|失败
     *      1|id(成功)
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function TypeToId($act_type){
        $this->load->database();
        $this->db->select('activity_type_id');
        $this->db->where('activity_type_name', $act_type);
        $query = $this->db->get('activity_type');
        return $query->row()->activity_type_id;
    }
    
    /**    
     *  @Purpose:    
     *  根据传入类型字符串验证类型是否存在   
     *  @Method Name:
     *  CheckTypeExist($type_name)    
     *  @Parameter: 
     *  $type_name 待检验类型名称
     *  @Return: 
     *  0|无此类型
     *  1|有此类型
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function CheckTypeExist($type_name){
        $this->load->database();
        $this->db->where('activity_type_name', $type_name);
        $this->db->from('activity_type');
        return $this->db->count_all_results();
    }
    
    /**    
     *  @Purpose:    
     *  添加活动   
     *  @Method Name:
     *  AddAct($data)    
     *  @Parameter: 
     *  $data 活动数据数组
     *  @Return: 
     *  0|添加失败
     *  1|添加成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function AddAct($data){
        $this->load->database();
        $this->db->insert('activity', $data['activity']);
        if (!$this->db->affected_rows()){
            return 0;
        }        
        $data['re_activity_section']['act_id'] = $data['re_activity_type']['act_id'] = $this->db->insert_id();
        
        $this->db->insert('re_activity_type', $data['re_activity_type']);
        if (!$this->db->affected_rows()){
            return 0;
        }
        
        $this->db->insert('re_activity_section', $data['re_activity_section']);
        if (!$this->db->affected_rows()){
            return 1;
        }
    }
}

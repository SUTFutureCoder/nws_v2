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
     *  获取活动详情   
     *  @Method Name:
     *  GetActInfo($act_id)    
     *  @Parameter: 
     *  $act_id 活动id
     *  @Return: 
     *     array(
     *      
     *     ));
     * 
     *  
    */ 
    public function GetActInfo($act_id){
        $this->load->database();
        $this->db->select('activity.act_id, activity.act_name, activity.act_content, activity.act_warn, activity.act_money, activity.act_position,'
                . 'activity.act_private, activity.act_start, activity.act_end, activity.act_member_sum, '
                . 'user.user_name, user.user_telephone, user.user_qq, '
                . 'activity_type.activity_type_name, section.section_name, activity.act_global, activity.act_private, activity.act_defunct');
        $this->db->where('activity.act_id', $act_id);
        $this->db->from('activity');
        $this->db->join('re_activity_type', 're_activity_type.act_id = activity.act_id');
        $this->db->join('activity_type', 'activity_type.activity_type_id = re_activity_type.type_id');
        $this->db->join('user', 'user.user_id = activity.act_user_id');
        $this->db->join('re_activity_section', 're_activity_section.act_id = activity.act_id');
        $this->db->join('section', 'section.section_id = re_activity_section.section_id');
        
        $query = $this->db->get();
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
        return $this->db->count_all_results('activity_type');
    }
    
    /**    
     *  @Purpose:    
     *  检查活动id是否存在   
     *  @Method Name:
     *  CheckIdExist($act_id)    
     *  @Parameter: 
     *  $act_id 待检验id
     *  @Return: 
     *  0|无此id
     *  1|有此id
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function CheckIdExist($act_id){
        $this->load->database();
        $this->db->where('act_id', $act_id);
        return $this->db->count_all_results('activity');
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
     *  $data['re_activity_section']['act_id'](添加成功)
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
            return 0;
        }
        return $data['re_activity_section']['act_id'];
    }
    
    /**    
     *  @Purpose:    
     *  删除活动   
     *  @Method Name:
     *  ActDele($act_id)    
     *  @Parameter: 
     *  $act_id 活动id
     *  @Return: 
     *  0|添加失败
     *  1|添加成功
     * 
    */ 
    public function ActDele($act_id){
        $this->load->database();
        $this->db->where('act_id', $act_id);
        $this->db->update('activity', array('act_defunct' => 1));
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  更新活动   
     *  @Method Name:
     *  ActUpdate($data)    
     *  @Parameter: 
     *  $data 活动信息
     *  @Return: 
     *  0|修改失败
     *  1|修改成功
     * 
    */ 
    public function ActUpdate($data){
        $this->load->database();
        $this->db->update('activity', $data['activity'], array('act_id' => $data['act_id']));
        $this->db->update('re_activity_type', $data['re_activity_type'], array('act_id' => $data['act_id']));
        $this->db->update('re_activity_section', $data['re_activity_section'], array('act_id' => $data['act_id']));
        if (!$this->db->affected_rows()){
            return 0;
        } else {
            $this->db->where('act_id', $data['act_id']);        
            if (!$this->db->count_all_results('activity_update')){
                $this->db->insert('activity_update', array('act_id' => $data['act_id']));  
            } else {  
                $this->db->where('act_id', $data['act_id']);
                $this->db->set('act_update_sum', 'act_update_sum+1', FALSE);
                $this->db->update('activity_update');
            }   
        }        
    }
    
    /**    
     *  @Purpose:    
     *  获取活动列表   
     *  @Method Name:
     *  GetActList($start_id, $offset_num, $type, $section, $keyword)    
     *  @Parameter: 
     *  $start_id   查询分页起始位置
     *  $offset_num 偏移量【默认为10】
     *  $standard_id = NULL 以此为id基准进行向上或向下查询,可最大也可小 注意，如果单条查询则需要-1处理。 因为是大于号
     *  $guest = 0  是否为游客
     *  $up = 1     是否向上获取数据
     *  $type = NULL       活动类型
     *  $section = NULL    部门限制
     *  $keyword = NULL    查询字段
     *  @Return: 
     *  
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetActList($start_id, $offset_num = 10, $standard_id = NULL, $guest = 0, $up = 1, $type = NULL, $section = NULL, $keyword = NULL){
        $this->load->database();  
        $this->db->select('activity.act_id, activity.act_name, activity.act_private, '
                . 'activity.act_private, activity.act_start, activity.act_end, '
                . 'activity_type.activity_type_name, section.section_name, activity.act_global');
        
        //注意，section.section_name, activity.act_global的处理方式可能不是最优化

        $this->db->from('activity');
        $this->db->limit($offset_num, $start_id);        
        $this->db->where('activity.act_defunct !=', 1);
        $this->db->order_by('activity.act_end', 'desc');
        $this->db->order_by('activity.act_id', 'desc');
        if (NULL != $standard_id){
            if ($up){
                $this->db->where('activity.act_id >', $standard_id);
                $this->db->where('activity.act_end >', date("Y-m-d H:i:s"));
            } else {
                $this->db->where('activity.act_id <=', $standard_id);                
            }
            
        }
        
        //游客登录时不显示内部活动
        if (1 == $guest){
            $this->db->where('act_private', 0);
        }
        
        $this->db->join('re_activity_type', 're_activity_type.act_id = activity.act_id');
        $this->db->join('activity_type', 'activity_type.activity_type_id = re_activity_type.type_id');
        
        if (NULL != $type){
            $this->db->where('activity_type.activity_type_name', $type);            
        }
        
        $this->db->join('re_activity_section', 're_activity_section.act_id = activity.act_id');
        $this->db->join('section', 'section.section_id = re_activity_section.section_id');
        
        
        if (NULL != $section){
            $this->db->where('section.section_name', $section);            
        }    
        
        if (NULL != $keyword){            
            $this->db->like('activity.act_name', $keyword);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

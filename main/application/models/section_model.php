<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 用于部门信息的检查及设置等
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Section_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入部门字符串验证部门是否存在   
     *  @Method Name:
     *  CheckSectionExist($section_name)    
     *  @Parameter: 
     *  $section_name 待检验部门名称
     *  @Return: 
     *  0|无此部门
     *  1|有此部门
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function CheckSectionExist($section_name){
        $this->load->database();
        $this->db->where('section_name', $section_name);
        $query = $this->db->get('section');
        return $query->num_rows();
    }
    
    /**    
     *  @Purpose:    
     *  裁决部门冲突录用
     *  @Method Name:
     *  JudgeSectionConflict(user_id, user_section)    
     *  @Parameter: 
     *  user_id 用户学号
     *  user_section 用户裁决目标部门
     *  @Return: 
     *     影响的表行数
     * 
     *  
    */ 
    public function JudgeSectionConflict($user_id, $user_section){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->delete('re_user_section');
        $this->db->where('user_id', $user_id);
        $this->db->update('user', array(
            'user_password' => 0
        ));
        $this->db->insert('re_user_section', array(
            'user_id' => $user_id,
            'section_id' => $this->GetSectionId($user_section)
        ));
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入的字符串获取部门id
     *  @Method Name:
     *  GetSectionId($section_name)    
     *  @Parameter: 
     *  $section_name 待获取id部门
     *  @Return: 
     *  0|不存在的部门
     *  id|成功
     * 
     *  :WARNING:传值前请验证是否存在
    */ 
    public function GetSectionId($section_name){
        $this->load->database();
        $this->db->where('section_name', $section_name);
        $query = $this->db->get('section');
        return $query->row()->section_id;
    }
        
    /**    
     *  @Purpose:    
     *  获取部门名字列表
     *  @Method Name:
     *  GetSectionNameId()    
     *  @Parameter: 
     *  @Return: 
     *  array 部门列表
     * 
    */ 
    public function GetSectionNameList(){
        $this->load->database();
        $this->db->select('section_name');
        $query = $this->db->get('section');
        return $query->result_array();
    }
    
    
    /**    
     *  @Purpose:    
     *  获取部门冲突录用
     *  @Method Name:
     *  GetSectionConflict()    
     *  @Parameter: 
     *  
     *  @Return: 
     *      Array $data['user'] 冲突用户列表
     *      Array $data['section'] 冲突部门列表
     * 
     *  
    */ 
    public function GetSectionConflict(){
        $this->load->database();
        $data['user'] = array();
        $data['section'] = array();
//        $this->db->select('user_id');
        $this->db->where('user_password', 1);
        $query = $this->db->get('user');
        $data['user'] = array_merge($data['user'], $query->result_array());
        foreach ($data['user'] as $conflict_user){
            $this->db->from('re_user_section');
            $this->db->join('section', 'section.section_id = re_user_section.section_id');
            $this->db->where('re_user_section.user_id', $conflict_user['user_id']);
            $query = $this->db->get();
            $data['section'] = array_merge($data['section'], $query->result_array());
        }
        return $data;
    }
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 角色相关查询、设置
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Role_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取角色名字列表
     *  @Method Name:
     *  GetRoleNameList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *    array 角色列表
     * 
     *  
    */ 
    public function GetRoleNameList(){
        $this->load->database();
        $this->db->select('role_name');
        $query = $this->db->get('role');        
        return $query->result_array();
    }
    
    /**    
     *  @Purpose:    
     *  验证是否有此角色名字
     *  @Method Name:
     *  CheckRoleName($role_name)    
     *  @Parameter: 
     *  $role_name 传入的role名字
     *  @Return: 
     *      0|无
     *      1|有
     * 
     *  
    */ 
    public function CheckRoleName($role_name){
        $this->load->database();
        $this->db->where('role_name', $role_name);
        $this->db->from('role');        
        return $this->db->count_all_results();
    }
    
    /**    
     *  @Purpose:    
     *  通过user_id获得角色id
     *  @Method Name:
     *  GetRoleId($user_id)    
     *  @Parameter: 
     *  $user_id 用户id
     *  @Return: 
     *      0|查询失败
     *      role_id|角色id
     * 
     *  
    */ 
    public function GetRoleId($user_id){
        $this->load->database();
        $this->db->select('role_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('re_user_role');
        return $query->row()->role_id;
    }   
    
    /**    
     *  @Purpose:    
     *  通过role_name获得角色id
     *  @Method Name:
     *  Name2Id($role_name)   
     *  @Parameter: 
     *  $role_name 角色名称
     *  @Return: 
     *      0|查询失败
     *      role_id|角色id
     * 
     *  
    */ 
    public function Name2Id($role_name){
        $this->load->database();
        $this->db->select('role_id');
        $this->db->where('role_name', $role_name);
        $query = $this->db->get('role');
        return $query->row()->role_id;
    }   
    
}
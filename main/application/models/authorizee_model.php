<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 权限相关数据交互
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/

class Authorizee_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    
    /**    
     *  @Purpose:    
     *  获取权限类型列表  
     *  @Method Name:
     *  GetAuthorizeeTypeList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  array 权限类型列表
     * 
     *  
    */ 
    public function GetAuthorizeeTypeList(){
        $this->load->database();
        $query = $this->db->get('authorizee_column');
        return $query->result_array();
    }
    
    /**    
     *  @Purpose:    
     *  获取权限列表  
     *  @Method Name:
     *  GetAuthorizeeList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  array 权限列表
     *  
    */ 
    public function GetAuthorizeeList(){
        $this->load->database();
        $this->db->select('authorizee_id, authorizee_describe, authorizee_column_id');
        $query = $this->db->get('authorizee');
        return $query->result_array();
    }
    
    /**    
     *  @Purpose:    
     *  修改（设置）角色权限
     *  @Method Name:
     *  UpdateRoleAuthorizee($role_id, $authorizee_list)    
     *  @Parameter: 
     *  $role_id         角色类型
     *  $authorizee_list 修改的权限列表
     *  @Return: 
     *  0|失败
     *  1|成功
     *  
    */ 
    public function UpdateRoleAuthorizee($role_id, $authorizee_list){
        $this->load->database();
        $pre_data = array(
            $role_id => 0
        );
        $this->db->update('re_role_authorizee', $pre_data);
        
        $data = array(
            $role_id => 1                
        );
        foreach ($authorizee_list as $authorizee_list_item){
            $this->db->where('authorizee_id', $authorizee_list_item);
            $this->db->update('re_role_authorizee', $data);
        }
        
        return $this->db->affected_rows();
    }  
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 登录时获取版本信息
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Control_center_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  获取最近的一个版本信息
     *  
     *  @Method Name:
     *  GetVersion()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  $data[0] = array(
     *      'ver_id', 'ver_code', 'ver_describe', 'release_time'
     *  )
     *
    */
    public function GetVersion(){
        $this->load->database();
        $this->db->order_by('ver_id', 'desc');
        $this->db->limit(1);       
        $query = $this->db->get('version');
        return $query->row_array();
    }
    
    /**    
     *  @Purpose:    
     *  获取部门列表信息
     *  
     *  @Method Name:
     *  GetSectionList()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  $data[] = array(
     *      'section_id', 'section_name', 'section_describe'
     *  )
     *
    */
    public function GetSectionList(){
        $data = array();
        $this->load->database();
        $query = $this->db->get('section');        
        return $query->result_array();
    }
    
    /**    
     *  @Purpose:    
     *  获取角色列表是否已设置
     *  
     *  @Method Name:
     *  GetRoleNum()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  角色表行数
     *  1——提示设置
     *  >1——无需设置
     *
    */
    public function GetRoleNum(){
        $this->load->database();
        return $this->db->count_all('role');
    }
    
    /**    
     *  @Purpose:    
     *  获取套件角色权限是否已设置
     *  
     *  @Method Name:
     *  GetRoleAuthorizeeNum()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  角色、权限关联表行数
     *  0——提示设置
     *  1——无需设置
     *
    */
    public function GetRoleAuthorizeeNum(){
        $this->load->database();
        return $this->db->count_all('re_role_authorizee');
    }
    
    /**    
     *  @Purpose:    
     *  获取用户数量
     *  
     *  @Method Name:
     *  GetUserNum()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  用户表表行数
     *  1——提示设置
     *  >1——无需设置
     *
    */
    public function GetUserNum(){
        $this->load->database();
        return $this->db->count_all('user');
    }
    
    /**    
     *  @Purpose:    
     *  获取用户详情是否存在
     *  
     *  @Method Name:
     *  GetUserPropertySet()    
     *  @Parameter: 
     *  $user_id 用户账号   
     *  @Return: 
     *  用户表表行数
     *  0——提示设置
     *  1——无需设置
     *
    */
    public function GetUserPropertySet($user_id){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('user_property');
    }
    
    /**    
     *  @Purpose:    
     *  批量(重置)设置部门
     *  
     *  @Method Name:
     *  SetSectionList()    
     *  @Parameter: 
     *  $section_list =array(
     *      array(
     *        'section_id', 'section_name'
     *      )
     *  );
     *  @Return: 
     *  操作影响的数据库行数（0行为不正常）
     *
    */
    public function SetSectionList($section_list){
        $this->load->database();
        $this->db->truncate('section');
        $this->db->insert_batch('section', $section_list);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  批量(重置)设置职位
     *  
     *  @Method Name:
     *  SetRoleList()    
     *  @Parameter: 
     *  $role_list =array(
     *      array(
     *        'role_id', 'role_name'
     *      )
     *  );
     *  @Return: 
     *  操作影响的数据库行数（0行为不正常）
     *
    */
    public function SetRoleList($role_list){
        $this->load->database();
        $this->db->truncate('role');
        $this->db->insert('role', array(
            'role_id' => 1,
            'role_name' => '管理员'
        ));
        $this->db->insert_batch('role', $role_list);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  设置管理员基础信息
     *  
     *  @Method Name:
     *  SetAdminInfo($user_id, $data)   
     *  @Parameter: 
     *  $data =array(
     *      'user_section', 'user_sex', 'user_major'
     *  );
     *  @Return: 
     *  操作影响的数据库行数（0行为不正常）
     *
    */
    public function SetAdminInfo($user_id, $data){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }
}

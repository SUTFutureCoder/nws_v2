<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 权限获取及设置
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Authorizee{
    
    /**    
     *  @Purpose:    
     *  验证权限
     *  
     *  @Method Name:
     *  CheckAuthorizee($authorizee_name, $user_id)    
     *  @Parameter: 
     *  $authorizee_name 权限名称
     *  $user_id        用户id  
     *  @Return: 
     *  状态码|状态
     *      0|无权限
     *      1|有权限
     * 
    */
    public function CheckAuthorizee($authorizee_name, $user_id){
        $CI =& get_instance();
        $data = array();
        $CI->load->model('role_model');
        $CI->load->database();
        $CI->db->where('authorizee.authorizee_name', $authorizee_name);
        //$CI->db->select('re_role_authorizee.' . $CI->role_model->GetRoleId($user_id));
        $CI->db->from('authorizee');
        $CI->db->join('re_role_authorizee', 'authorizee.authorizee_id = re_role_authorizee.authorizee_id');
        $query = $CI->db->get();
        $data = $query->result_array();
        return $data[0][$CI->role_model->GetRoleId($user_id)];
    }
    
    /**    
     *  @Purpose:    
     *  获取用户权限列表
     *  
     *  @Method Name:
     *  GetUserAuthorizeeList($user_id)    
     *  @Parameter: 
     *  $user_id        用户id  
     *  @Return: 
     *     array(
     *          '' => 1, '' => 1
     *      );
     * 
    */
    public function GetUserAuthorizeeList($user_id){
        $CI =& get_instance();
        $data = array();
        $CI->load->model('role_model');
        $CI->load->database();  
        $CI->db->where('re_role_authorizee.' . $CI->role_model->GetRoleId($user_id) . ' !=', 0);
        $CI->db->from('re_role_authorizee');
        $CI->db->join('authorizee', 'authorizee.authorizee_id = re_role_authorizee.authorizee_id');
        $CI->db->select('authorizee_name');
        $query = $CI->db->get();
        foreach ($query->result_array() as $key => $value){
            $data[$value['authorizee_name']] = 1;
        }
        return $data;
    }
    
    /**    
     *  @Purpose:    
     *  获取角色权限列表
     *  
     *  @Method Name:
     *  GetRoleAuthorizeeList($role_name)    
     *  @Parameter: 
     *  $role_name      角色名字  
     *  @Return: 
     *     array(
     *          '' => 1, '' => 1
     *      );
     * 
    */
    public function GetRoleAuthorizeeList($role_name){
        $CI =& get_instance();
        $data = array();
        $CI->load->model('role_model');
        $CI->load->database();  
        $CI->db->where('re_role_authorizee.' . $CI->role_model->Name2Id($role_name) . ' !=', 0);
        $CI->db->from('re_role_authorizee');
        $CI->db->join('authorizee', 'authorizee.authorizee_id = re_role_authorizee.authorizee_id');
        $CI->db->select('authorizee_name');
        $query = $CI->db->get();
        foreach ($query->result_array() as $key => $value){
            $data[$value['authorizee_name']] = 1;
        }
        return $data;
    }
    
    /**    
     *  @Purpose:    
     *  获取角色权限列表[ID]
     *  
     *  @Method Name:
     *  GetRoleAuthorizeeListId($role_name)    
     *  @Parameter: 
     *  $role_name      角色名字  
     *  @Return: 
     *     array(
     *          '' => 1, '' => 1
     *      );
     * 
    */
    public function GetRoleAuthorizeeListId($role_name){
        $CI =& get_instance();
        $data = array();
        $CI->load->model('role_model');
        $role_id = $CI->role_model->Name2Id($role_name);
        $CI->load->database();  
        $CI->db->select('authorizee_id, ' . $role_id);
        $CI->db->where($role_id . ' !=', 0);
        $query = $CI->db->get('re_role_authorizee');
        foreach ($query->result_array() as $key => $value){
            $data[$value['authorizee_id']] = 1;
        }
        return $data;
    }
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 安全
 * 负责用户的密钥解密，权限验证
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Secure{
    
    /**    
     *  @Purpose:    
     *  根据用户密钥获取用户角色   
     *  @Method Name:
     *  CheckRole($encrypted_key)    
     *  @Parameter: 
     *  $encrypted_key 已加密的用户密钥 
     *  @Return: 
     *  用户角色或0
    */ 
    public function CheckRole($encrypted_key){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        
        $CI->load->library('encrypt');
        $CI->load->database();
        //检查是否存在此用户
        $CI->db->where('user_id', $this->CheckUserKey($encrypted_key));
        $query = $CI->db->get('user');        
        if (!$query->num_rows()){
            return 0;
        }
        //获取用户的角色
        $role = array();
        $CI->db->where('user_id', $this->CheckUserKey($encrypted_key));
        $CI->db->from('re_user_role');
        $CI->db->join('role', 'role.role_id = re_user_role.role_id');
        $query = $CI->db->get();
        $role = array_merge($role, $query->result_array());
        
        return $role['role_name'];
    }
    
    /**    
     *  @Purpose:    
     *  根据传入的部门测试是否实际存在   
     *  @Method Name:
     *  CheckSection($section_name) 
     *  @Parameter: 
     *  $section_name 部门名称 
     *  @Return: 
     *  0|无此部门
     *  1|有此部门
    */ 
    public function CheckSection($section_name){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();         
        $CI->load->database();
        //检查是否存在此用户
        $CI->db->where('section_name', $section_name);
        $query = $CI->db->get('section');
        return $query->num_rows();
    }
    
    /**    
     *  @Purpose:    
     *  检验传入的用户密钥是否合法或过期   
     *  @Method Name:
     *  CheckUserKey($encrypted_key) 
     *  @Parameter: 
     *  $encrypted_key 用户密钥
     *  @Return: 
     *  0|已过期或是非法的用户密钥
     *  $user_id|用户账户
    */ 
    public function CheckUserKey($encrypted_key){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        $CI->load->library('encrypt');
        $CI->load->library('basic');
        $encrypted_time = substr($CI->encrypt->decode($encrypted_key), 0, strlen(time()));
        //过期的密钥
        if (time() - $encrypted_time >= $CI->basic->user_key_life){
            return 0;
        }
        $encrypted_user_id = substr($CI->encrypt->decode($encrypted_key), strlen(time()));
        if (!ctype_digit($encrypted_user_id)){
            return 0;
        }
        return $encrypted_user_id;
    }
}
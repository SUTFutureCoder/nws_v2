<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 安全
 * 负责用户的密钥解密，权限验证，密码验证
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
     *  验证传入的时间是否正确   
     *  @Method Name:
     *  CheckDateTime($date_time)
     *  @Parameter: 
     *  $date_time 需要检测的date('Y-m-d H:i:s')时间 
     *  @Return: 
     *      0|不正确
     *      时间戳|正确
    */ 
    public function CheckDateTime($date_time){
        if (!preg_match("/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/",$date_time)){
            return 0;
        } else {
            return strtotime($date_time);            
        }
    }
    
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
     *  检验传入的用户id生成定时密钥   
     *  @Method Name:
     *  CreateUserKey($user_mixed) 
     *  @Parameter: 
     *  $user_mixed 用户user_id/user_telephone
     *  @Return: 
     *  0|无此用户或生成失败
     *  $user_key|加密用户密钥
    */ 
    public function CreateUserKey($user_mixed){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        $CI->load->library('secure');
        $CI->load->model('user_model');
        if ($user_mixed && ctype_digit($user_mixed)){
            if (!isset($user_mixed{11})){
                $user_id = $user_mixed;
            } else if (11 == strlen($user_mixed)){
                $user_id = $CI->user_model->TeleToId($user_mixed);
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        return $CI->encrypt->encode($user_key = time() . $user_id);
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
        
    /**    
     *  @Purpose:    
     *  检验传入的【移动端】用户密钥是否合法或过期   
     *  @Method Name:
     *  CheckMobileUserKey($encrypted_key) 
     *  @Parameter: 
     *  $encrypted_key 用户密钥
     *  @Return: 
     *  0|已过期或是非法的用户密钥
     *  $user_id|用户账户
    */ 
    public function CheckMobileUserKey($encrypted_key){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        $CI->load->library('encrypt');
        $CI->load->library('basic');
        $encrypted_time = substr($CI->encrypt->decode($encrypted_key), 0, strlen(time()));
        //过期的密钥
        if (time() - $encrypted_time >= $CI->basic->mobile_user_key_life){
            return 0;
        }
        $encrypted_user_id = substr($CI->encrypt->decode($encrypted_key), strlen(time()));
        if (!ctype_digit($encrypted_user_id)){
            return 0;
        }
        return $encrypted_user_id;
    }    
    
    /**    
     *  @Purpose:    
     *  检验传入的用户密码正确性   
     *  @Method Name:
     *  CheckUserPass($user_mixed, $user_password) 
     *  @Parameter: 
     *  $user_mixed 用户user_id或user_telephone
     *  $user_password 用户密码
     *  @Return: 
     *  0|查无此人
     *  1|(验证通过(返回key))
     *  2|用户已被安全锁定，请联系管理员解锁
     *  3|请等待5秒钟后重试
     *  4|密码有误
     *  5|无法获取用户权限
     * 
     *  
    */ 
    public function CheckUserPass($user_mixed, $user_password){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        $CI->load->library('encrypt');
        $CI->load->library('basic');
        $CI->load->model('user_model');
        $CI->load->database();
//        if (!isset($user_mixed{11})){
//            $user_id = $CI->user_model->TeleToId($user_mixed);
//        } else {
//            $user_id = $user_mixed;
//        }
        $CI->db->select('user_id, user_password, user_last_failure, user_continuity_fail, user_locked');        
        $CI->db->where('user_id', $user_mixed);
        $CI->db->or_where('user_telephone', $user_mixed);
        $query = $CI->db->get('user');
        if (!$query->num_rows()){
            return array(0 => 0, 1 => '查无此人');
        } 
        
        
        if ($query->row()->user_locked){
            return array(0 => 2, 1 => '用户已被安全锁定，请联系管理员解锁');
        }
        
        if (time() < $query->row()->user_last_failure + 5){
            return array(0 => 3, 1 => '请等待5秒钟后重试');
        }
            
        //验证失败
        if ($user_password != $CI->encrypt->decode($query->row()->user_password)){
            $user_locked = 0;
            if ($CI->basic->login_error_lock <= ++$query->row()->user_continuity_fail){
                $user_locked = 1;
            }
            $CI->db->where('user_id', $query->row()->user_id);
            $CI->db->update('user', array(
                'user_last_failure' => time(),
                'user_continuity_fail' => $query->row()->user_continuity_fail,
                'user_locked' => $user_locked
            ));
            return array(0 => 4, 1 => '原密码有误');
            //因为curl记录真实ip困难，所以暂时不设定login_ip
//            $this->db->insert('loginlog', array(
//                'user_mixed' => $user_mixed,
//                'login_time' => date('Y-m-d H:i:s'),
//                'login_ip' => 
//                'login_pass' => 0
//            ));
        } else {
            $CI->db->where('user_id', $query->row()->user_id);
            $CI->db->update('user', array(
                'user_continuity_fail' => 0
            ));
//            $this->db->insert('loginlog', array(
//                'user_mixed' => $user_mixed,
//                'login_time' => date('Y-m-d H:i:s'),
//                'login_ip' => 
//                'login_pass' => 1
//            ));
            return array(0 => 1, 1 => $this->CreateUserKey($user_mixed));
        }
        
    }
    
    /**    
     *  @Purpose:    
     *  更改密码   
     *  @Method Name:
     *  UpdateUserPass($user_mixed, $user_password) 
     *  @Parameter: 
     *  $user_mixed 用户user_id或user_telephone
     *  $user_password 用户密码
     *  @Return: 
     *  0|
     *  1|
     *  2|查无此人
     *  
     * 
     *  
    */ 
    public function UpdateUserPass($user_mixed, $user_password){
        //在自定义类库中初始化CI资源
        $CI =& get_instance();       
        $CI->load->library('encrypt');
        $CI->load->database();
//        if (!isset($user_mixed{11})){
//            $user_id = $CI->user_model->TeleToId($user_mixed);
//        } else {
//            $user_id = $user_mixed;
//        }
        $CI->db->select('user_id, user_password');        
        $CI->db->where('user_id', $user_mixed);
        $CI->db->or_where('user_telephone', $user_mixed);
        $query = $CI->db->get('user');
        if (!$query->num_rows()){
            return array(0 => 2, 1 => '查无此人');
        } 
        
        $CI->db->where('user_id', $query->row()->user_id);
        $CI->db->update('user', array(
            'user_password' => $CI->encrypt->encode($user_password)
        ));
        
        if (!$CI->db->affected_rows()){
            return array(0 => 0, 1 => '无法更改密码，可能已经最新');
        } else {
            return array(0 => 1, 1 => '修改成功');
        }      
    }
    
}
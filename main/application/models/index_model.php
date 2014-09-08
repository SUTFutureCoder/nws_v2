<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 套件的入口文件
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Index_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }


    /**    
     *  @Purpose:    
     *  登录验证   
     *  @Method Name:
     *  Login()    
     *  @Parameter: 
     *  u 工号
     *  p 密码
     *  ip 用户ip
     *  @Return: 
     *  json 状态码及状态说明
     *  状态码|状态
     *  1|登录成功
     *  2|用户已被安全锁定，请联系管理员解锁
     *  3|请等待5秒钟后重试
     *  4|密码有误
     *  5|权限不足
     *  6|查无此人
    */   
    function Login($u, $p, $ip)
    {
        $this->load->library('basic');
        $this->load->library('session');
        $this->load->library('encrypt');    
        $this->load->database();
        $this->db->where('user_number', $u);
        $query = $this->db->get('user');
        $result = array();
        $role = array();
        $data = array(
            'user_number' => $u,
            'login_time' => date("Y-m-d H:i:s"),
            'login_ip' => $ip,
            'login_pass' => 0
        );
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {              
                if ($u == $row['user_number']) {
                    if($row['user_locked'])
                    {
                        $result[0] = 2;
                        $result[1] = '用户已被安全锁定，请联系管理员解锁';
                        echo json_encode($result);
                        $this->db->close();
                        return 0;
                    }
                    if (time() < $row['user_last_failure'] + 5)
                    {
                        $result[0] = 3;
                        $result[1] = '请等待5秒钟后重试';
                        echo json_encode($result);
                        $this->db->close();
                        return 0;
                    }
                    /*if ($row['authorizee'] > 4)
                    {
                        return 5;   //权限不足
                    }*///三表联合查询
                    if ($p == $this->encrypt->decode($row['user_password'])) {
                        $this->session->set_userdata('user_number', $u);
                        //开始生成用户密钥
                        $user_key = time() . $u;
                        $this->session->set_userdata('user_key', $user_key);
                        $this->session->set_userdata('user_name', $row['user_name']);
                        //查询权限
                        $this->db->where('user_number', $row['user_number']);
                        $this->db->from('re_user_role');
                        $this->db->join('role', 'role.role_id = re_user_role.role_id');
                        $query = $this->db->get();
                        $role = array_merge($role, $query->result_array());
                        $this->session->set_userdata('user_role', $role[0]['role_name']);                        
                        
                        $data['login_pass'] = 1;
                        if ($row['user_continuity_fail'])
                        {
                            $repair['user_continuity_fail'] = 0;
                            $this->db->where('user_number', $row['user_number']);
                            $this->db->update('user', $repair);
                        }
                    } else {    //验证失败
                        $continuity_fail = ++$row['user_continuity_fail'];
                        $logfail = array(
                            'user_last_failure' => time(),
                            'user_continuity_fail' => $continuity_fail
                        );
                        $i = $this->basic->login_error_lock;    //为了2.0版做铺垫，可以单独放在某个配置文件中
                        if($row['user_continuity_fail'] >= $i)
                        {
                            $logfail['user_locked'] = 1;
                        }
                        $this->db->where('user_number', $row['user_number']);
                        $this->db->update('user', $logfail);
                        $data['login_pass'] = 0;
                    }
                }
            }
            $this->db->insert('loginlog', $data);
        }        
        else
        {
            $result[0] = 6;
            $result[1] = '查无此人';
            echo json_encode($result);
            $this->db->close();
            return 0;
        }
        
        $this->db->close();
        if ($data['login_pass']){
            $result[0] = 1;
            echo json_encode($result);
            $this->db->close();
            return 0;
        }
        else{
            $result[0] = 4;
            $result[1] = '密码有误';             
            echo json_encode($result);
            $this->db->close();
            return 0;
        }
    }
}
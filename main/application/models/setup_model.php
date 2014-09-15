<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 套件的安装模型文件
 * 数据库的部署
 * 管理员账户的录入
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Setup_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    public function SetupInit($clean)
    {
        //$this->load->database();
        $link = mysql_connect('localhost', $clean['db_username'], $clean['db_password']);
        mysql_query("CREATE DATABASE nwsapp");
        mysql_query("USE nwsapp");        
        $get_sql_data = file_get_contents('nwsapp.sql');
        $explode = explode(";",$get_sql_data);
        $cnt = count($explode);
        for ($i=0; $i < $cnt; ++$i){
            $sql = $explode[$i];
            $result = mysql_query($sql, $link);            
        }        
        mysql_close();
        
        $this->load->database();
        $data = array(
            'user_id' => 10000,
            'user_number' => $clean['user_number'],
            'user_password' => $clean['user_password'],
            'user_telephone' => $clean['user_telephone'],
            'user_name' => $clean['user_name'],
            'user_reg_time' => date("Y-m-d"),
            'user_qq' => '0'
        );
        $this->db->where('user_number', $data['user_number']);
        $this->db->or_where('user_id', 10000);
        $query = $this->db->get('user');
        if ($query->num_rows())
        {
            $clean['result'][0] = 12;
            $clean['result'][1] = '管理员账户添加失败,请检查数据库数据是否重复或非初始数据库';
            echo json_encode($clean['result']);
            return 0;
        }
        else
        {
            $this->db->insert('user', $data);
            $result = $this->db->affected_rows();
            if ($result)
            {
                $role = array();
                $this->db->select('role_id');
                $this->db->where('role_name', '管理员');
                $query = $this->db->get('role');                
                $role = $query->result_array();
                $re_u_r = array(
                    'role_id' => $role[0]['role_id'],
                    'user_id' => $data['user_id']
                );
                $this->db->insert('re_user_role', $re_u_r);
                $result = $this->db->affected_rows();  
            }
            else
            {
                return 0;
            }
            $this->db->close();
            return $result;
        }
    }
}
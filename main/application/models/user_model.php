<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 用于用户相关数据的设置和获取
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class User_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  根据用户学号获取用户基础信息   
     *  @Method Name:
     *  GetUserBasic($user_number)    
     *  @Parameter: 
     *  $user_number 已安检用户学号 
     *  @Return: 
     *  用户信息或0
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserBasic($user_number){
        $this->load->database();
        $data = array();
        $this->db->where('user_number', $user_number);
        $query = $this->db->get('user');
        if ($query->num_rows()){
            $data = array_merge($data, $query->result_array());
            return $data[0];
        }else {
            return 0;
        }
        
    }
    
    
    /**    
     *  @Purpose:    
     *  根据用户学号获取用户高级信息   
     *  @Method Name:
     *  GetUserProperty($user_number)    
     *  @Parameter: 
     *  $user_number 已安检用户学号 
     *  @Return: 
     *  用户信息或0
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserProperty($user_number){
        $this->load->database();
        $data = array();
        $this->db->where('user_pro_user_number', $user_number);
        $query = $this->db->get('user_property');
        if ($query->num_rows()){
            $data = array_merge($data, $query->result_array());
            return $data[0];
        }else {
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  获取用户部门   
     *  @Method Name:
     *  GetUserSection(user_number)    
     *  @Parameter: 
     *  $user_number 用户学号 
     *  @Return: 
     *      0|失败
     *      部门名称|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserSection($user_number){
        $this->load->database();        
        $this->db->from('re_user_section');
        $this->db->join('section', 'section.section_id = re_user_section.section_id');
        $this->db->where('re_user_section.user_number', $user_number);
        $query = $this->db->get();
        return $query->row()->section_name;
    }
    
    /**    
     *  @Purpose:    
     *  获取用户电话  
     *  @Method Name:
     *  GetUserTelephone(user_number)    
     *  @Parameter: 
     *  $user_number 用户学号 
     *  @Return: 
     *      0|失败
     *      电话号码|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserTelephone($user_number){
        $this->load->database();        
        $this->db->select('user_telephone');
        $this->db->where('user_number', $user_number);
        $query = $this->db->get('user');
        return $query->row()->user_telephone;
    }
    
    /**    
     *  @Purpose:    
     *  获取新部员统计信息  (总数和各个部门)
     *  包含新部员信息
     *  
     *  @Method Name:
     *  GetNewStat()    
     *  @Parameter: 
     *  @Return: 
     *  array data = array(
     *      'new_person_sum', '..._sum'
     *  );
     *  
     *  :NOTICE:已知新生录入时密码为0
    */ 
    public function GetNewStat(){
        $this->load->database();        
        //获取各部门新生数        
        $this->db->where('user_password', '0');
        $query = $this->db->get('user');
        $temp = $query->result_array();
        $data['new_person_sum'] = count($temp);        
        error_reporting(0);
        foreach ($temp as $temp_item){
            $this->db->where('re_user_section.user_number', $temp_item['user_number']);
            $this->db->from('re_user_section');
            $this->db->join('section', 'section.section_id = re_user_section.section_id');
            $query = $this->db->get();
            $temp_foreach = $query->result_array();
            ++$data['section'][$temp_foreach[0]['section_name']]; 
            $data['new_user_info'][$temp_foreach[0]['section_name']][] = $temp_item;
        }
        return $data;
                
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组修改用户基础信息   
     *  @Method Name:
     *  UpdateUserBasic($user_number, $data)    
     *  @Parameter: 
     *  $user_number 用户学号
     *  $data 已安检数据数组 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function UpdateUserBasic($user_number, $data){
        $this->load->database();
        $this->db->where('user_number', $user_number);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组修改用户高级信息   
     *  @Method Name:
     *  UpdateUserProperty($user_number, $data)    
     *  @Parameter: 
     *  $user_number 用户学号
     *  $data 已安检数据数组 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function UpdateUserProperty($user_number, $data){
        $this->load->database();
        $this->db->where('user_pro_user_number', $user_number);
        $this->db->update('user_property', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组设置用户部门关联   
     *  @Method Name:
     *  SetUserSection($user_number, $user_section)    
     *  @Parameter: 
     *  $user_number 用户学号
     *  $user_section 用户部门 （中文）
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必对部门值进行安检
    */ 
    public function SetUserSection($user_number, $user_section){
        $this->load->database();
        $this->db->where('section_name', $user_section);
        $query = $this->db->get('section');
        $data = array(
            'section_id' => $query->row()->section_id,
            'user_number' => $user_number
        );
        if (!$data['section_id']){
            return 0;
        }
        //查询是否重复录入
        $this->db->where('user_number', $user_number);
        $this->db->where('section_id', $data['section_id']);
        $query = $this->db->get('re_user_section');
        if ($query->num_rows()){
            return 1;
        }
//        $this->db->where('user_number', $user_number);
//        $this->db->set($data);
        $this->db->insert('re_user_section', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组设置用户角色关联   
     *  @Method Name:
     *  SetUserSection($user_number, $user_role)    
     *  @Parameter: 
     *  $user_number 用户学号
     *  $user_role 角色名称（中文） 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必对部门值进行安检
    */ 
    public function SetUserRole($user_number, $user_role){
        $this->load->database();
        $this->db->where('role_name', $user_role);
        $query = $this->db->get('role');
        $data = array(
            'role_id' => $query->row()->role_id,
            'user_number' => $user_number
        );
        if (!$data['role_id']){
            return 0;
        }
        //查询是否重复录入
        $this->db->where('user_number', $user_number);
        $this->db->where('role_id', $data['role_id']);
        $query = $this->db->get('re_user_role');
        if ($query->num_rows()){
            return 1;
        }
//        $this->db->where('user_number', $user_number);
//        $this->db->set($data);
        $this->db->insert('re_user_role', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入参数设置用户头像后缀名   
     *  @Method Name:
     *  SetPhotoExt($user_number, $file_ext)    
     *  @Parameter: 
     *  $user_number 用户学号
     *  $file_ext    用户头像图片后缀名
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function SetPhotoExt($user_number, $file_ext){
        $this->load->database();
        $this->db->where('user_pro_user_number', $user_number);
        $this->db->update('user_property', array('user_pro_photo_ext' => $file_ext));       
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组设置用户基本信息   
     *  @Method Name:
     *  SetUserBasic($data)    
     *  @Parameter: 
     *  $data = array(
     *      'user_number', 'user_name', 'user_telephone', 'user_qq', 'user_major', 'user_sex', 'user_talent', 'user_section', 'user_reg_time'
     *  )
     *  @Return: 
     *      0|失败
     *      1|成功
     *      2|以存在的部员
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function SetUserBasic($data){
        $this->load->database();
        if (isset($data['user_section'])){
            $this->SetUserSection($data['user_number'], $data['user_section']);
        }
        
        $this->db->select('user_number');     
        $this->db->where('user_number', $data['user_number']);
        $query = $this->db->get('user');
        if ($query->num_rows()){
            //将password改为1代表有冲突
            $this->db->where('user_number', $data['user_number']);
            $this->db->update('user', array('user_password' => '1'));
            return 2;
        }
        
        unset($data['user_section']);
        $this->db->insert('user', $data);
        $this->db->insert('user_property', array('user_pro_user_number' => $data['user_number']));
        return $this->db->affected_rows();
    }
    
}
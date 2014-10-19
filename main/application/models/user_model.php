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
     *  手机号码转用户id
     *  @Method Name:
     *  TeleToId($user_tele)
     *  @Parameter: 
     *  $user_tele 用户手机号码
     *  @Return: 
     *  0|失败，传入手机号码不存在或非法
     *  $user_id|用户$user_id
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function TeleToId($user_tele){
        $this->load->database();        
        
        if (!$user_tele || !ctype_digit($user_tele) || 11 != strlen($user_tele)){
            return 0;
        }
        $this->db->select('user_id');
        $this->db->where('user_telephone', $user_tele);
        $query = $this->db->get('user');        
        if ($query->num_rows()){
            return $query->row()->user_id;
        } else {
            return 0;
        }
    }
    
    
    /**    
     *  @Purpose:    
     *  验证学号是否重复   
     *  @Method Name:
     *  CheckNumberConflict($user_number)
     *  @Parameter: 
     *  $user_number 需检查的学号
     *  @Return: 
     *  1|重复
     *  0|不重复
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function CheckNumberConflict($user_number){
        $this->load->database();        
        $this->db->where('user_number', $user_number);
        $this->db->from('user');        
        return $this->db->count_all_results();
    }
    
    /**    
     *  @Purpose:    
     *  验证联系方式是否重复   
     *  @Method Name:
     *  CheckTeleConflict($user_id = null, $user_telephone)
     *  @Parameter: 
     *  $user_id 正常用户可能更新电话号码。必须把本人刨除
     *  $user_telephone 需检查的手机号码
     *  @Return: 
     *  1|重复,返回冲突的user_id
     *  0|不重复
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function CheckTeleConflict($user_id = NULL, $user_telephone){
        $this->load->database();        
        $this->db->select('user_telephone');
        $this->db->select('user_id');
        if ($user_id){
            $this->db->where('user_id !=', $user_id);
        } 
        $this->db->where('user_telephone', $user_telephone);
        $query = $this->db->get('user');        
        if ($query->num_rows()){
            return $query->row()->user_id;
        }
        return 0;
    }
    
    /**    
     *  @Purpose:    
     *  根据用户学号获取用户基础信息   
     *  @Method Name:
     *  GetUserBasic($user_id)    
     *  @Parameter: 
     *  $user_id 已安检用户账号
     *  @Return: 
     *  用户信息或0
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserBasic($user_id){
        $this->load->database();
        $data = array();
        $this->db->where('user_id', $user_id);
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
     *  GetUserProperty($user_id)    
     *  @Parameter: 
     *  $user_id 已安检用户学号 
     *  @Return: 
     *  用户信息或0
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserProperty($user_id){
        $this->load->database();
        $data = array();
        $this->db->where('user_id', $user_id);
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
     *  GetUserSection(user_id)    
     *  @Parameter: 
     *  $user_id 用户账号 
     *  @Return: 
     *      0|失败
     *      部门名称|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserSection($user_id){
        $this->load->database();        
        $this->db->from('re_user_section');
        $this->db->join('section', 'section.section_id = re_user_section.section_id');
        $this->db->where('re_user_section.user_id', $user_id);
        $query = $this->db->get();
        return $query->row()->section_name;
    }
    
    /**    
     *  @Purpose:    
     *  获取用户部门id   
     *  @Method Name:
     *  GetUserSectionId(user_id)    
     *  @Parameter: 
     *  $user_id 用户账号 
     *  @Return: 
     *      0|失败
     *      部门id|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserSectionId($user_id){
        $this->load->database();        
        $this->db->from('re_user_section');
        $this->db->join('section', 'section.section_id = re_user_section.section_id');
        $this->db->where('re_user_section.user_id', $user_id);
        $query = $this->db->get();
        return $query->row()->section_id;
    }
    
    /**    
     *  @Purpose:    
     *  获取用户电话  
     *  @Method Name:
     *  GetUserTelephone(user_id)    
     *  @Parameter: 
     *  $user_id 用户账号 
     *  @Return: 
     *      0|失败
     *      电话号码|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function GetUserTelephone($user_id){
        $this->load->database();        
        $this->db->select('user_telephone');
        $this->db->where('user_id', $user_id);
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
            $this->db->where('re_user_section.user_id', $temp_item['user_id']);
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
     *  UpdateUserBasic($user_id, $data)    
     *  @Parameter: 
     *  $user_id 用户账号
     *  $data 已安检数据数组 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function UpdateUserBasic($user_id, $data){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->update('user', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组修改用户高级信息   
     *  @Method Name:
     *  UpdateUserProperty($user_id, $data)    
     *  @Parameter: 
     *  $user_id 用户账号
     *  $data 已安检数据数组 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function UpdateUserProperty($user_id, $data){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->update('user_property', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入数组设置用户部门关联   
     *  @Method Name:
     *  SetUserSection($user_id, $user_section)    
     *  @Parameter: 
     *  $user_id 用户账号
     *  $user_section 用户部门 （中文）
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必对部门值进行安检
    */ 
    public function SetUserSection($user_id, $user_section){
        $this->load->database();
        $this->db->where('section_name', $user_section);
        $query = $this->db->get('section');
        $data = array(
            'section_id' => $query->row()->section_id,
            'user_id' => $user_id
        );
        if (!$data['section_id']){
            return 0;
        }
        //查询是否重复录入
        $this->db->where('user_id', $user_id);
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
     *  SetUserSection($user_id, $user_role)    
     *  @Parameter: 
     *  $user_id 用户账号
     *  $user_role 角色名称（中文） 
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必对部门值进行安检
    */ 
    public function SetUserRole($user_id, $user_role){
        $this->load->database();
        $this->db->where('role_name', $user_role);
        $query = $this->db->get('role');
        $data = array(
            'role_id' => $query->row()->role_id,
            'user_id' => $user_id
        );
        if (!$data['role_id']){
            return 0;
        }
        //查询是否重复录入
        $this->db->where('user_id', $user_id);
        $this->db->where('role_id', $data['role_id']);
        $query = $this->db->get('re_user_role');
        if ($query->num_rows()){
            return 1;
        }
//        $this->db->where('user_id', $user_id);
//        $this->db->set($data);
        $this->db->insert('re_user_role', $data);
        return $this->db->affected_rows();
    }
    
    /**    
     *  @Purpose:    
     *  根据传入参数设置用户头像后缀名   
     *  @Method Name:
     *  SetPhotoExt($user_id, $file_ext)    
     *  @Parameter: 
     *  $user_id 用户账号
     *  $file_ext    用户头像图片后缀名
     *  @Return: 
     *      0|失败
     *      1|成功
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function SetPhotoExt($user_id, $file_ext){
        $this->load->database();
        $this->db->where('user_id', $user_id);
        $this->db->update('user_property', array('user_pro_photo_ext' => $file_ext));       
    }
    
    
    /**
     * 
     * :NOTICE: 必须先执行SetUserBasic → SetUserRole → SetUserSection :NOTICE:
     * 
     */
    /**    
     *  @Purpose:    
     *  根据传入数组设置用户基本信息   
     *  @Method Name:
     *  SetUserBasic($data)    
     *  @Parameter: 
     *  $data = array(
     *      'user_id', 'user_name', 'user_telephone', 'user_qq', 'user_major', 'user_sex', 'user_talent', 'user_section', 'user_reg_time'
     *  )
     *  @Return: 
     *      0|失败
     *      1|成功,返回user_id
     *      2|以存在的部员
     * 
     *  :WARNING:在传参之前请务必进行安检
    */ 
    public function SetUserBasic($data){
        $this->load->database();    
        
//        
//        if ($conflict_user_id = $this->CheckTeleConflict(NULL, $data['user_telephone'])){
//            //将password改为1代表有冲突
//            $this->db->where('user_id', $conflict_user_id);
//            $this->db->where('user_telephone', );
//            $this->db->update('user', array('user_password' => '1'));
//            return 2;
//        }    
        
        
        unset($data['user_section']);
        $this->db->insert('user', $data);
        //同时也直接生成高级信息
        $this->db->insert('user_property', array('user_id' => $this->db->insert_id()));
        if ($this->db->affected_rows()){
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }
    
}
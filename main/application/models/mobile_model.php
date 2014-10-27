<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 移动端模型
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Mobile_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
        
    /**    
     *  @Purpose:    
     *  检查更新
     *  
     *  @Method Name:
     *  CheckUpdate($version)    
     *  @Parameter: 
     *  POST version 当前版本
     * 
     *  @Return: 
     *  0
     *  1|array(array('mobile_version_release', 'mobile_version_build', 'mobile_version_notice'));
     *      
    */
    public function CheckUpdate($version){
        $this->load->database();
        $this->db->select_max('mobile_version_build');
        $query = $this->db->get('mobile_version');
        if ($version >= $query->row()->mobile_version_build){
            return 0;
        } else {
            $this->db->where('mobile_version_build', $query->row()->mobile_version_build);
            $this->db->limit(1);
            $query = $this->db->get('mobile_version');
            return $query->result_array();
        }
    }
}
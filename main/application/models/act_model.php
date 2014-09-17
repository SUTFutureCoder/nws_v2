<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动相关数据交互
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    
    /**    
     *  @Purpose:    
     *  获取活动类型列表   
     *  @Method Name:
     *  GetActTypeList()    
     *  @Parameter: 
     *  
     *  @Return: 
     *     array(
     *      array(
     *     ));
     * 
     *  
    */ 
    public function GetActTypeList(){
        $this->load->database();
        
        $query = $this->db->get('activity_type');
        return $query->result_array();
    }
}

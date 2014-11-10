<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动签到（可以不登录）
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_checkin extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('act_checkin_view');        
    }
    
    /**    
     *  @Purpose:    
     *  移动端活动列表查询
     *  
     *  @Method Name:
     *  MobileGetActList()    
     *  @Parameter: 
     *  POST user_key 用户密钥
     *  POST user_id  用户id
     *  POST current  查询分页起始位置
     *  POST limit    偏移量
     *  POST standard_id 基准活动id
     *  POST up 查询方向
     *     
     *  @Return: 
     *  状态码|状态
     *      $data
     *      -1|密钥无法通过安检
     *      -2|起点id格式错误
     *      -3|偏移量格式错误
     *      -4|基准活动id值格式错误
     *      -5|获取数据方向错误
     * 
     * :NOTICE:当起点id为0的时候，则从最大活动id开始向上获取数据。:NOTICE:
     * :NOTICE:当最大活动id为0的时候，则从起点id开始向下获取数据。:NOTICE:
     * 
    */
    
    
}
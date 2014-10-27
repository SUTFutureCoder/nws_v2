<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 移动端相关基础方法
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Mobile_basic extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  检查更新
     *  
     *  @Method Name:
     *  CheckUpdate()    
     *  @Parameter: 
     *  POST app_key 应用密钥
     *  POST version 当前版本
     * 
     *  @Return: 
     *  状态码|
     *  -1|版本号类型错误
     *  -2|密钥错误
     *  0|已是最新
     *  1|下载地址
     * 
     *      
    */
    public function CheckUpdate(){
        $this->load->library('basic');
        $this->load->library('data');
        if ($this->basic->app_key != $this->input->post('app_key', TRUE)){
            $this->data->Out('update', -2, '密钥错误');
        }
        
        if (!is_numeric($this->input->post('version', TRUE))){
            $this->data->Out('update', -1, '版本号类型错误');
        }
        
        if ($this->basic->mobile_version > $this->input->post('version', TRUE)){
            $this->data->Out('update', 1, $this->basic->mobile_version, $this->basic->mobile_download);
        }else {
            $this->data->Out('update', 0);
        }
    }
    
    
}
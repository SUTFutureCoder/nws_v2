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
         
class Index extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    /**    
     *  @Purpose:    
     *  安装界面和登录界面的切换    
     *  @Method Name:
     *  Index()    
     *  @Parameter: 
     *     
     *  @Return: 
     *  
     * :WARNING: 请不要地址末尾加上index.php打开 :WARNING:
    */
    public function Index()
    {           
        $this->load->library('basic');
        $this->load->model('index_model');
        if (!file_exists('application/config/database.php'))
        {
            $this->load->view('setup_view');
            return 0;
        }      
        //$index['organ_name'] = $this->basic->organ_name;
        $this->load->view('login_view', array('organ_name' => $this->basic->organ_name));
    }
    
    /**    
     *  @Purpose:    
     *  密码验证并后续处理    
     *  @Method Name:
     *  PassCheck()    
     *  @Parameter: 
     *  post user_mixed 用户账户或手机号码
     *  post user_password 用户密码    
     *  @Return: 
     *  json 状态码及状态说明
    */
    public function PassCheck(){
        $this->load->library('basic');        
        $this->load->model('index_model');
        if ($this->input->post('user_mixed',TRUE) && $this->input->post('user_password', TRUE))
        {
            $clean = array();
            if (ctype_digit($this->input->post('user_mixed', TRUE)) && 11 >= strlen($this->input->post('user_mixed', TRUE)))
            {
                $clean['user_mixed'] = $this->input->post('user_mixed', TRUE);
            }else {
                $clean['result'][0] = 0;
                $clean['result'][1] = '您输入的账号或手机号码必须是小于等于11位的的整数';
                echo json_encode($clean['result']);
                return 0;
            }
            
            if (iconv_strlen($this->input->post('user_password', TRUE), 'utf-8') <= 20)
            {
                $clean['user_password'] = $this->input->post('user_password', TRUE);
            }
            else
            {
                $clean['result'][0] = 0;
                $clean['result'][1] = "您输入的密码不能超过20个字符";
                echo json_encode($clean['result']);
                return 0;
            }
            if (isset($_SERVER)){
                if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                    $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $realip = $_SERVER["HTTP_CLIENT_IP"];
                } else {
                    $realip = $_SERVER["REMOTE_ADDR"];
                }
            } else {
                if (getenv("HTTP_X_FORWARDED_FOR")){
                    $realip = getenv("HTTP_X_FORWARDED_FOR");
                } else if (getenv("HTTP_CLIENT_IP")) {
                    $realip = getenv("HTTP_CLIENT_IP");
                } else {
                    $realip = getenv("REMOTE_ADDR");
                }
            }
            $this->index_model->Login($clean['user_mixed'], $clean['user_password'], ip2long($realip));
            return 0;
        }        
    }

}
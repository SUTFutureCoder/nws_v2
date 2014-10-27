<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 基础信息储存文件
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Basic
{   
    //此处填写社团名称
    public $organ_name = '沈阳工业大学网络管理中心';
    
    //学号长度
    public $user_number_length = 9;
    
    //此处填写登录失败重试锁定次数
    public $login_error_lock = 30;
    
    //此处填写user_key用户密钥生效时限(前端以小时为单位，转换后写入文件)推荐不小于2小时
    public $user_key_life = 43200;
    
    //此处填写移动端user_key用户密钥生效时限[移动端](前端以小时为单位，转换后写入文件)
    public $mobile_user_key_life = 2592000;
        
    //最新版下载位置
    public $mobile_download = '';
    
    //应用密钥
    public $app_key = 'ALLHAILNWS!';
    
    
}

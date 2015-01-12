<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 套件的安装文件
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/

class Setup extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    

    /**    
     *  @Purpose:    
     *  控制面板安装部署
     *  生成applications/config/database.php
     *  修改applications/libraries/Basic.php
     *  修改applications/config/config.php
     *  管理员信息插入数据库
     *  @Method Name:
     *  SetupInit()    
     *  @Parameter: 
     *  POST user_number 管理员工号
     *  POST user_password 管理员密码
     *  POST user_password_confirm 管理员密码确认
     *  POST db_username 数据库账户
     *  POST db_password 数据库密码  
     *  :NOTICE: 初始用户id从10000开始 :NOTICE:  
     *  @Return: 
     *  json 状态码及状态说明
     *      状态码|状态
     *      1|安装成功
     *      2|请检查您的工号[最大位数不超过20位]
     *      3|两次密码输入不一致
     *      4|密码不能为空
     *      5|数据库用户名出错
     *      6|原始配置文件未找到，请重新下载
     *      7|生成配置文件无法写入数据
     *      8|为保护数据库安全，请您5秒钟后重试
     *      9|连接错误，请检查您的数据库账户
     *      10|您的服务器不支持Mysql，请联系服务器管理员
     *      11|数据库密码不合法，请检查
     *      12|管理员账户添加失败
     *      13|密码必须为非空格的可打印字符且不多于18个字符
     *      14|社团名称不应超过100个字符
     *      15|管理员电话号码出错，必须为11位
     *      16|姓名不能超过十个字符
     
    */        
    public function SetupInit()
    {
        $this->load->model('setup_model');
        $this->load->library('encrypt');
        $clean = array();
        $user_number = $this->input->post('user_number', TRUE);
        //用户名极限为20个数字字符
        if ($user_number && ctype_digit($user_number) && !isset($user_number{21}))
        {
            $clean['user_number'] = $user_number;
        }
        else
        {
            $clean['result'][0] = 2;
            $clean['result'][1] = '请检查您的工号[只允许小于等于20位的数字]';
            echo json_encode($clean['result']);
            return 0;
        }
        
        if ($this->input->post('user_name', TRUE) && iconv_strlen($this->input->post('user_name', TRUE), 'utf-8') <= 10)
        {
            $clean['user_name'] = $this->input->post('user_name', TRUE);
        }
        else
        {
            $clean['result'][0] = 16;
            $clean['result'][1] = '姓名不能超过十个字符';
            echo json_encode($clean);
            return 0;
        }
        
        $user_password = $this->input->post('user_password', TRUE);
        $user_password_confirm = $this->input->post('user_password_confirm', TRUE);
        
        if ($user_password && $user_password_confirm)
        {
            if ($user_password !== $user_password_confirm)
            {
                $clean['result'][0] = 3;
                $clean['result'][1] = '两次密码输入不一致';
                echo json_encode($clean['result']);
                return 0;
            }

            if (ctype_graph($user_password) && iconv_strlen($user_password, 'utf-8') <= 18)
            {
                $clean['user_password'] = $this->encrypt->encode($user_password);
            }    
            else
            {
                $clean['result'][0] = 13;
                $clean['result'][1] = '密码为非空格且不多于18个字符';
                echo json_encode($clean['result']);
                return 0;
            }
        }
        else
        {
            $clean['result'][0] = 4;
            $clean['result'][1] = '密码不能为空';
            echo json_encode($clean['result']);
            return 0;
        }
        
        
        $user_telephone = $this->input->post('user_telephone', TRUE);
        
        if (ctype_digit($user_telephone) && 11 == strlen($user_telephone))
        {
            $clean['user_telephone'] = $user_telephone;
        }
        else
        {
            $clean['result'][0] = 15;
            $clean['result'][1] = '管理员电话号码出错，必须为11位';
            echo json_encode($clean['result']);
            return 0;
        }
        
        $db_username = $this->input->post('db_username', TRUE);
        
        if (ctype_graph($db_username) && $db_username)
        {
            $clean['db_username'] = $db_username;
        }
        else
        {
            $clean['result'][0] = 5;
            $clean['result'][1] = '数据库用户名出错';
            echo json_encode($clean['result']);
            return 0;
        }
        
        $organ_name = $this->input->post('organ_name', TRUE);
        if ($organ_name && iconv_strlen($organ_name, 'utf-8') <= 100)
        {
            $clean['organ_name'] = $organ_name;
        }
        else
        {
            $clean['result'][0] = 14;
            $clean['result'][1] = '社团名称不应超过100个字符';
            echo json_encode($clean['result']);
            return 0;
        }
        
        $db_password = $this->input->post('db_password', TRUE);
        
        if (ctype_graph($db_password) && $db_password)
        {
            $clean['db_password'] = $db_password;
            if (function_exists("mysql_close") == 1)
            {
                error_reporting(0);
                //进行数据库连接检查
                $link_test = mysql_connect('localhost', $db_username, $db_password);
                if ($link_test)
                {
                    //开始生成配置文件
                    
                    if (!($file_content = file('application/config/database_raw.php')))
                    {
                        $clean['result'][0] = 6;
                        $clean['result'][1] = '原始配置文件未找到，请重新下载';
                        echo json_encode($clean['result']);
                        return 0;
                    }
                    
                    $file_content_basic = file('application/libraries/Basic.php');
                    if (file_exists('application/config/database.php'))
                    {
                        unlink('application/config/database.php');
                    }
                    if (copy('application/config/database_raw.php', 'application/config/database.php'))
                    {
                        //写入数据库文件
                        $file_content[50] .= "\$db['default']['username'] = '" . $clean['db_username'] . "';";
                        $file_content[51] .= "\$db['default']['password'] = '" . $clean['db_password'] . "';";
                        $new_content = '';
                        foreach ($file_content as $v)
                        {
                            $new_content .= $v;
                        }
                        
                        
                            
                        if (!(file_put_contents('application/config/database.php', $new_content) ))
                        {                            
                            $clean['result'][0] = 7;
                            $clean['result'][1] = '生成配置文件无法写入数据[阶段一]';
                            echo json_encode($clean['result']);
                            return 0;
                        }
                        else
                        {
                            //改写框架config.php文件第17行对于base_url的定义
                            //随机生成五位config中基础加密密钥
                                                        
                            $rand_key = null;
                            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
                            $strPol_max_length = strlen($strPol) - 1;
                            for ($i = 0; $i < 5; ++$i){
                                $rand_key .= $strPol[rand(0, $strPol_max_length)];
                            }
                            
                            $file_content_config = file('application/config/config.php');
                            $file_content_config[16] = "\$config['base_url']	= '" . $this->input->post('base_url', TRUE) . "';\n";
                            $file_content_config[226] = "\$config[\'encryption_key\'] = '" . $rand_key . "';\n";
                            $new_content_config = '';
                            foreach ($file_content_config as $v)
                            {
                                $new_content_config .= $v;
                            }
                            
                            if (!(file_put_contents('application/config/config.php', $new_content_config) ))
                            {
                                $clean['result'][0] = 7;
                                $clean['result'][1] = '生成配置文件无法写入数据[阶段二]';
                                echo json_encode($clean['result']);
                                return 0;
                            }
                            else
                            {
                                //改写library中的basic基础变量库
                                $file_content_basic[17] = "    public \$organ_name = '" . $organ_name . "';\n";
                                $new_content_basic = '';
                                foreach ($file_content_basic as $v)
                                {
                                    $new_content_basic .= $v;
                                }
                                if (!(file_put_contents('application/libraries/Basic.php', $new_content_basic)))
                                {
                                    $clean['result'][0] = 7;
                                    $clean['result'][1] = '生成配置文件无法写入数据[阶段三]';
                                    echo json_encode($clean['result']);
                                    return 0;
                                }
                            }
                            
                            $clean['user_id'] = 10000;
                            //注册管理员账户（务必在更改完毕配置文件后进行）
                            $result = $this->setup_model->SetupInit($clean);
                            if ($result)
                            {
                                $clean['result'][0] = 1;
                                $clean['result'][1] = '恭喜，您已成功安装' . $clean['organ_name'] . '控制面板，非常感谢您的使用！\\n\\n\\n\\n您的账号为10000';
                                $clean['result'][2] = $this->input->post('base_url', TRUE);
                                echo json_encode($clean['result']);
                                return 0;                                
                            }
                            else
                            {
                                $clean['result'][0] = 12;
                                $clean['result'][1] = '管理员账户添加失败,请检查数据库数据是否正常';
                                echo json_encode($clean['result']);
                                return 0; 
                            }

                        }
                    }   
                }
                else
                {
                    if (time() - $this->session->userdata('last_fail') <= 5)
                    {
                        $clean['result'][0] = 8;
                        $clean['result'][1] = '为保护数据库安全，请您5秒钟后重试';
                        echo json_encode($clean['result']);
                        return 0;
                    }
                    else
                    {
                        $clean['result'][0] = 9;
                        $clean['result'][1] = '连接错误，请检查您的数据库账户';
                        echo json_encode($clean['result']);
                        return 0;
                    }
                    $this->session->set_userdata('last_fail', time());                    
                }              
            }
            else
            {
                $clean['result'][0] = 10;
                $clean['result'][1] = '您的服务器不支持Mysql，请联系服务器管理员';
                echo json_encode($clean['result']);
                return 0;
            }
            error_reporting(1);
        }
        else
        {
                $clean['result'][0] = 11;
                $clean['result'][1] = '数据库密码不合法，请检查';
                echo json_encode($clean['result']);
                return 0;
        }
    }
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动添加
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_add extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        $this->load->model('section_model');
        $this->load->model('user_model');
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_add', $this->session->userdata('user_id'))){
            echo ('<script>alert(\'用户无权限\')</script>');
            return 0;            
        }
        
        $section_select = '';
        if (!$this->authorizee->CheckAuthorizee('act_global_add', $this->session->userdata('user_id'))){
            $section_select = $this->user_model->GetUserSection($this->session->userdata('user_id'));
        }
        
        $this->load->view('act_add_view', array(
            'user_id' => $this->session->userdata('user_id'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'type' => $this->act_model->GetActTypeList(),
            'section' => $this->section_model->GetSectionNameList(),
            'authorizee_act_global_add' => $this->user_model->GetUserSection($this->session->userdata('user_id')),
            'section_select' => $section_select
        ));
    }
    
    /**    
     *  @Purpose:    
     *  活动增加
     *  
     *  @Method Name:
     *  ActAdd()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      'act_name' 活动名字
     *      'act_private' 社团内部活动
     *      'act_type' 活动类型
     *      'act_section_only' 部门限制
     *      'act_content' 活动内容
     *      'act_warn' 活动注意事项
     *      'act_start' 活动开始时间
     *      'act_end' 活动截止时间
     *      'act_money' 活动所需资金
     *      'act_position' 活动地点
     *      'act_member_sum' 活动总人数限制
     *  )   
     *  @Return: 
     *  状态码|状态
     *      0|密钥无法通过安检
     *      1|添加成功
     *      2|活动名称不可为空或超过198个字符
     *      3|活动类型不存在或超过48个字符
     *      4|部门名称不存在或超过28个字符
     *      5|活动描述不可为空或超过998个字符
     *      6|活动注意事项超过998个字符
     *      7|活动开始时间不合法，请尝试把输入法关闭
     *      8|活动结束时间不合法，请尝试把输入法关闭
     *      9|需要资金格式为小于10位的整数
     *      10|活动地点不能超过198个字符
     *      11|加入人数限制必须为小于10位的数字
     *      12|添加失败
     *      13|用户无权限
     *      14|用户无添加其他部门活动的权限
     *      15|内部活动传值错误
     *      
     * 
    */
    public function ActAdd(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        $this->load->model('section_model');
        $this->load->model('user_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_add', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 13, '用户无权限');
        }
        
        $data = array();
        $data['activity']['act_user_id'] = $this->input->post('user_id', TRUE);
        
        if (!$this->input->post('act_name', TRUE) || 198 < iconv_strlen($this->input->post('act_name', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '活动名称不可为空或超过198个字符');
        }
        $data['activity']['act_name'] = $this->input->post('act_name', TRUE);
        
        switch ($this->input->post('act_private', TRUE)){
            case 'true':
                $data['activity']['act_private'] = 1;
                break;
            case 'false':
                $data['activity']['act_private'] = 0;
                break;
            default :
                $this->data->Out('iframe', $this->input->post('src', TRUE), 15, '社团内部活动传值错误');
        }        
        
        if (!$this->input->post('act_type', TRUE) ||
                !$this->act_model->CheckTypeExist($this->input->post('act_type', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 3, '活动类型不存在');
        }
        $data['re_activity_type']['type_id'] = $this->act_model->TypeToId($this->input->post('act_type', TRUE));
        
        if (!$this->input->post('act_section_only', TRUE) || 
                ( !$this->section_model->CheckSectionExist($this->input->post('act_section_only', TRUE)) &&
                '不限制' != $this->input->post('act_section_only', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 4, '部门名称不存在');
        }
        
        if ('不限制' == $this->input->post('act_section_only', TRUE)){
            $data['re_activity_section']['section_id'] = $this->user_model->GetUserSectionId($this->input->post('user_id', TRUE));
            $data['activity']['act_global'] = 1;
        } else {
            if (!$this->authorizee->CheckAuthorizee('act_global_add', $this->input->post('user_id', TRUE)) && 
                $this->user_model->GetUserSection($this->input->post('user_id', TRUE)) != $this->input->post('act_section_only', TRUE)){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 14, '用户无添加其他部门活动的权限');
            }
            $data['re_activity_section']['section_id'] = $this->section_model->GetSectionId($this->input->post('act_section_only', TRUE));
        }
        
        if (!$this->input->post('act_content', TRUE) || 998 < iconv_strlen($this->input->post('act_content', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 5, '活动描述不可为空或超过998个字符', 'act_content');
        }
        $data['activity']['act_content'] = $this->input->post('act_content', TRUE);
        
        if ($this->input->post('act_warn', TRUE)){
            if (998 < iconv_strlen($this->input->post('act_warn', TRUE), 'utf-8')){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 6, '活动注意事项超过998个字符', 'act_warn');
            }
            $data['activity']['act_warn'] = $this->input->post('act_warn', TRUE);
        }        
        
        if (!$this->input->post('act_start', TRUE) || (!$this->secure->CheckDateTime($this->input->post('act_start', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 7, '活动开始时间格式不合法，请尝试把输入法关闭', 'act_start');
        }        
        $data['activity']['act_start'] = $this->input->post('act_start', TRUE);
        
        if (!$this->input->post('act_end', TRUE) ||  (time() > $this->secure->CheckDateTime($this->input->post('act_end', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 8, '活动结束时间不能低于当前时间，请尝试把输入法关闭', 'act_end');
//            $this->data->Out('iframe', $this->input->post('src', TRUE), 8, $this->secure->CheckDateTime($this->input->post('act_start', TRUE)), 'act_end');
        }
        $data['activity']['act_end'] = $this->input->post('act_end', TRUE);
        
        if ($this->input->post('act_money', TRUE)){
            if (!ctype_digit($this->input->post('act_money', TRUE)) || 
                    10 < strlen($this->input->post('act_money', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 9, '需要资金格式为小于10位的整数', 'act_money');
            }
            $data['activity']['act_money'] = $this->input->post('act_money', TRUE);
        }
        
        if (!$this->input->post('act_position', TRUE) || 198 < iconv_strlen($this->input->post('act_position', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 10, '活动地点不能超过198个字符', 'act_position');
        }
        $data['activity']['act_position'] = $this->input->post('act_position', TRUE);
        
        if ($this->input->post('act_member_sum', TRUE)){
            if (!ctype_digit($this->input->post('act_member_sum', TRUE)) || 
                    10 < strlen($this->input->post('act_member_sum', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 11, '加入人数限制必须为小于10位的数字', 'act_member_sum');
            }
            $data['activity']['act_member_sum'] = $this->input->post('act_member_sum', TRUE);
        }
        
        $act_id = $this->act_model->AddAct($data);
        if (!$act_id){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 12, '添加失败');
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, '添加成功', $act_id);
        }
    }
    
    /**    
     *  @Purpose:    
     *  广播_实时活动插入
     *  
     *  @Method Name:
     *  B_ActListInsert()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码,
     *      'user_id'   用户id,
     *      'act_id'    活动id
     *  )   
     *  @Return: 
     *  状态码|状态
     * 
     *      
     *      
     * :NOTICE:禁止错误反馈:NOTICE:
     * :NOTICE:用户要有删除活动的权限:NOTICE:
    */
    public function B_ActListInsert(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        $this->load->model('section_model');
        $this->load->model('user_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            return 0;
        }
        
        if (!ctype_digit($this->input->post('act_id', TRUE))){
            return 0;
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_add', $this->input->post('user_id', TRUE))){
            return 0;
        }       
       
        if (!$this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            return 0;
        }
        $act_data = $this->act_model->GetActList(0, 1, $this->input->post('act_id', TRUE) - 1);
        
        if ($act_data){
            $this->data->Out('group', $this->input->post('src', TRUE), 1, 'B_ActListInsert' ,$act_data);
        }
    }
    
}
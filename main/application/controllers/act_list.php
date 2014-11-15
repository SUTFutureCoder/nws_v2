<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 活动列表
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Act_list extends CI_Controller{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->library('authorizee');
        $this->load->model('section_model');
        $this->load->model('act_model');
        if (!$this->session->userdata('user_id')){
            header('Location: ' . base_url());
            return 0;
        }
        //权限获取
        
        $this->load->view('act_list_view', array(
            'user_id' => $this->session->userdata('user_id'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key')),
            'authorizee_act_update' => $this->authorizee->CheckAuthorizee('act_update', $this->session->userdata('user_id')),
            'authorizee_act_dele' => $this->authorizee->CheckAuthorizee('act_dele', $this->session->userdata('user_id')),
            'authorizee_act_global_list' => $this->authorizee->CheckAuthorizee('act_global_list', $this->session->userdata('user_id')),
            'authorizee_act_propagator' => $this->authorizee->CheckAuthorizee('act_propagator', $this->session->userdata('user_id')),
            'act_global_add' => $this->authorizee->CheckAuthorizee('act_global_add', $this->session->userdata('user_id')),
            'act_section' => $this->section_model->GetSectionNameList(),
            'act_type' => $this->act_model->GetActTypeList()
        ));
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
    public function MobileGetActList(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        
        $data = array();
        if (!ctype_digit($this->input->post('current', TRUE))){
            $this->data->Out('notice', -2, '起点id格式错误');
        }
        
        if (!ctype_digit($this->input->post('limit', TRUE))){
            $this->data->Out('notice', -3, '偏移量格式错误');
        }
        
        if (!ctype_digit($this->input->post('standard_id', TRUE))){
            $this->data->Out('notice', -4, '基准活动id值格式错误');
        }
        
        if (!$this->input->post('user_id', TRUE) && !$this->input->post('user_key', TRUE)){
            //游客
            $data = $this->act_model->GetActList($this->input->post('current', TRUE), $this->input->post('limit', TRUE), $this->input->post('standard_id', TRUE), 1);
        } else {
            //社员
            if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
                $this->data->Out('iframe', -1, '密钥无法通过安检');
            }            
            $data = $this->act_model->GetActList($this->input->post('current', TRUE), $this->input->post('limit', TRUE), $this->input->post('standard_id', TRUE), 0);
        }
        $this->data->Out('RedrawActList', $data);
    }
    
    
    /**    
     *  @Purpose:    
     *  移动端初始化活动列表查询
     *  
     *  @Method Name:
     *  MobileGetActListInit()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码【可选】
     *      'user_id'  用户id【可选】
     *      'limit'     偏移量
     *      )
     *  )   
     *  @Return: 
     *  状态码|状态
     *      -1|密钥无法通过安检
     *      -2|用户无权限
     *      -3|偏移量错误
     *      1|array $data = array ();
     * 
    */
    public function MobileGetActListInit(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        
        if (!ctype_digit($this->input->post('limit', TRUE))){
            $this->data->Out('notice', -3, '偏移量格式错误');
        }
        
        if ($this->input->post('user_id', TRUE) && $this->input->post('user_key', TRUE)){
            if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
                $this->data->Out('iframe', -1, '密钥无法通过安检');
            }

            if (!$this->authorizee->CheckAuthorizee('act_global_list', $this->input->post('user_id', TRUE))){
                $this->data->Out('iframe', -2, '用户无权限');
            }
        } else {
            $data = $this->act_model->GetActList(0, $this->input->post('limit', TRUE), NULL, 1);
        }
        
        
        
        
        
        $this->data->Out('GetActListInit', $data);
    }
    
    
    /**    
     *  @Purpose:    
     *  初始化活动列表查询
     *  
     *  @Method Name:
     *  GetActGlobeListInit()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      'user_id'  用户id
     *      )
     *  )   
     *  @Return: 
     *  状态码|状态
     *      0|密钥无法通过安检
     *      1|array $data = array ();
     *      2|用户无权限
     * 
    */
    public function GetActGlobeListInit(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_global_list', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), 2, '用户无权限');
        }
        
        //初始化列表，从1开始拉取到20.无需再次设计函数        
        $data = $this->act_model->GetActList(0, 20);
        $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'GetActGlobeInit', $data);
    }
    
    
    /**    
     *  @Purpose:    
     *  获取活动详细信息
     *  
     *  @Method Name:
     *  GetActInfo()    
     *  @Parameter: 
     *  POST array(
     *      'user_key'  用户识别码
     *      'user_id'   用户id
     *      'act_id'    活动id
     *      )
     *  )   
     *  @Return: 
     *  状态码|状态
     *      -1|密钥无法通过安检
     *      -2|活动id传值错误
     *      -3|活动不存在
     *      -4|用户没有查看已删除活动的权限
     *      
     * 
    */
    public function GetActInfo(){
        $this->load->library('secure');  
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
        }
        
        //从这里开始，错误代码改为-数
        if (!ctype_digit($this->input->post('act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '活动id传值错误');
        }
        
        //验证活动是否存在
        if (!$this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '活动不存在');
        }    
        
        $data = $this->act_model->GetActInfo($this->input->post('act_id', TRUE));
        
        if ($data[0]['act_defunct'] && !$this->authorizee->CheckAuthorizee('act_read_dele', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -4, '用户没有查看已删除活动的权限');
        }
        
        $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'GetActInfo', $data[0]);
    }
        
    /**    
     *  @Purpose:    
     *  重绘活动列表
     *  
     *  @Method Name:
     *  RedrawActList()    
     *  @Parameter: 
     *  POST array(
     *      'user_key'  用户识别码
     *      'user_id'   用户id
     *      'max_act_id'先前最大的活动id
     *      )
     *  @Return: 
     *  状态码|状态
     *     
     *      
     *      
     * 
    */
    public function RedrawActList(){
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_global_list', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '用户无权限');
        }
        
        if (!ctype_digit($this->input->post('max_act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '先前最大的活动id不合法');
        }        
        
        $data = $this->act_model->GetActList(0, 1000, $this->input->post('max_act_id', TRUE));
        $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'RedrawActList', $data);
    }
        
    /**    
     *  @Purpose:    
     *  活动修改
     *  
     *  @Method Name:
     *  ActUpdate()    
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
     *      -1|密钥无法通过安检
     *      -2|用户无权限
     *      -3|活动id不合法
     *      -4|活动id不存在
     *      -5|活动名称不可为空或超过198个字符
     *      
     * 
    */
    public function ActUpdate(){
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        $this->load->model('section_model');
        $this->load->model('user_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_update', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '用户无权限');
        }
        
        if (!ctype_digit($this->input->post('act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '活动id不合法');
        }        
        
        if (!$this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -4, '活动id不存在');
        }
        
        $data = array();        
        if (!$this->input->post('act_name', TRUE) || 198 < iconv_strlen($this->input->post('act_name'), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -5, '活动名称不可为空或超过198个字符');
        }
        $data['activity']['act_name'] = $this->input->post('act_name', TRUE);
        
        switch ($this->input->post('act_private')){
            case 'true':
                $data['activity']['act_private'] = 1;
                break;
            case 'false':
                $data['activity']['act_private'] = 0;
                break;
            default :
                $this->data->Out('iframe', $this->input->post('src', TRUE), -6, '社团内部活动传值错误');                
        }
        
        if (!$this->input->post('act_type', TRUE) || 
                !$this->act_model->CheckTypeExist($this->input->post('act_type', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -7, '活动类型不存在');
        }
        $data['re_activity']['type_id'] = $this->act_model->TypeToId($this->input->post('act_type', TRUE));
        
        if (!$this->input->post('act_section_only', TRUE) || 
                ( !$this->section_model->CheckSectionExist($this->input->post('act_section_only', TRUE)) &&
                '不限制' != $this->input->post('act_section_only', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -8, '部门名称不存在');
        }
        
        if ('不限制' == $this->input->post('act_section_only', TRUE)){
            $data['re_activity_section']['section_id'] = $this->user_model->GetUserSectionId($this->input->post('user_id', TRUE));
            $data['activity']['act_global'] = 1;
        } else {
            if (!$this->authorizee->CheckAuthorizee('act_global_add', $this->input->post('user_id', TRUE)) && 
                $this->user_model->GetUserSection($this->input->post('user_id', TRUE)) != $this->input->post('act_section_only', TRUE)){
                $this->data->Out('iframe', $this->input->post('src', TRUE), -9, '用户无添加其他部门活动的权限');
            }
            $data['re_activity_section']['section_id'] = $this->section_model->GetSectionId($this->input->post('act_section_only', TRUE));
        }
        
        if (!$this->input->post('act_content', TRUE) || 998 < iconv_strlen($this->input->post('act_content', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -10, '活动描述不可为空或超过998个字符', 'act_content');
        }
        $data['activity']['act_content'] = $this->input->post('act_content', TRUE);
        
        if ($this->input->post('act_warn', TRUE)){
            if (998 < iconv_strlen($this->input->post('act_warn', TRUE), 'utf-8')){
                $this->data->Out('iframe', $this->input->post('src', TRUE), -11, '活动注意事项超过998个字符', 'act_warn');
            }
            $data['activity']['act_warn'] = $this->input->post('act_warn', TRUE);
        }        
        
        if (!$this->input->post('act_start', TRUE) || (!$this->secure->CheckDateTime($this->input->post('act_start', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -12, '活动开始时间格式不合法，请尝试把输入法关闭', 'act_start');
        }        
        $data['activity']['act_start'] = $this->input->post('act_start', TRUE);
        
        if (!$this->input->post('act_end', TRUE) ||  (time() > $this->secure->CheckDateTime($this->input->post('act_end', TRUE)))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -13, '活动结束时间不能低于当前时间，请尝试把输入法关闭', 'act_end');
//            $this->data->Out('iframe', $this->input->post('src', TRUE), 8, $this->secure->CheckDateTime($this->input->post('act_start', TRUE)), 'act_end');
        }
        $data['activity']['act_end'] = $this->input->post('act_end', TRUE);
        
        if ($this->input->post('act_money', TRUE)){
            if (!ctype_digit($this->input->post('act_money', TRUE)) || 
                    10 < strlen($this->input->post('act_money', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), -14, '需要资金格式为小于10位的整数', 'act_money');
            }
            $data['activity']['act_money'] = $this->input->post('act_money', TRUE);
        }
        
        if (!$this->input->post('act_position', TRUE) || 198 < iconv_strlen($this->input->post('act_position', TRUE), 'utf-8')){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -15, '活动地点不能超过198个字符', 'act_position');
        }
        $data['activity']['act_position'] = $this->input->post('act_position', TRUE);
        
        if ($this->input->post('act_member_sum', TRUE)){
            if (!ctype_digit($this->input->post('act_member_sum', TRUE)) || 
                    10 < strlen($this->input->post('act_member_sum', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), -16, '加入人数限制必须为小于10位的数字', 'act_member_sum');
            }
            $data['activity']['act_member_sum'] = $this->input->post('act_member_sum', TRUE);
        }
        
        $act_id = $this->act_model->AddAct($data);
        if (!$act_id){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -17, '修改失败');
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'ActUpdate', $act_id);
        }
    }
        
    /**    
     *  @Purpose:    
     *  删除活动
     *  
     *  @Method Name:
     *  ActDele()    
     *  @Parameter: 
     *  POST array(
     *      'user_key'  用户识别码
     *      'user_id'   用户id
     *      'act_id'    活动id
     *      )
     *  @Return: 
     *  状态码|状态
     *      -1|密钥无法通过安检
     *      -2|用户无权限
     *      -3|活动id不合法
     *      -4|活动不存在
     *      1|$act_id
     *      0|无法再次删除
     *      
     *      
     * 
    */
    public function ActDele(){
        $this->load->library('secure');
        $this->load->library('data');
        $this->load->library('authorizee');
        $this->load->model('act_model');
        if ($this->input->post('user_id', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -1, '密钥无法通过安检');
        }
        
        if (!$this->authorizee->CheckAuthorizee('act_dele', $this->input->post('user_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -2, '用户无权限');
        }
        
        if (!ctype_digit($this->input->post('act_id', TRUE))){
            $this->data->Out('iframe', $this->input->post('src', TRUE), -3, '活动id不合法');
        }        
        
        if ($this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            if ($this->act_model->ActDele($this->input->post('act_id', TRUE))){
                $this->data->Out('iframe', $this->input->post('src', TRUE), 1, 'ActDele', $this->input->post('act_id', TRUE));
            } else {
                $this->data->Out('iframe', $this->input->post('src', TRUE), 0, '无法再次删除');
            }
        } else {
            $this->data->Out('iframe', $this->input->post('src', TRUE), -4, '活动id不存在');
        }
    }
    
    /**    
     *  @Purpose:    
     *  广播_实时活动删除
     *  
     *  @Method Name:
     *  B_ActListDele()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      'user_id'   用户id
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
    public function B_ActListDele(){
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
        
        if (!$this->authorizee->CheckAuthorizee('act_dele', $this->input->post('user_id', TRUE))){
            return 0;
        }        
        
        if (!$this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            return 0;
        }

        $this->data->Out('group', $this->input->post('src', TRUE), 1, 'B_ActListDele', $this->input->post('act_id', TRUE));
    }
    
    /**    
     *  @Purpose:    
     *  广播_实时活动更新
     *  
     *  @Method Name:
     *  B_ActListUpdate()    
     *  @Parameter: 
     *  POST array(
     *      'user_key' 用户识别码
     *      'user_id'   用户id
     *      'act_id'    活动id
     *  )   
     *  @Return: 
     *  0|NULL【不广播】 <-异常时
     *  更新活动信息 <-正常
     *      
     *      
     * :NOTICE:禁止错误反馈:NOTICE:
     * :NOTICE:用户要有修改活动的权限:NOTICE:
    */
    public function B_ActListUpdate(){
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
        
        if (!$this->authorizee->CheckAuthorizee('act_update', $this->input->post('user_id', TRUE))){
            return 0;
        }        
        
        if (!$this->act_model->CheckIdExist($this->input->post('act_id', TRUE))){
            return 0;
        }
        
        $data = $this->act_model->GetActInfo($this->input->post('act_id', TRUE));

        $this->data->Out('group', $this->input->post('src', TRUE), 1, 'B_ActListUpdate', $data);
    }
    
}
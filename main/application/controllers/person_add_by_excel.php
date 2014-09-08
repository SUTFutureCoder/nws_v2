<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * 使用离线excel表格招新
 * 
 * 
 *
 * @copyright  版权所有(C) 2014-2014 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen
 * @license    http://www.gnu.org/licenses/gpl-3.0.txt   GPL3.0 License
 * @version    2.0
 * @link       http://acm.sut.edu.cn/
 * @since      File available since Release 2.0
*/
class Person_add_by_excel extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }
    
    public function index(){
        $this->load->library('encrypt');
        $this->load->library('session');
        if (!$this->session->userdata('user_number')){
            header('Location: ' . base_url());
            return 0;
        }
        $this->load->view('person_add_by_excel_view', array(
            'user_number' => $this->session->userdata('user_number'),
            'user_key' => $this->encrypt->encode($this->session->userdata('user_key'))
        ));
    }
    
     /**    
     *  @Purpose:    
     *  生成标准招新表格
      * 
     *  @Method Name:
     *  GetExcelDefault()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  标准招新报名表.xlsx
    */        
    public function GetExcelDefault(){
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('basic');
        $this->load->library('PHPExcel');
        $excel = new PHPExcel();
        $clean = array();
        if (!$this->session->userdata('user_number')){
            header('Location: ' . base_url());
            return 0;
        }      
        $clean['user_name'] = $this->session->userdata('user_name');
        $clean['user_number'] = $this->session->userdata('user_number');
        $clean['user_section'] = $this->user_model->GetUserSection($this->session->userdata('user_number'));
        $clean['user_telephone'] = $this->user_model->GetUserTelephone($this->session->userdata('user_number'));
        $clean['date'] = date("Y-m-d H:i:s");
        
        $excel_writer = new PHPExcel_Writer_Excel2007($excel);                
        $clean['file_name'] = "{$this->basic->organ_name}{$clean['user_section']}招新表-{$clean['user_name']}-{$clean['date']}.xlsx";
    
    
        $excel->getProperties()->setCreator("{$clean['user_section']}-{$clean['user_name']}")
            ->setTitle("{$this->basic->organ_name}{$clean['user_section']}招新表-负责人:{$clean['user_name']}");

            $excel->setActiveSheetIndex(0)->setCellValue('A1', '招新部门')
                    ->setCellValue('B1', $clean['user_section'])
                    ->setCellValue('C1', '负责人')
                    ->setCellValue('D1', $clean['user_name'])
                    ->setCellValue('E1', '学号')
                    ->setCellValue('F1', $clean['user_number'])
                    ->setCellValue('G1', '联系方式')
                    ->setCellValue('H1', $clean['user_telephone'])
    //              ->mergeCells('I1:J1')
                    ->setCellValue('A2', '学号')
                    ->setCellValue('B2', '姓名')
                    ->setCellValue('C2', '电话')
                    ->setCellValue('D2', 'QQ')
                    ->setCellValue('E2', '专业')
                    ->setCellValue('F2', '性别')
                    ->setCellValue('G2', '特长')
                    //->setCellValue('H2', '密码')
                    ->setCellValue('H2', '打分');
            
            $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(TRUE);
            $excel->getActiveSheet()->getStyle('G1')->getFont()->setBold(TRUE);


            $excel->setActiveSheetIndex(0)->getColumnDimension('F')->setAutoSize(TRUE);
            $excel->setActiveSheetIndex(0)->getColumnDimension('H')->setAutoSize(TRUE);


            header("Content-Type: application/force-download");  
            header("Content-Type: application/octet-stream");  
            header("Content-Type: application/download");  
            header('Content-Disposition:inline;filename="'.$clean['file_name'].'"');  
            header("Content-Transfer-Encoding: binary");  
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
            header("Pragma: no-cache");  
            
            $excel_writer->save('php://output');
    }
    
     /**    
     *  @Purpose:    
     *  获取全体新部员名单表格
      * 
     *  @Method Name:
     *  GetFinalExcelAll()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  [$organ_name][date('Y')]全体新部员名单.xlsx
    */        
    public function GetFinalExcelAll(){        
        $this->load->library('session');
        $this->load->library('basic');
        $this->load->library('secure');
        $this->load->library('PHPExcel');
        $this->load->model('user_model');
        $this->load->model('section_model');
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode('密钥无法通过安检');
            return 0;
        }
        
        $excel = new PHPExcel();
        $clean = array();
        if (!$this->session->userdata('user_number')){
            header('Location: ' . base_url());
            return 0;
        }              
        
        $excel_writer = new PHPExcel_Writer_Excel2007($excel);                
        $clean['file_name'] = "{$this->basic->organ_name}" . date('Y') . "全体新部员名单.xlsx";
    
    
        $excel->getProperties()->setTitle("{$this->basic->organ_name}" . date('Y') . "全体新部员名单");
            
        $excel->getActiveSheet()->mergeCells('A1:F1');
        $excel->setActiveSheetIndex(0)->setCellValue('A1', $this->basic->organ_name . date('Y') . '全体新部员名单');
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
        
        //保存中文部门名称
        $section_name = array();
        $section_name = $this->section_model->GetSectionNameList();
        //记录当前行
        $current_row = 2;
        //++$data['section'][$temp_foreach[0]['section_name']]
        //$data['new_user_info'][$temp_foreach[0]['section_name']][] = $temp_item;
        $new_user_info = $this->user_model->GetNewStat();
        foreach ($section_name as $section_name_item){
            $section_id = $this->section_model->GetSectionId($section_name_item['section_name']);
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $current_row, $section_name_item['section_name']);
            $excel->getActiveSheet()->getStyle('A' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $current_row, $new_user_info['section'][$section_name_item['section_name']]);
            $excel->getActiveSheet()->getStyle('B' . $current_row)->getFont()->setBold(TRUE);
            ++$current_row;
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $current_row, '姓名');
            $excel->getActiveSheet()->getStyle('A' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $current_row, '专业');
            $excel->getActiveSheet()->getStyle('B' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $current_row, '联系方式');
            $excel->getActiveSheet()->getStyle('C' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $current_row, 'QQ');
            $excel->getActiveSheet()->getStyle('D' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $current_row, '性别');
            $excel->getActiveSheet()->getStyle('E' . $current_row)->getFont()->setBold(TRUE);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $current_row, '特长');
            $excel->getActiveSheet()->getStyle('F' . $current_row)->getFont()->setBold(TRUE);
            ++$current_row;
            foreach ($new_user_info['new_user_info'][$section_name_item['section_name']] as $new_user_item){
                $excel->setActiveSheetIndex(0)->setCellValue('A' . $current_row, $new_user_item['user_name']);
                $excel->setActiveSheetIndex(0)->setCellValue('B' . $current_row, $new_user_item['user_major']);
                $excel->setActiveSheetIndex(0)->setCellValue('C' . $current_row, $new_user_item['user_telephone']);
                $excel->setActiveSheetIndex(0)->setCellValue('D' . $current_row, $new_user_item['user_qq']);
                $excel->setActiveSheetIndex(0)->setCellValue('E' . $current_row, $new_user_item['user_sex']);
                $excel->setActiveSheetIndex(0)->setCellValue('F' . $current_row, $new_user_item['user_talent']);
                ++$current_row;
            }
        }
            header("Content-Type: application/force-download");  
            header("Content-Type: application/octet-stream");  
            header("Content-Type: application/download");  
            header('Content-Disposition:inline;filename="'.$clean['file_name'].'"');  
            header("Content-Transfer-Encoding: binary");  
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");  
            header("Pragma: no-cache");  
            
            $excel_writer->save('php://output');
    }
    
   
    /**    
     *  @Purpose:    
     *  回传标准招新表格
     * 
     *  @Method Name:
     *  UploadExcelDefault()    
     *  @Parameter: 
     *  
     *  @Return: 
     *  标准招新报名表.xlsx
    */       
    public function UploadExcelDefault(){
        ini_set('error_log', 'errors/error_log.txt');
        $this->load->library('encrypt');
        $this->load->library('secure');
        $this->load->library('basic');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('user_model');
        
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode('密钥无法通过安检');
            return 0;
        }
        $config = array();
        $config['upload_path'] = 'upload/person_list/';
        $config['allowed_types'] = 'xlsx';
        $this->load->library('upload', $config);
        
        if(!$this->upload->do_upload())
        {
            echo json_encode(array($this->upload->display_errors()));
        }
        else
        {
            $file_data = array();            
            $file_data = $this->upload->data();
            //$clean['result'] = $file_data['file_name'];          
            $file_path = "upload/person_list/{$file_data['file_name']}";
            $this->load->library('PHPExcel');          
            
            $excel = new PHPExcel();
            $excel_reader = new PHPExcel_Reader_Excel2007();            
            if(!$excel_reader->canRead($file_path))
            {
                $excel_reader = new PHPExcel_Reader_Excel5();
                if(!$excel_reader->canRead($file_path))
                {
                    echo json_encode('未找到Excel文档');
                    return 0;
                }
            }
            
            $clean['user_number'] = $this->input->post('user_number', TRUE);
            
            $clean['date'] = date("Y-m-d H:i:s");           
             
            $excel = $excel_reader->load($file_path);
            $current_sheet = $excel->getSheet(0);
            $all_column = $current_sheet->getHighestColumn();
            $all_row = $current_sheet->getHighestRow();
            $clean['result_all'] = "";
            $clean['re_log'] = "";
            $succ_insert = 0;
           
            $val = array();
            $upload = array();
            $all_column = ord($all_column) - 65;
            $upload['user_section'] = $current_sheet->getCellByColumnAndRow(1, 1)->getValue();
            for($current_row = 3; $current_row <= $all_row; $current_row++)
            {
                    //$val = $current_sheet->getCellByColumnAndRow(2, $current_row)->getValue();
                    //$val = $current_sheet->getCellByColumnAndRow(ord($current_column) - 65, $current_row)->getValue();                    
                    //$clean['result'] = $clean['result'] . $val;
                    //echo $val;             
                for($i = 0; $i <= $all_column; $i++)
                {
                    $val[$i] = $current_sheet->getCellByColumnAndRow($i, $current_row)->getValue();
                }
                
                $val[0] = (int)$val[0];
                if($val[0])
                {
                    if(ctype_digit($val[0]) && strlen($val[0]) == $this->basic->user_number_length)
                    {
                        $upload['user_number'] = $val[0];
                    }
                    else
                    {
                        echo json_encode($current_row . '行学号不合法:必须为' . $this->basic->user_number_length . '位数');
                        return 0;
                    }
                }
                else
                {
                    echo json_encode($current_row . '行学号不能为空');
                    return 0;
                }
                
                if($val[1])
                {
                    if(iconv_strlen($val[1], 'utf-8') <= 8)
                    {
                        $upload['user_name'] = $val[1];
                    }
                    else
                    {
                        echo json_encode($current_row . '行姓名不合法:必须小于8个字符');
                        return 0;
                    }
                }
                else
                {
                    echo json_encode($current_row . '行姓名不能为空');
                    return 0;
                }
                
                $val[2] = (int)$val[2];
                if($val[2])
                {
                    if(ctype_digit((int)$val[2]) && strlen($val[2]) == 11)
                    {
                        $upload['user_telephone'] = $val[2];
                    }
                    else
                    {
                        echo json_encode($current_row . '行联系方式不合法:必须为11位数');
                        return 0;
                    }
                }
                else
                {
                    echo json_encode($current_row . '行联系方式不能为空');
                    return 0;
                }
                
                $val[3] = (int)$val[3];
                if($val[3])
                {
                    if(ctype_digit((int)$val[3]) && strlen($val[3]) <= 14)
                    {
                        $upload['user_qq'] = $val[3];
                    }
                    else
                    {
                        echo json_encode($current_row . '行QQ不合法:必须小于14位数');
                        return 0;
                    }
                }

                if($val[4])
                {
                    if(iconv_strlen($val[4], 'utf-8') <= 48)
                    {
                        $upload['user_major'] = $val[4];
                    }
                    else
                    {
                        echo json_encode($current_row . '行专业不合法:必须小于等于48个字符');
                        return 0;
                    }
                }
                else
                {
                    echo json_encode($current_row . '行专业不能为空');
                    return 0;
                }
                
                if($val[5])
                {
                    if(iconv_strlen($val[5], 'utf-8') <= 2)
                    {
                        $upload['user_sex'] = $val[5];
                    }
                    else
                    {
                        echo json_encode($current_row . '行性别不合法:必须小于等于两个字符');
                        return 0;
                    }
                }
                else
                {
                    echo json_encode($current_row . '行性别不能为空');
                    return 0;
                }
                
                if($val[6])
                {
                    if(iconv_strlen($val[6], 'utf-8') <= 998)
                    {
                        $upload['user_talent'] = $val[6];
                    }
                    else
                    {
                        echo json_encode($current_row . '行特长不合法:必须小于998个字符');
                        return 0;
                    }
                }

//                if($val[7])
//                {
//                    $upload['password'] = $this->encrypt->encode($val[7]);
//                }
//                else
//                {
//                    echo json_encode($current_row . '行密码不能为空');
//                    return 0;
//                }
//                                
                
                
                $upload['user_reg_time'] = date("Y-m-d");                    
                $upload['user_password'] = '0';
                
                $result = $this->user_model->SetUserBasic($upload);
                if($result == 2)
                {
                    $clean['re_log'] = $clean['re_log'] . $current_row . '行学号重复';
                    //$result = $this->person_add_by_excel_model->person_section_conflict($upload);
                    if($result)
                    {
                        $clean['re_log'] = $clean['re_log'] . '，自动录入多部门重录数据库<br/>';
                    }
                    else
                    {
                        $clean['re_log'] = $clean['re_log'] . '，同时被多部录取<br/>';
                    }
                    continue;
                }
                else
                {
                    $succ_insert++;
                }
            }        
            
            $clean['succ_insert'] = '<br/>' . $succ_insert . "条新数据成功录入<br/>";
            echo json_encode(array(
                0 => '1',
                1 => '上传并添加成功<br/>' . $clean['re_log'] . $clean['succ_insert'])
            );            
            return 0;
        }
    }
    
    /**    
     *  @Purpose:    
     *  获取部门冲突列表   
     *  @Method Name:
     *  GetSectionConflict()    
     *  @Parameter: 
     *  POST user_key 用户密钥
     *  POST user_number 用户学号
     *  @Return: 
     *  iframe|目标|状态码|返回值
     *   | |0|密钥无法通过安检
     *   | |1|二维数组
     *   | |2|学号位数不合法
     *   | |3|无部门录用冲突记录
     * 
     * :WARNING:尚未进行权限验证
    */   
    public function GetSectionConflict(){
        $this->load->library('encrypt');
        $this->load->library('secure');
        $this->load->model('user_model');
        $this->load->model('section_model');
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 0,
                '3' => '密钥无法通过安检'
            ));
            return 0;
        }
        
        if ($this->basic->user_number_length != strlen($this->input->post('user_number', TRUE)) || 
                !ctype_digit($this->input->post('user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 2,
                '3' => '学号位数不合法，应为' . $this->basic->user_number_length . '位'
            ));
            return 0;
        }
        
        $conflict = array();
        if ($conflict = $this->section_model->GetSectionConflict($this->input->post('user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 1,
                '3' => $conflict
            ));
            return 0;     
        }else {
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 3,
                '3' => '无部门录用冲突记录'
            ));
            return 0;
        }
           
    }
    
    /**    
     *  @Purpose:    
     *  获取新部员统计数据   
     *  @Method Name:
     *  GetNewStat()    
     *  @Parameter: 
     *  POST user_key 用户密钥
     *  POST user_number 用户学号
     *  @Return: 
     *  iframe|目标|状态码|返回值
     *   | |0|密钥无法通过安检
     *   | |21|二维数组
     *   | |2|学号位数不合法
     * 
     * 
    */   
    public function GetNewStat(){
        $this->load->library('encrypt');
        $this->load->library('secure');
        $this->load->model('user_model');
        $this->load->model('section_model');
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 0,
                '3' => '密钥无法通过安检'
            ));
            return 0;
        }
        
        if ($this->basic->user_number_length != strlen($this->input->post('user_number', TRUE)) || 
                !ctype_digit($this->input->post('user_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 2,
                '3' => '学号位数不合法，应为' . $this->basic->user_number_length . '位'
            ));
            return 0;
        }
        
        $final = array();
        $final = $this->user_model->GetNewStat();
        echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 21,
                '3' => $final
            ));
            return 0;
        
           
    }
    
    /**    
     *  @Purpose:    
     *  判定部门冲突   
     *  @Method Name:
     *  JudgeSectionConflict()    
     *  @Parameter: 
     *  POST user_key 用户密钥
     *  POST user_number 用户学号
     *  @Return: 
     *  iframe|目标|状态码|返回值
     *   | |0|密钥无法通过安检
     *   | |2|学号位数不合法
     *   | |11|裁决成功的用户学号
     *   | |12|裁决失败
     *   | |13|传入的部门值错误
     * 
     * :WARNING:尚未进行权限验证
    */   
    public function JudgeSectionConflict(){
        $this->load->library('encrypt');
        $this->load->library('secure');
        $this->load->model('user_model');
        $this->load->model('section_model');
        if ($this->input->post('user_number', TRUE) != $this->secure->CheckUserKey($this->input->post('user_key', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 0,
                '3' => '密钥无法通过安检'
            ));
            return 0;
        }
        
        if ($this->basic->user_number_length != strlen($this->input->post('user_number', TRUE)) || 
                !ctype_digit($this->input->post('user_number', TRUE)) || 
                $this->basic->user_number_length != strlen($this->input->post('user_conflict_number', TRUE)) ||
                !ctype_digit($this->input->post('user_conflict_number', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 2,
                '3' => '学号位数不合法，应为' . $this->basic->user_number_length . '位'
            ));
            return 0;
        }
        
        if (iconv_strlen($this->input->post('user_section', TRUE), 'utf-8') >= 30  || 
                !$this->section_model->CheckSectionExist($this->input->post('user_section', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 13,
                '3' => '传入的部门值错误'
            ));
            return 0;
        }
        
        if (!$this->section_model->JudgeSectionConflict($this->input->post('user_conflict_number', TRUE), $this->input->post('user_section', TRUE))){
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 12,
                '3' => '裁决失败'
            ));
            return 0;
        }else {
            echo json_encode(array(
                '0' => 'iframe',
                '1' => $this->input->post('src', TRUE),
                '2' => 11,
//                '3' => '裁决成功'
                '3' => $this->input->post('user_conflict_number', TRUE)
            ));
            return 0;
        }
           
    }
    
    
}
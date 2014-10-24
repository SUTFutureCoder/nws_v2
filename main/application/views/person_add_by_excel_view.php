<!DOCTYPE html>  
<html>  
<head>  
    <title></title>             
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">  
    <style>
.dashboard_target_box {
	width:100%;
	height:200px;
	border:3px dashed #E5E5E5;
	text-align:center;
	position:relative;
	z-index:2000;	
	cursor:pointer
}
.dashboard_target_box.over {
	border:3px dashed #000;
	background:#ffa
}
.dashboard_target_messages_container {
	display:inline-block;
	margin:12px 0 0;
	position:relative;
	text-align:center;
	height:44px;
	overflow:hidden;
	z-index:2000
}
.dashboard_target_box_message {
	position:relative;
	margin:4px auto;
	font:15px/18px helvetica, arial, sans-serif;
	font-size:15px;
	color:#999;
	font-weight:normal;
	width:150px;
	line-height:20px
}
.dashboard_target_box.over #dtb-msg1 {
	color:#000;
	font-weight:bold
}
.dashboard_target_box.over #dtb-msg3 {
	color:#ffa;
	border-color:#ffa
}
#dtb-msg2 {
	color:orange
}
#dtb-msg3 {
	display:block;
	border-top:1px #EEE dotted;
	padding:8px 24px
}
</style>
<script>
var fileList;
$(function(){
    
    $('#drop_zone_home').hover(function(){
            $(this).children('p').stop().animate({top:'0px'},200);
    },function(){
            $(this).children('p').stop().animate({top:'-44px'},200);
    });
    
    //要想实现拖拽，首页需要阻止浏览器默认行为，一个四个事件。
    $(document).on({
            dragleave:function(e){		//拖离
                    e.preventDefault();
                    $('.dashboard_target_box').removeClass('over');
            },
            drop:function(e){			//拖后放
                    e.preventDefault();
            },
            dragenter:function(e){		//拖进
                    e.preventDefault();
                    $('.dashboard_target_box').addClass('over');
            },
            dragover:function(e){		//拖来拖去
                    e.preventDefault();
                    $('.dashboard_target_box').addClass('over');
            }
    });

    var box = document.getElementById('target_box'); //获得到框体

    box.addEventListener("drop",function(e){

        e.preventDefault(); //取消默认浏览器拖拽效果

        fileList = e.dataTransfer.files; //获取文件对象
        //fileList.length 用来获取文件的长度（其实是获得文件数量）        
        //检测是否是拖拽文件到页面的操作        
        if(fileList.length == 0){
                $('.dashboard_target_box').removeClass('over');
                return;
        }
        //检测文件是不是图片        
//        if(fileList[0].type.indexOf('image') === -1){
//                $('.dashboard_target_box').removeClass('over');
//                alert('请插入标准格式的图片');
//                return;
//        }

        xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function(){
            
            if(xhr.readyState==4 && xhr.status==200){  
                console.log(xhr.responseText);
                var result = JSON.parse(xhr.responseText);
                console.log(result);   
                if (result[0] != 1){
                    alert(result);
                }else {
                    $(".upload_mess").remove();
                    $(".upload_info").after("<div class=\"alert alert-info upload_mess\" role=\"alert\">" + result[1] + "</div>")
                }
                
            }

        }	        
        xhr.open("post", location.href + "/UploadExcelDefault", true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

        var fd = new FormData();
        fd.append('userfile', fileList[0]);
        fd.append('user_id', '<?= $user_id?>');
        fd.append('user_key', '<?= $user_key?>');
        xhr.send(fd);

    },false);
	
});
</script>
<script>
    $(function(){
        $("#conflict_tab").click(function(){
            $("#conflict").empty();
            var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/GetSectionConflict';
            data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"}';
            parent.IframeSend(data);
        }); 
        
        $("#final_tab").click(function(){   
            $("#final_stat").empty();
            var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/GetNewStat';
            data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"}';
            parent.IframeSend(data);           
        });
    });   
</script>
</head>
<ul class="nav nav-tabs" role="tablist" id="myTab">
<li class="active"><a href="#get" role="tab" data-toggle="tab">获取Excel表格</a></li>
<li><a href="#upload_all" role="tab" data-toggle="tab">上传本部全表</a></li>
<li><a href="#conflict" id="conflict_tab" role="tab" data-toggle="tab">部门录用冲突仲裁</a></li>
<li><a href="#upload" role="tab" data-toggle="tab">上传负责部员表格</a></li>
<li><a href="#final" id="final_tab" role="tab" data-toggle="tab">获取招新最终统计表格</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade active in" id="get">
    <hr>
    <form action="<?= base_url('/index.php/person_add_by_excel/GetExcelDefault')?>" method="post">
        <input type="hidden" name="get2007" value="1">
        <input type="submit" class="btn btn-primary btn-lg btn-block" value="获取标准Excel2007招新表格">
        <br/>
    </form>
    
    <form method="post">
        <input type="hidden" name="get_responsible" value="1">
        <input type="submit" class="btn btn-success btn-lg btn-block" value="获取负责部员登记表格">
        <br/>
    </form>
    <!--<form method="post">
        <input type="hidden" name="get2003" value="1">
        <input type="submit" class="btn btn-success" value="获取标准Excel2003表格">
        <br/>
    </form>
    安装WPS无法上传
    -->
</div>
        
<div class="tab-pane fade" id="upload_all">
    <hr>
    
    <div class="alert alert-success upload_info" role="alert">总表允许您分批上传、更新部员数据</div>

        <div id="target_box" class="dashboard_target_box">
            <div id="drop_zone_home" class="dashboard_target_messages_container">
                <p id="dtb-msg2" class="dashboard_target_box_message" style="top:-44px">选择你的文件<br>
                    开始上传</p>
                <p id="dtb-msg1" class="dashboard_target_box_message" style="top:-44px">拖动文件到<br>
                    这里</p>
                </p>
            </div>
        </div>
        <br/>
</div>

    
<div class="tab-pane fade" id="upload">
    <h3 style="color: red">请注意：您所上传的文档中为您未来负责的部员且成功后无法更改，请按以下步骤进行操作</h3>
    <h4 style="color: red">①重新打开上传文档，仔细检查C1【负责人】和页面左上方的登录用户名是否一致</h4>
    <h4 style="color: red">②再次确认您所上传文档为您负责的部员，【而不是】全体成员</h4>
    <h4 style="color: red">③一旦上传将无法更改,本页面成功使用后自动销毁【失败可重试】</h4>
    
    

<?php echo form_open_multipart('person_add_by_excel/do_upload');?>

        <input type="file" class="btn btn-default" name="userfile" size="20" />
        <input type="hidden" name="upload" value="1"><br/><br/><br/>
        <input type="submit" class="btn btn-danger" value="上传【负责部分部员】Excel表格">
        <br/>
    </form>
</div>
    
<div class="tab-pane fade" id="conflict">
    
</div>    
        
<div class="tab-pane fade col-sm-10 col-sm-offset-1" id="final">
    <br/>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">招新统计</h3>
        </div>
        <div class="panel-body" id="final_stat">
            
                
            
            
        </div>
    </div>
</div>    
</div>
</body>
    
<script>
    $('#myTab a').click(function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
</script>
<script>
    //判定部门
    function ConflictJudge(user_conflict_id, user_section){
        var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/JudgeSectionConflict';
            data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id?>", "user_conflict_id" : "' + user_conflict_id + '", "user_section" : "' + user_section + '"}';
            parent.IframeSend(data);
    }
    //接收母窗口传来的值
    function MotherResultRec(data){
        console.log(data);
        switch (data[2]){
            case 1:
                var length = data[3]['user'].length; 
                for (var i = 0; i < length; i++){
    //                console.log(data[3]['user']);
                    $('#conflict').append('<div class=' + data[3]['user'][i]['user_id'] + '><table class="table table-hover" id="' + data[3]['user'][i]['user_id'] + '"></table></div>');                
                    $('#' + data[3]['user'][i]['user_id']).append('<thead><tr style="font-size:20px"><th class="col-sm-1">' + data[3]['user'][i]['user_name'] + '</th><th class="col-sm-1">' + 
                            data[3]['user'][i]['user_major'] + '</th><th class="col-sm-2">' + data[3]['user'][i]['user_telephone']  + '</th><th  class="col-sm-8">' + 
                            data[3]['user'][i]['user_talent'] + '</th></tr></thead>');
                    $('.' + data[3]['user'][i]['user_id']).append('<hr/>');
                }

                var length = data[3]['section'].length; 
                for (var i = 0; i < length; i++){
    //                console.log(data[3]['user']);
                    $('#' + data[3]['section'][i]['user_id']).append('<tbody><tr style="font-size:18px;"><td colspan="2"><strong>' + data[3]['section'][i]['section_name'] + '</strong></td><td colspan="2"><button type="button" onclick="ConflictJudge(' + data[3]['section'][i]['user_id'] + ',\'' + data[3]['section'][i]['section_name'] + '\')" class="btn btn-danger btn-block">判定至' + data[3]['section'][i]['section_name'] + '</button></td></tr></tbody>');
                }
            break;
            
            case 2:
            case 12:
            case 13:
                alert(data[3]);
            break;
            
            case 3:
                $('#conflict').empty();
                $('#conflict').append('<div class="alert alert-success" role="alert">' + data[3] + '</div>');
            break;
            
            //裁决成功
            case 11:
                $("." + data[3]).animate({height:"0px"}, 1000);
                setTimeout("$(\"." + data[3] + "\").toggle()", 1000);
//                $("#" + data[3]).remove();
            break;  
            
            //招新统计
            case 21:
                $("#new_sum").html();
                $("#final_stat").append("<h3 class=\"text-center\">新生总人数:<a id=\"new_sum\">" + data[3]['new_person_sum'] + "</a></h3>");
                $("#final_stat").append("<form action=\"<?= base_url('/index.php/person_add_by_excel/GetFinalExcelAll')?>\" method=\"post\"><input type=\"hidden\" name=\"user_id\" value=\"<?= $user_id?>\"><input type=\"hidden\" name=\"user_key\" value=\"<?= $user_key?>\"><input type=\"submit\" class=\"btn btn-primary btn-lg btn-block\" value=\"获取全体新部员名单\"><br/></form><hr>");
                
//                var length = data[3]['section'].length;
//                console.log(data[3]['section'][0]);
//                for (var i = 0; i < length; i++){
//                    $("#final_stat").append("<h3 class=\"text-center\">" + data[3]['section'][i][0] + "总人数:<a>" + data[3]['section'][i][1] + "</a></h3>");
//                    $("#final_stat").append("<button type=\"button\" class=\"btn btn-success btn-lg btn-block\">" + data[3]['section'][i][0] + "</button>");
//                    $("#final_stat").append("<hr>");
//                }
                $.each(data[3]['section'], function(i, val){
                    $("#final_stat").append("<h3 class=\"text-center\">" + i + "总人数:<a>" + val + "</a></h3>");
                    $("#final_stat").append("<button type=\"button\" class=\"btn btn-success btn-lg btn-block\">获取" + i + "新部员名单</button>");
                    $("#final_stat").append("<hr>");
                });
        }
    }
        
</script>
</html>
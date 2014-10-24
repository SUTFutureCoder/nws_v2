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
</head>
<body>
<ul class="nav nav-tabs" role="tablist" id="myTab">
<li class="active"><a href="#add" role="tab" data-toggle="tab">手动添加用户</a></li>
<li><a href="#batch_add" role="tab" data-toggle="tab">批量添加用户</a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade active in" id="add">
    <hr>
    <form id="data_search" class="form-horizontal" role="form">
    <div class="form-group">
        <label for="user_role" class="col-sm-2 control-label">赋予社团角色</label>
        <div class="col-sm-9">
            <select class="form-control" id="user_role">
                <?php foreach ($role as $role_item):?>
                    <option><?= $role_item['role_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label for="user_section" class="col-sm-2 control-label">用户所属部门</label>
        <div class="col-sm-9">
            <select class="form-control" id="user_section">
                <?php foreach ($section as $section_item):?>
                    <option><?= $section_item['section_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    
    
    <hr>    
    <div class="form-group">
        <label for="user_number" class="col-sm-2 control-label">学号</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="user_number">
        </div>
    </div>
    <div class="form-group">
        <label for="user_name" class="col-sm-2 control-label">姓名</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="user_name">
        </div>
    </div>
    <div class="form-group">
        <label for="user_telephone" class="col-sm-2 control-label">手机号码</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="user_telephone">
        </div>
    </div>
    <div class="form-group">
        <label for="user_qq" class="col-sm-2 control-label">QQ</label>
        <div class="col-sm-9">                      
            <input type="text" class="form-control" id="user_qq">
        </div>
    </div>
    <div class="form-group">
        <label for="user_sex" class="col-sm-2 control-label">性别</label>
        <div class="col-sm-9">
            <select class="form-control" id="user_sex">
                <option>男</option>
                <option>女</option>
                <option>其他</option>
                <option>保密</option>
            </select>    
        </div>
    </div>
    <div class="form-group">
        <label for="user_talent" class="col-sm-2 control-label">特长</label>
        <div class="col-sm-9">                      
            <textarea class="form-control" id="user_talent" rows="3"></textarea>
        </div>
    </div>
    <hr>
    <div class="col-sm-10 col-sm-offset-1">
        <input class="form-control btn btn-success" id="submit" onclick="MotherIframeSend()" value="提交">
    </div>
    <br/>
    <br/>
    <hr>
    </form>
</div>
    
<div class="tab-pane fade" id="batch_add">
    <hr>
    
    <div class="alert alert-success upload_info" role="alert">允许您拖入多个excel数据</div>

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
    
</div>

</body>
<script>
//发送到母窗口
    function MotherIframeSend(){
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/AddPersonNormal';                
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>", "add_user_telephone" : "' + $("#user_telephone").val() + '"';
        data['data'] += ', "add_user_qq" : "' + $("#user_qq").val() + '", "add_user_talent" : "' + $("#user_talent").val() + '"';
        data['data'] += ', "add_user_role" : "' + $("#user_role").val() + '", "add_user_section" : "' + $("#user_section").val() + '"';
        data['data'] += ', "add_user_number" : "' + $("#user_number").val() + '", "add_user_name" : "' + $("#user_name").val() + '"';
        data['data'] += ', "add_user_sex" : "' + $("#user_sex").val() + '"}';
        //console.log(data);
        parent.IframeSend(data);
    }
    //接收母窗口传来的值
    function MotherResultRec(data){
        //console.log(data);
        if (1 == data[2]){
            $("form").each(function() {   
                this.reset();
            });   
        }
        alert(data[3]);
        if (data[4]){
            $("#" + data[4]).focus();
        }
    }
    function TestUrl(){ 
        window.open($("#user_pro_homepage").val());
    }
</script>
</html>
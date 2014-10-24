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
        if(fileList[0].type.indexOf('image') === -1){
                $('.dashboard_target_box').removeClass('over');
                alert('请插入标准格式的图片');
                return;
        }

        xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function(){
            
            if(xhr.readyState==4 && xhr.status==200){
                var result = JSON.parse(xhr.responseText);
                console.log(result);
                if (!result[0]){
                    alert(result[1]);
                }else {
                    if ($("#user_photo").length > 0){                        
                        $("#user_photo").attr("src", "<?= base_url('upload/photo/' . $user_id) ?>" + result[1] + "?t=" + Math.random());
                    }else {
                        $("#user_photo_legend").after("<img id=\"user_photo\" style=\"max-width:100%\">");
                        $("#user_photo").attr("src", "<?= base_url('upload/photo/' . $user_id) ?>" + result[1] + "?t=" + Math.random());
                    }
                }
                
            }

        }	        
        xhr.open("post", location.href + "/PhotoUpload", true);
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
<div class="tab-pane fade active in col-sm-10 col-sm-offset-1" style="top: 30px" id="data">
    <div class="panel panel-info">
        <div class="panel-heading">                        
            <h3 class="panel-title"><?= $user_name?>的个人中心</h3>
        </div>
        <div class="panel-body">
            <legend>基础信息</legend>
            <form id="data_search" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-2 control-label">ID</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_id ?></label>
                </div>
                <label class="col-sm-2 control-label">学号</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_number ?></label>
                </div>
                <label class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_name ?></label>
                </div>
                <label class="col-sm-2 control-label">部门</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_section ?></label>
                </div>
                <label class="col-sm-2 control-label">职务</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_role ?></label>
                </div>
                <label class="col-sm-2 control-label">性别</label>
                <div class="col-sm-9">
                    <label class="control-label"><?php if ($user_sex){echo $user_sex;}else{echo '无';}?></label>
                </div>
                <label class="col-sm-2 control-label">专业</label>
                <div class="col-sm-9">
                    <label class="control-label"><?php if ($user_major){echo $user_major;}else{echo '无';}?></label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="user_telephone" class="col-sm-2 control-label">手机号码</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_telephone ?>" id="user_telephone">
                </div>
            </div>
            <div class="form-group">
                <label for="user_qq" class="col-sm-2 control-label">QQ</label>
                <div class="col-sm-9">                      
                    <input type="text" class="form-control" value="<?= $user_qq ?>" id="user_qq">
                </div>
            </div>
            <div class="form-group">
                <label for="user_talent" class="col-sm-2 control-label">特长</label>
                <div class="col-sm-9">                      
                    <textarea class="form-control" id="user_talent" rows="3"><?= $user_talent ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="user_friendsearch_enable" class="col-sm-2 control-label">允许好友查找</label>
                <div class="col-sm-9">                      
                    <input type="checkbox" id="user_friendsearch_enable" data-toggle="tooltip" data-placement="right"  <?php if($user_friendsearch_enable):?> checked="checked" <?php endif;?>>
                </div>
            </div> 
            <div class="form-group">
                <label class="col-sm-2 control-label">注册时间</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_reg_time ?></label>
                </div>
                <label class="col-sm-2 control-label">活跃值</label>
                <div class="col-sm-9">
                    <label class="control-label"><?= $user_joined_act_sum ?></label>
                </div>                
            </div>
                
            <legend>高级信息</legend>
            <div class="form-group">
                <label for="user_pro_birthday" class="col-sm-2 control-label">出生日期</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_birthday ?>" id="user_pro_birthday" placeholder="例：2014-08-20">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_old" class="col-sm-2 control-label">年龄</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_old ?>" id="user_pro_old">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_hometown" class="col-sm-2 control-label">家乡</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_hometown ?>" id="user_pro_hometown">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_bloodtype" class="col-sm-2 control-label">血型</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_bloodtype ?>" id="user_pro_bloodtype">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_nick" class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_nick ?>" id="user_pro_nick">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_ename" class="col-sm-2 control-label">外语名</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_ename ?>" id="user_pro_ename">
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_homepage" class="col-sm-2 control-label">个人主页</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?php if (!strpos($user_pro_homepage, 'ttp://'))  {echo 'http://';}?><?= $user_pro_homepage ?>" id="user_pro_homepage">
                </div>
                <button type="button" onclick="TestUrl()" class="btn btn-success">测试链接</button>
            </div>
            <div class="form-group">
                <label for="user_pro_language" class="col-sm-2 control-label">掌握语言</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="<?= $user_pro_language ?>" id="user_pro_language">
                </div>
            </div>            
            <div class="form-group">
                <label for="user_pro_selfintro" class="col-sm-2 control-label">自我介绍</label>
                <div class="col-sm-9">                      
                    <textarea class="form-control" id="user_pro_selfintro" rows="3"><?= $user_pro_selfintro ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="user_pro_lock" class="col-sm-2 control-label">高级信息隐私锁</label>
                <div class="col-sm-9">                      
                    <input type="checkbox" id="user_pro_lock" <?php if($user_pro_lock):?> checked="checked" <?php endif;?>>
                </div>
            </div> 
            <legend id="user_photo_legend">上传与更新照片</legend>
            <?php if($user_pro_photo_ext):?>
            <img id="user_photo" style="max-width:100%" src="<?= base_url('upload/photo/' . $user_id . $user_pro_photo_ext) ?>"/><br/>
            <?php else:?>
            <a style="color: blue">你知道吗？<br/><h5>大多数人都会有不同程度的认脸困难症(脸盲)或是懒得记脸，为了让学长更好地关照你，最好还是上传一张照片吧</h5></a><br/>
            <?php endif; ?>
            <div id="target_box" class="dashboard_target_box">
                <div id="drop_zone_home" class="dashboard_target_messages_container">
                    <p id="dtb-msg2" class="dashboard_target_box_message" style="top:-44px">选择你的图片<br>
                        开始上传</p>
                    <p id="dtb-msg1" class="dashboard_target_box_message" style="top:-44px">拖动图片到<br>
                        这里</p>
                    </p>
                </div>
            </div>
            <hr>
            <script>  
                //发送到母窗口
            function MotherIframeSend(){
                var data = new Array();
                data['src'] = location.href.slice((location.href.lastIndexOf("/")));
                data['api'] = location.href + '/SetUserInfo';                
                data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>", "user_telephone" : "' + $("#user_telephone").val() + '"';
                data['data'] += ', "user_qq" : "' + $("#user_qq").val() + '", "user_talent" : "' + $("#user_talent").val() + '", "user_friendsearch_enable" : "' + $("#user_friendsearch_enable").is(':checked') + '"'
                data['data'] += ', "user_pro_birthday" : "' + $("#user_pro_birthday").val() + '", "user_pro_old" : "' + $("#user_pro_old").val() + '", "user_pro_hometown" : "' + $("#user_pro_hometown").val() + '"'; 
                data['data'] += ', "user_pro_bloodtype" : "' + $("#user_pro_bloodtype").val() + '", "user_pro_nick" : "' + $("#user_pro_nick").val() + '", "user_pro_ename" : "' + $("#user_pro_ename").val() + '"';
                data['data'] += ', "user_pro_homepage" : "' + $("#user_pro_homepage").val() + '", "user_pro_language" : "' + $("#user_pro_language").val() + '", "user_pro_selfintro" : "' + $("#user_pro_selfintro").val() + '"';
                data['data'] += ', "user_pro_lock" : "' + $("#user_pro_lock").is(':checked') + '"}';
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
            <div class="col-sm-10 col-sm-offset-1">
                <input class="form-control btn btn-success" id="submit" onclick="MotherIframeSend()" value="提交">
            </div>
            <br/>
            <br/>
            
            <hr>
            </form>
        </div>
        
    </div>
</div>
    
</body>  
</html>  

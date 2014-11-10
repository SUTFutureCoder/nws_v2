<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>管理员控制面板</title>
<script src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
<script src="http://libs.baidu.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url('jq-ui/jquery.easyui.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('js/swfobject.js')?>"></script>
<script type="text/javascript" src="<?= base_url('js/web_socket.js')?>"></script>
<script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url('jq-ui/themes/cupertino/easyui.css')?>" id="swicth-style">
<link rel="stylesheet" type="text/css" href="<?= base_url('jq-ui/style.css')?>" id="swicth-style">
<link rel="stylesheet" type="text/css" href="http://libs.baidu.com/bootstrap/2.3.2/css/bootstrap.min.css">

</head>
<style>
    .modal{
        position: relative;
        left: 45%;
        width: 750px;
    }
</style>
<script>
if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
WEB_SOCKET_SWF_LOCATION = "swf/WebSocketMain.swf";
WEB_SOCKET_DEBUG = true;
var ws, ping, name = 'null', user_list={};

    // 创建websocket
    ws = new WebSocket("ws://"+document.domain+":8080/");
    

    // 当socket连接打开时，输入用户名
    ws.onopen = function() {               
        ws.send('{"type":"login","name":<?= $user_id ?>,"group":"desktop"}');
        setInterval("getping()",1000);
    };

    // 当有消息时根据消息类型显示不同信息
    ws.onmessage = function(e) {  
    console.log(e.data);
    var result = JSON.parse(e.data);  
    console.log(result);
    if (result[0] != 'p')
    {
        //alert(result[1]);
    }
    else
    {
        $(".btn").removeAttr("disabled");
        $(".btn").attr("value", "一键配置"); 
    }
    
    switch (result[0])
    {
        case 'SetSectionList_2':
        case 'SetSectionList_3':
        case 'SetSectionList_4':
        case 'SetRoleList_2':
        case 'SetRoleList_3':
        case 'SetRoleList_4':
        case 'SetAdminInfo_2':
        case 'SetAdminInfo_3':
        case 'SetAdminInfo_4':
            alert (result[1]);
        break;

        case 'SetSectionList_1':
            $('.bar').css("width", "60%");
            $('#set_section').animate({height:"0px"}, 1000);
            setTimeout("$(\"#set_section\").toggle()", 1000);
            $('#set_admin_info').toggle();
        break;

        case 'SetAdminInfo_1':
            $('.bar').css("width", "90%");
            $('#set_admin_info').animate({height:"0px"}, 1000);
            setTimeout("$(\"#set_admin_info\").toggle()", 1000);
            $('#set_role').toggle();
        break;
        
        case 'SetRoleList_1':
            $('.bar').css("width", "100%");
            $('.progress').addClass('progress-success');
            $('#set_role').animate({height:"0px"}, 1000);
            setTimeout("$(\"#set_role\").toggle()", 1000);
            $('#finish').toggle();
        break;
        
        case "p":    //ping
            var date = new Date();
            i = 0;                    
            ping = date.getTime() - ping;
            //alert(date.getTime());
            $("#ping").html("ping:" + ping + "ms");
            break;
                
        case "iframe":
        case "group":     
            $("iframe[src='" + location.href.slice(0, location.href.lastIndexOf("/")) + result[1] + "']")[0].contentWindow.MotherResultRec(result);
            /*if ($("iframe[src='" + result[1] + "']"))
            {
                alert($("iframe[src='" + result[1] + "']").attr('scrolling'));
            }*/
            break;

    }

};
ws.onclose = function() {
    console.log("服务端关闭了连接");
};
ws.onerror = function() {
    console.log("出现错误");
};    

</script>
<script>     
//                            alert(location.href.slice(0, location.href.lastIndexOf("/")));
function IframeSend(data, type) { 
    type = arguments[1] ? arguments[1] : "iframe";
    if (!data['group']){
        ws.send('{"type":"' + type + '","api":"' + data['api'] + '","src":"' + data['src'] + '","data":' + data['data'] + '}');
    } else {        
        ws.send('{"type":"' + type + '","api":"' + data['api'] + '","src":"' + data['src'] + '","data":' + data['data'] + ',"group":"' + data['group'] + '"}');
    }
    
}
function getping(){ 
    var date = new Date();
    ping = date.getTime(); 
//    var test = {}; 
//    test.type = "ping";
//    string_test = '{"type":"ping"}';     
//    ws.send(JSON.stringify(test));
//alert(JSON.stringify({"type":"ping"}));
    ws.send('{"type":"ping"}');
}    
</script>
<body class="easyui-layout">

<div region="north" border="false" class="cs-north" style="height:30px; overflow:hidden">
    <div  style="height: 30px; top:5px; overflow: hidden; position: relative; left: 10px; float: left">
        <a href="javascript:void(0);" src="<?= base_url('index.php/daily_me')?>" class="cs-navi-tab">您好，尊敬的 <?=$user_role?> <?=$user_name?></a>
    <?php if ($mess_unread && 0):?>
    <a href="javascript:void(0);" src="index.php/daily_message" class="cs-navi-tab badge badge-important" id="mess_indicator"><?=$mess_unread?>条未读信息</a>
    <?php //else: ?>
    <a href="javascript:void(0);" src="index.php/daily_message" class="cs-navi-tab badge badge-info">消息中心</a>
    <?php endif; ?>
    
    </div>
		<div class="cs-north-bg"style="top:0%" >                
		<ul class="ui-skin-nav">	                    
			<li class="li-skinitem"><a class="cs-navi-tab badge badge-info" href="javascript:void(0);" src="index.php/daily_message" id="ping">正在加载</a></li>
			<li class="li-skinitem" title="gray"><span class="gray" rel="gray"></span></li>
			<li class="li-skinitem" title="pepper-grinder"><span class="pepper-grinder" rel="pepper-grinder"></span></li>
			<li class="li-skinitem" title="blue"><span class="blue" rel="blue"></span></li>
			<li class="li-skinitem" title="cupertino"><span class="cupertino" rel="cupertino"></span></li>
			<li class="li-skinitem" title="dark-hive"><span class="dark-hive" rel="dark-hive"></span></li>
			<li class="li-skinitem" title="sunny"><span class="sunny" rel="sunny"></span></li>
		</ul>	
		</div>	</div>
	<div region="west" border="true" split="true" title="索引" class="cs-west">
			<div class="easyui-accordion" fit="true" border="false">
                                <div title="日常使用">
					<a href="javascript:void(0);" src="index.php/daily_chat_room" class="cs-navi-tab">社团聊天室</a></p>
					<a href="javascript:void(0);" src="index.php/daily_stat" class="cs-navi-tab">社团统计</a></p>
					<a href="javascript:void(0);" src="index.php/person_comrade_list" class="cs-navi-tab">管理层通讯录</a></p>
                                        <a href="javascript:void(0);" src="<?= base_url('index.php/daily_me')?>" class="cs-navi-tab">个人中心</a></p>
					<a href="javascript:void(0);" src="index.php/daily_message" class="cs-navi-tab">消息中心</a></p>
					<a href="javascript:void(0);" src="index.php/daily_sendmessage" class="cs-navi-tab">发送信息</a></p>
					<a href="javascript:void(0);" src="index.php/daily_joined_list" class="cs-navi-tab">已参加活动列表</a></p>
					<a href="javascript:void(0);" src="index.php/daily_contest_list" class="cs-navi-tab">比赛展板</a></p>
					<a href="javascript:void(0);" src="index.php/daily_contest_add" class="cs-navi-tab">添加比赛</a></p>
					<a href="javascript:void(0);" src="index.php/daily_bug" class="cs-navi-tab">bug、建议相关</a></p>
					<a href="javascript:void(0);" src="index.php/daily_bug_repair_list" class="cs-navi-tab">查看bug/撰写日志</a></p>
					<a href="javascript:void(0);" src="<?= base_url('file_manager/elfinder.html')?>" class="cs-navi-tab">共享文件</a></p>
				</div>
                            
				<div title="活动相关">
                                    	<a href="javascript:void(0);" src="<?= base_url('index.php/act_list') ?>" class="cs-navi-tab">活动列表</a></p>
					<a href="javascript:void(0);" src="<?= base_url('index.php/act_add') ?>" class="cs-navi-tab">添加活动</a></p>
					<a href="javascript:void(0);" src="index.php/act_dele_ed_list" class="cs-navi-tab">已注销的活动</a></p>
					<a href="javascript:void(0);" src="index.php/act_propagator" class="cs-navi-tab">课表录入</a></p>
				</div>
                            
				<div title="部员相关">
					<a href="javascript:void(0);" src="index.php/person_list" class="cs-navi-tab">人员名单</a></p>
                                        <a href="javascript:void(0);" src="<?= base_url('index.php/person_add')?>" class="cs-navi-tab">增加部员</a></p>
                                        <a href="javascript:void(0);" src="<?= base_url('index.php/person_add_by_excel')?>" class="cs-navi-tab">部员招新</a></p>
					<a href="javascript:void(0);" src="index.php/person_dele_ed_list" class="cs-navi-tab">已注销部员</a></p>
					<a href="javascript:void(0);" src="index.php/person_schedule_change" class="cs-navi-tab">部员课表修改</a></p>
					<!--<a href="javascript:void(0);" src="index.php/person_remove" class="cs-navi-tab">部员迁移</a></p>
					<a href="javascript:void(0);" src="index.php/person_autopass" class="cs-navi-tab">部员密码批量生成</a></p>
					<a href="javascript:void(0);" src="index.php/person_stat" class="cs-navi-tab">统计部员专业分布</a></p> -->
				</div>
				<div title="权限相关">
					<a href="javascript:void(0);" src="<?= base_url('index.php/authorizee_manage');?>" class="cs-navi-tab">权限管理</a></p>
					<a href="javascript:void(0);" src="<?= base_url('index.php/daily_change_pass');?>" class="cs-navi-tab">更改密码</a></p>
					<a href="javascript:void(0);" src="index.php/authorizee_promote" class="cs-navi-tab">部员晋升</a></p>
				</div>
                            

                                <!--
                                <div title="好友系统">
					<a href="javascript:void(0);" src="index.php/person_comrade_list" class="cs-navi-tab">我的好友</a></p>
					<a href="javascript:void(0);" src="index.php/daily_friends" class="cs-navi-tab">添加好友</a></p>
				</div>
                                -->
		</div>
	</div>
	<div id="mainPanle" region="center" border="true" border="false">
            <div id="tabs" class="easyui-tabs"  fit="true" border="false" >
                <div title="Home">
                    <div class="cs-home-remark">
                        <h1><?= $organ_name?></h1><br/>
                        <?php foreach ($mess_push as $mess_push_item): ?>
                        <div class="alert <?=$mess_push_item['mess_push_style']?> alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h4><?=$mess_push_item['mess_push_title']?></h4>
                            <?= $mess_push_item['mess_push_content']?>
                        </div>   
                        <?php endforeach;?>
                        <hr>
                        <?php if ($role_authorizee_alert):?>
                        <div class="alert alert-danger fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            分工协作可以发挥整体效能，提高工作效率。请设置<a href="javascript:void(0);" src="index.php/authorizee_promote" class="cs-navi-tab"><strong>职位权限</strong></a>
                        </div>                             
                        <?php endif; ?>
                        <?php if ($user_num_alert):?>
                        <div class="alert alert-danger fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            无兄弟,不开团！请<a href="javascript:void(0);" src="index.php/authorizee_promote" class="cs-navi-tab"><strong>添加用户</strong></a>或<a href="javascript:void(0);" src="index.php/authorizee_promote" class="cs-navi-tab"><strong>批量导入用户</strong></a>
                        </div>                             
                        <?php endif; ?>
                        <?php if ($role_authorizee_alert):?>
                        <div class="alert alert-success fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            请进入<a href="javascript:void(0);" src="<?= base_url('/index.php/daily_me')?>" class="cs-navi-tab"><strong>个人中心</strong></a>完善个人信息
                        </div>                             
                        <?php endif; ?>                        
                    </div>
                </div>
            </div>
	</div>

	<div region="south" border="false" class="cs-south">三位一体信息化社团建设套件V2 ©沈阳工业大学网络管理中心</div>
	
	<div id="mm" class="easyui-menu cs-tab-menu">
		<div id="mm-tabupdate">刷新</div>
		<div class="menu-sep"></div>
		<div id="mm-tabclose">关闭</div>
		<div id="mm-tabcloseother">关闭其他</div>
		<div id="mm-tabcloseall">关闭全部</div>
	</div>
        <?php if ($init):?>
        <script>
        var section_num = 0;
        $(function(){
            $('#myModal').modal('toggle');  
        });
        function section_form(){
            $(".section_list").remove();            
            $("#section_num_confirm").after("<div class=\"section_list\">");
            $(".section_list").append("<hr>");
            section_num = $("#section_num").val() * 1;
            for (var i = 1; i <= section_num; i++){
                $(".section_list").append("<a>" + i * 1 +"</a><input type=\"text\" id=\"section_" + i + "\" class=\"span9\" required=\"\">");
            }
            $(".section_list").append("<button class=\"btn btn-success btn-block\" id=\"section_list_confirm\" onclick=\"section_form_submit()\" type=\"button\">确定部门列表</button>");
            $(".section_list").append("<hr>");            
        }
        
        function section_form_submit(){ 
            var json_str = '{"type":"func","api":"' + location.href+'/SectionSetup","data":{"user_key":"<?= $user_key?>","data_array":{';
            for (var i = 1; i <= section_num; i++)
            {
                if (1 != i)
                {
                    json_str += ',';
                }
                $("#set_admin_info_section").append('<option>' + $("#section_" + i).val() + '</option>');
                json_str += '"'+ i + '":{"section_id":' + i + ', "section_name" : "' + $("#section_" + i).val() + '"}';
            }
            json_str += '}}}';
            ws.send(json_str); 
        }
        
        function role_form(){
            $(".role_list").remove();            
            $("#role_num_confirm").after("<div class=\"role_list\">");
            $(".role_list").append("<hr>");
            role_num = $("#role_num").val() * 1;
            for (var i = 1; i <= role_num; i++){                
                $(".role_list").append("<a>" + i * 1 +"</a><input type=\"text\" id=\"role_" + i + "\" class=\"span9\" required=\"\">");
            }
            $(".role_list").append("<button class=\"btn btn-success btn-block\" id=\"role_list_confirm\" onclick=\"role_form_submit()\" type=\"button\">确定职位列表</button>");
            $(".role_list").append("<hr>");            
        }
        
        function admin_info_form_submit(){
            var json_str = '{"type":"func","api":"' + location.href+'/AdminInfoSetup","data":{"user_key":"<?= $user_key?>",';
            json_str += '"admin_section" : "' + $("#set_admin_info_section").val() + '", "admin_sex" : "' + $("#set_admin_info_sex").val() + '", "admin_major" : "' + $("#set_admin_info_major").val() + '"';
            json_str += '}}';
            ws.send(json_str);
        }
        
        function role_form_submit(){ 
            var json_str = '{"type":"func","api":"' + location.href+'/RoleSetup","data":{"user_key":"<?= $user_key?>","data_array":{';
            for (var i = 1; i <= role_num; i++)
            {
                if (1 != i)
                {
                    json_str += ',';
                }                
                json_str += '"'+ i + '":{"role_id":' + (i * 1 + 1 ) + ', "role_name" : "' + $("#role_" + i).val() + '"}';
            }
            json_str += '}}}';
            ws.send(json_str); 
        }
        </script>
        
        <div id="myModal" class="modal hide fade span9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">再次感谢您的使用</h3>
                </div>
                <div class="modal-body">
                    <p>尊敬的<?= $organ_name?><?= $user_role?><?= $user_name?>:</p>
                    <p>非常感谢使用三位一体信息化社团建设套件V2</p>
                <p>您可以在本界面进行初始化，也可以先行体验各个功能</p>
                <hr>  
                <div class="progress progress-striped active">
                    <div class="bar" style="width: 30%;"></div>
                </div>
                <div id="set_section">
                    <legend>部门名单</legend>
                    <p>部门数量</p>
                    <input type="text" id="section_num" class="span9" required="">
                    <button class="btn btn-success btn-block" id="section_num_confirm" onclick="section_form()" type="button">确定</button>
                </div>
                
                <div id="set_admin_info" style="display:none;">
                    <legend>管理员基本信息</legend>                    
                    <div class="control-group">
                        <label class="control-label">您任职的部门</label>
                        <div class="controls">
                            <select id="set_admin_info_section">                                
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">您的性别</label>
                        <div class="controls">
                            <select id="set_admin_info_sex">
                                <option>男</option>
                                <option>女</option>
                                <option>其他</option>
                                <option>保密</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">您的专业</label>
                        <div class="controls">
                            <input type="text" id="set_admin_info_major" required="">
                        </div>
                    </div>
                    <button class="btn btn-success btn-block" id="set_admin_info_confirm" onclick="admin_info_form_submit()" type="button">确定</button>
                </div>
                
                <div id="set_role" style="display:none;">
                    <legend>职位列表</legend>
                    <p>职位数量</p>
                    <input type="text" id="role_num" class="span9" required="">
                    <button class="btn btn-success btn-block" id="role_num_confirm" onclick="role_form()" type="button">确定</button>
                </div>
                
                
                <div id="finish" style="display:none;">
                    <legend>恭喜您</legend>
                    <p>您已成功初始化本套件！祝您使用愉快！</p>                    
                </div>
                    
                </div>
                <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>  
        <?php endif;?>
</body>
<script>
    $("#mess_indicator").click(function(){
        $("#mess_indicator").html("消息中心");
        $("#mess_indicator").attr({
            "class" : "cs-navi-tab badge badge-info"
        });
    });
</script>
</html>
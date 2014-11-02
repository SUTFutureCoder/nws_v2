<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>控制台安装程序</title>
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
        <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="js/swfobject.js"></script>
        <script type="text/javascript" src="js/web_socket.js"></script>
        <script type="text/javascript" src="js/json.js"></script>
        <style>
            body
            {
                background-color: #eee;
                
            }
            #container
            {
                padding-top: 50px;
                max-width: 700px; 
                margin: 0px auto;
                margin-bottom: 60px;
            }
            .footer {
              
              bottom: 0;
              width: 100%;
              height: 80px;
            }
        </style>
        <script>
        
        if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
        WEB_SOCKET_SWF_LOCATION = "swf/WebSocketMain.swf";
        WEB_SOCKET_DEBUG = true;
        var ws, ping, name = 'null', user_list={};
        
           // 创建websocket
            ws = new WebSocket("ws://"+document.domain+":8080/");
         setInterval("getping()",1000);
           
          // 当socket连接打开时，输入用户名
          ws.onopen = function() {              
              //ws.send(JSON.stringify({"type":"noajax","name":name}));
          };
          
          // 当有消息时根据消息类型显示不同信息
          ws.onmessage = function(e) {  
            console.log(e.data);
            var result = JSON.parse(e.data);  
            console.log(result);
            if (result[0] != 'p')
            {
                alert(result[1]);
            }
            else
            {
                $(".btn").removeAttr("disabled");
                $(".btn").attr("value", "一键配置"); 
            }
            switch (result[0])
            {
                case 1 :
                    location.href = result[2];
                    break;

                case 2:
                    $('#user_number').val('');
                    $('#user_number').focus();
                    break;

                case 3:
                case 13:
                    $('#user_password').val('');
                    $('#user_password_confirm').val('');
                    $('#user_password').focus();
                    break;

                case 4:
                    if (!$('#user_password').val()) $('#user_password').focus();
                    if (!$('#user_password_confirm').val()) $('#user_password_confirm').focus();
                    break;

                case 5:
                    $('#db_username').val('');
                    $('#db_username').focus();
                    break;

                case 6:                            
                case 7:
                case 10:
                case 12:
                    break;

                case 8:
                    $('#db_password').val('');
                    $('#db_password').focus();
                    break;

                case 9:
                    $('#db_username').val('');
                    $('#db_password').val('');
                    $('#db_username').focus();
                    break;

                case 11:
                    $('#db_password').val('');
                    $('#db_password').focus();
                    break;
                    
                case 14:
                    $("#organ_name").focus();
                    break;
                    
                case 15:
                    $("#user_telephone").focus();
                    break;
                    
                case 16:
                    $("#user_name").focus();
                    break;
                    
                case "p":    //ping
                    var date = new Date();
                    i = 0;                    
                    ping = date.getTime() - ping;
                    //alert(date.getTime());
                    $("#ping").html(ping + "ms");
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
        function onSubmit() {
            if ($("#user_password").val() != $("#user_password_confirm").val()){
                alert('两次密码输入不同，请重新输入');
                $("#user_password", "#user_password_confirm").val("");
                $("#user_password").focus();
            }
            else{
                $(".btn").attr("value", "正在安装中...请稍后");
                $(".btn").attr("disabled", "disabled");    
                ws.send(JSON.stringify({"type":"func","api":location.href+"index.php/setup/SetupInit","data":{"organ_name":$("#organ_name").val(),"user_number":$("#user_number").val(),
                            "user_number_length": $("#user_number_length").val(), "user_password" : $("#user_password").val(),
                            "user_password_confirm" : $("#user_password_confirm").val(), "user_telephone" : $("#user_telephone").val(),
                            "user_name" : $("#user_name").val(),
                            "db_username" : $("#db_username").val(), "db_password" : $("#db_password").val(), 
                            "base_url" : location.href}}));     
            }            
        }
        function getping(){ 
            var date = new Date();
            ping = date.getTime();            
            ws.send(JSON.stringify({"type":"ping"}));
        }    
        </script>
        <script>            
            $(function(){
                $("#user_number").on("keyup blur", function(){
                    if (20 < $("#user_number").val().length){
                        alert("学号的最大值为20个字符");
                        $("#user_number").focus();
                    }
                    $("#user_number_length").attr("value", $("#user_number").val().length);
                })
                $("#user_number_length").on("keyup blur", function(){
                    if (20 < $("#user_number_length").val()){
                        alert("学号的最大值为20个字符");
                        $("#user_number_length").focus();
                    }                    
                })
            })
        </script>
</head>
<body>

<div id="container">
    <h3><p class="text-center">欢迎使用三位一体信息化社团建设套件V2</p></h3><br/>   
    <div class="form-horizontal" id="setup_init" role="form">
        <div class="form-group">
          <label for="organ_name" class="col-sm-2">社团名称</label>
          <div class="col-sm-10">
              <input type="text" name="organ_name" class="form-control" id="organ_name" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_name" class="col-sm-2">管理员姓名</label>
          <div class="col-sm-10">
              <input type="text" name="user_name" class="form-control" id="user_name" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_number" class="col-sm-2">管理员学号</label>
          <div class="col-sm-10">
              <input type="text" name="user_number" class="form-control" id="user_number" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_number_length" class="col-sm-2">用户学号位数</label>
          <div class="col-sm-10">
              <input type="text" name="user_number_length" class="form-control" id="user_number_length" value="0" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_telephone" class="col-sm-2">管理员电话号码</label>
          <div class="col-sm-10">
              <input type="text" name="user_telephone" class="form-control" id="user_telephone" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_password" class="col-sm-2">密码</label>
          <div class="col-sm-10">
              <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Password"  required="">
          </div>
        </div>
        <div class="form-group">
          <label for="user_password_confirm" class="col-sm-2">密码确认</label>
          <div class="col-sm-10">
              <input type="password" name="user_password_confirm" class="form-control" id="user_password_confirm" placeholder="Password"  required="">
          </div>
        </div>
        <div class="form-group">
          <label for="db_username" class="col-sm-2">数据库用户名</label>
          <div class="col-sm-10">
              <input type="text" name="db_username" class="form-control" id="db_username"  required="">
          </div>
        </div>
        <div class="form-group">
          <label for="db_password" class="col-sm-2">数据库密码</label>
          <div class="col-sm-10">
              <input type="password" name="db_password" class="form-control" id="db_password" placeholder="Password" required="">
          </div>
        </div>        
        <br/>
        <div class="form-group">
          <div>
              <button class="btn btn-success btn-lg btn-block" onclick="onSubmit()">一键配置</button>
          </div>
        </div>     
    </div>
</div>
<div class="footer">
  <div class="container">
      <p class="text-muted">Ping:<a id="ping"></a><br/>三位一体信息化社团建设套件V2<br/>版权所有(C) 2014-<?= date('Y')?> 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen<br/>Released under the GPL V3.0 License</p>
  </div>
</div>
</body>
</html>
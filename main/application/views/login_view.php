<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<title>欢迎使用<?= $organ_name?>控制面板</title>
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
        <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="<?= base_url('js/swfobject.js')?>"></script>
        <script type="text/javascript" src="<?= base_url('js/web_socket.js')?>"></script>
        <script type="text/javascript" src="<?= base_url('js/json.js')?>"></script>
        <script type="text/javascript" src="<?= base_url('js/jquery.form.js')?>"></script>
        <style>
            body
            {
                background-color: #eee;
                margin-bottom: 60px;
            }
            .footer {
              position: absolute;
              bottom: 0;
              width: 100%;
              height: 80px;
            }
        </style>
        <script>
        
        if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
        WEB_SOCKET_SWF_LOCATION = "swf/WebSocketMain.swf";
        WEB_SOCKET_DEBUG = true;
        var ws, ping, ping_interval, reconnect_interval, name = 'null', user_list={};        
        
        //connect();
        //function connect(){
            ws = new WebSocket("ws://"+document.domain+":8080/");   
        //}
        
        
        //断线重连
        /*function reconnect(){
            if (1 != ws.readyState){
                alert('yoo');
                connect();
            } else {
                ping_interval = setInterval("getping()",1000);
                clearInterval(reconnect_interval);
            }         
        }*/
        //显示连接状态
        function getping(){ 
            var date = new Date();
            ping = date.getTime();              
            ws.send(JSON.stringify({"type":"ping"}));                      
        }       
          // 当socket连接打开时，输入用户名
          ws.onopen = function() {  
              ping_interval = setInterval("getping()",1000);
              //ws.send(JSON.stringify({"type":"noajax","name":name}));
          };
          
          // 当有消息时根据消息类型显示不同信息
          ws.onmessage = function(e) {
            console.log(e.data);
            var result = JSON.parse(e.data);            
            switch (result[0])
            {                
                case "p":    //ping
                    var date = new Date();
                    ping = date.getTime() - ping;
                    //alert(date.getTime());
                    $("#ping").html(ping + "ms");
                    break;
            }          
                        
          };
          ws.onclose = function() {
              console.log("服务端关闭了连接"); 
              //clearInterval(ping_interval);
              //reconnect_interval = setInterval("reconnect()",1000);              
          };
          ws.onerror = function() {
              console.log("出现错误");              
          };          
        </script>
        <script>                                    
        
            var options = {
                dataType : "json",
                beforeSubmit : function (){
                    $(".btn").html("正在提交中，请稍后");
                    $(".btn").attr("disabled", "disabled");
                },
                success : function (result){
                    console.log(result);
                    switch (result[0])
                    {
                        case 1:
                            if (!$("#ping").html()){
                                alert('无法连接WebSocket服务器，请使用控制台开启Workerman');
                                $(".btn").html("登录");
                                $(".btn").removeAttr("disabled");  
                                return ;
                            }
                            location.href='<?= base_url("index.php/control_center")?>';
                            break;
                        case 2:
                        case 3:    
                            break;
                        case 4:
                            $("#user_password").val("");
                            $("#user_password").focus();
                            break;
                        case 5:
                        case 6:
                            $("#user_mixed").val("");
                            $("#user_password").val("");
                            $("#user_mixed").focus();
                            break;
                    }    
                    
                    if (1 != result[0])
                    {
                        alert(result[1]);
                    }
                    $(".btn").html("登录");
                    $(".btn").removeAttr("disabled");                    
                }
            };
            
            $(".form-signin").ajaxForm(options);  
        </script>       
</head>
<body>

    <div class="col-sm-8 col-sm-offset-2">
        <form action="<?= base_url("index.php/index/PassCheck")?>" class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">欢迎使用<?= $organ_name?>控制面板</h2>
        <br/>
        <div class="form-group">            
        <input type="text" name="user_mixed" id="user_mixed" class="form-control " placeholder="账号/手机号码" required="" autofocus="">
        <input type="password" name="user_password" id="user_password" class="form-control" placeholder="密码" required="">            
        </div>
        <br/>
        <button type="submit" class="btn btn-lg btn-primary btn-block">登录</button>
        </form>
    </div>
    <div class="footer">
      <div class="container">
          <p class="text-muted">Ping:<a id="ping"></a><br/>三位一体信息化社团建设套件V2<br/>版权所有(C) 2014-<?= date('Y')?> 沈阳工业大学ACM实验室 沈阳工业大学网络管理中心 *Chen<br/>Released under the GPL V3.0 License</p>
      </div>
    </div>
</body>
</html>
<!DOCTYPE html>  
<html>  
<head>  
    <title></title>             
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">  
</head>

<body>
<ul class="nav nav-tabs" role="tablist" id="myTab">
<li class="active"><a href="#UpdatePass" role="tab" data-toggle="tab">更改密码</a></li>
<?php if ($authorizee_update_password): ?>
<li><a href="#UpdateOtherPass" role="tab" data-toggle="tab">更改其他用户密码</a></li>
<?php endif; ?>
</ul>

<div class="tab-content">
<div class="tab-pane fade active in" id="UpdatePass">
    <form class="form-horizontal" role="form">      
    <hr>         
    <div class="form-group">
        <label for="user_password_old" class="col-sm-2 control-label">原密码</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="user_password_old">
        </div>
    </div>
    <div class="form-group">
        <label for="user_password_new" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-9">                      
            <input type="password" class="form-control" id="user_password_new">
        </div>
    </div>
    <div class="form-group">
        <label for="user_password_confirm" class="col-sm-2 control-label">密码确认</label>
        <div class="col-sm-9">                      
            <input type="password" class="form-control" id="user_password_confirm">
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

<?php if ($authorizee_update_password): ?>
<div class="tab-pane fade" id="UpdateOtherPass">
    <form class="form-horizontal" role="form">      
    <hr>    
    <div class="form-group">
        <label for="user_mixed" class="col-sm-2 control-label">更改用户</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" placeholder="账号/手机号码" id="user_mixed">
        </div>
    </div>       
    <div class="form-group">
        <label for="user_password_new_other" class="col-sm-2 control-label">新密码</label>
        <div class="col-sm-9">                      
            <input type="password" class="form-control" id="user_password_new_other">
        </div>
    </div>
    <div class="form-group">
        <label for="user_password_confirm_other" class="col-sm-2 control-label">密码确认</label>
        <div class="col-sm-9">                      
            <input type="password" class="form-control" id="user_password_confirm_other">
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
<?php endif; ?>
</div>
</body>

<script>
//发送到母窗口
    function MotherIframeSend(){
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/ChangePass';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>", "user_mixed" : "' + $("#user_mixed").val() + '"';
        data['data'] += ', "user_password_old" : "' + $("#user_password_old").val() + '", "user_password_new" : "' + $("#user_password_new").val() + '"';
        data['data'] += ', "user_password_new_other" : "' + $("#user_password_new_other").val() + '", "user_password_confirm_other" : "' + $("#user_password_confirm_other").val() + '"';
        data['data'] += ', "user_password_confirm" : "' + $("#user_password_confirm").val() + '"}';            
        //console.log(data);
        parent.IframeSend(data);
    }
    //接收母窗口传来的值
    function MotherResultRec(data){
//        console.log(data);
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
</script>
</html>
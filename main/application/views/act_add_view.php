<!DOCTYPE html>  
<html>  
<head>  
    <title></title>             
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="<?= base_url('js/jquery-ui.min.js') ?>"></script>
    <script src="<?= base_url('js/jquery.form.js') ?>"></script>
    <script src="<?= base_url('js/jquery-migrate-1.1.1.js') ?>"></script> 
    <script type="text/javascript" src="<?= base_url('js/jquery-ui-slide.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery-ui-timepicker-addon.js') ?>"></script>   
</head>
<style>
    .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; } 
    .ui-timepicker-div dl { text-align: left; } 
    .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; } 
    .ui-timepicker-div dl dd { margin: 0 10px 10px 65px; } 
    .ui-timepicker-div td { font-size: 90%; } 
    .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; } 
    .ui_tpicker_hour_label,.ui_tpicker_minute_label,.ui_tpicker_second_label, 
    .ui_tpicker_millisec_label,.ui_tpicker_time_label{padding-left:20px} 
</style>
<script>
    $(function(){
        $('#TimeStart, #TimeEnd').datetimepicker({
            showSecond: true, 
            timeFormat: 'hh:mm:ss'
        }); 
    });
</script>
<body>
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
            <input type="password" class="form-control" id="TimeEnd"class="hasDatepicker" name="TimeStart">
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
</body>

<script>
//发送到母窗口
    function MotherIframeSend(){
        var data = new Array();
        data['src'] = location.href;
        data['api'] = location.href + '/ChangePass';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>", "user_mixed" : "' + $("#user_mixed").val() + '"';
        data['data'] += ', "user_password_old" : "' + $("#user_password_old").val() + '", "user_password_new" : "' + $("#user_password_new").val() + '"';
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
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
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/jquery-ui.css') ?>"/> 
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
        $('#act_start, #act_end').datetimepicker({
            showSecond: true, 
            timeFormat: 'hh:mm:ss'
        }); 
    });
</script>
<body>
    <br/>
    <form class="form-inline" role="form">
  <div class="form-group">
    <label class="sr-only" for="exampleInputEmail2">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
  </div>
  <div class="form-group">
    <div class="input-group">
      <div class="input-group-addon">@</div>
      <input class="form-control" type="email" placeholder="Enter email">
    </div>
  </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputPassword2">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
  </div>
  <div class="checkbox">
    <label>
      <input type="checkbox"> Remember me
    </label>
  </div>
  <button type="submit" class="btn btn-default">Sign in</button>
</form>
    <form class="form-horizontal" role="form">      
    <div class="form-group">
        <label for="act_name" class="col-sm-2 control-label">活动名称</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="act_name">
        </div>
    </div>
    <div class="form-group">
        <label for="act_user_id" class="col-sm-2 control-label">发起者</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="act_user_id">
        </div>
    </div>
    <div class="form-group">
        <label for="act_private" class="col-sm-2 control-label">社团内部活动</label>
        <div class="col-sm-9">
            <input type="checkbox" id="act_private">
        </div>
    </div>
    <div class="form-group">
        <label for="act_type" class="col-sm-2 control-label">活动类别</label>
        <div class="col-sm-9">
            <select class="form-control" id="act_type">
                <?php foreach ($type as $type_item):?>
                    <option><?= $type_item['activity_type_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    <div class="form-group">
        <label for="act_section_only" class="col-sm-2 control-label">部门限制</label>
        <div class="col-sm-9">
            <select class="form-control" id="act_section_only">
                <option>不限制</option>
                <?php foreach ($section as $section_item):?>
                    <option><?= $section_item['section_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>  
    <div class="form-group">
        <label for="act_start" class="col-sm-2 control-label">活动开始时间</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" class="hasDatepicker" placeholder="例：2014-08-20 20:05:01" id="act_start">
        </div>
    </div>
    <div class="form-group">
        <label for="act_end" class="col-sm-2 control-label">活动结束时间</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" class="hasDatepicker" id="act_end">
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
        data['api'] = location.href + '/ActAdd';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
        data['data'] += ', "act_name" : "' + $("#act_name").val() + '", "act_type" : "' + $("#act_type").val() + '"';
        data['data'] += ', "act_content" : "' + $("#act_content").val() + '", "act_warn" : "' + $("#act_warn").val() + '"';
        data['data'] += ', "act_start" : "' + $("#act_start").val() + '", "act_end" : "' + $("#act_end").val() + '"';
        data['data'] += ', "act_money" : "' + $("#act_money").val() + '", "act_position" : "' + $("#act_position").val() + '"';
        data['data'] += ', "act_member_sum" : "' + $("#act_member_sum").val() + '", "act_private" : "' + $("#act_private").prop("checked") + '"';
        data['data'] += ', "act_section_only" : "' + $("#act_section_only").val() + '"}';            
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
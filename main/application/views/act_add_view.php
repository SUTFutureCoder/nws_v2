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
//    alert(location.href.slice(0, location.href.lastIndexOf("/")));
//    alert(location.href.slice((location.href.lastIndexOf("/"))+1));
        $(function () {
            $('#act_start, #act_end').datetimepicker({
                showSecond: true,
                timeFormat: 'hh:mm:ss'
            });
        });
    </script>
    <body>
        <br/>
        <form class="form-horizontal" role="form">      
            <div class="form-group">
                <label for="act_name" class="col-sm-2 control-label">活动名称</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="act_name">
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
                        <?php foreach ($type as $type_item): ?>
                            <option><?= $type_item['activity_type_name'] ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label for="act_section_only" class="col-sm-2 control-label">部门限制</label>
                <div class="col-sm-9">
                    <select class="form-control" id="act_section_only">
                        <option>不限制</option>
                        <?php if (!$authorizee_act_global_add): ?>
                            <option><?= $section_select ?></option>
                        <?php else: ?>
                            <?php foreach ($section as $section_item): ?>
                                <option><?= $section_item['section_name'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select> 
                </div>
            </div>  
            <hr>    
            <div class="form-group">
                <label for="act_content" class="col-sm-2 control-label">活动描述</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="3" id="act_content"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="act_warn" class="col-sm-2 control-label">活动注意事项</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="3" placeholder="选填" id="act_warn"></textarea>
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

            <div class="form-group">
                <label for="act_money" class="col-sm-2 control-label">活动需要资金/人</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="选填" id="act_money">
                </div>
            </div>
            <div class="form-group">
                <label for="act_position" class="col-sm-2 control-label">活动地点</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="3" id="act_position"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="act_member_sum" class="col-sm-2 control-label">总人数</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="选填" id="act_member_sum">
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
        function MotherIframeSend() {
            var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/ActAdd';
            data['data'] = '{"user_key" : "<?= $user_key ?>", "user_id" : "<?= $user_id ?>"';
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
        function MotherResultRec(data) {
            if (1 == data[2]) {
                $("form").each(function () {
                    this.reset();
                });
                //广播自动添加最新活动                
                var B_data = new Array();
                B_data['src'] = '/act_list';
                B_data['api'] = location.href + '/B_ActListInsert';
                B_data['group'] = "desktop|mobile";
                B_data['data'] = '{"user_key" : "<?= $user_key ?>", "user_id" : "<?= $user_id ?>"';
                B_data['data'] += ', "act_id" : "' + data[4] + '"}';
                parent.IframeSend(B_data, 'group');
            }
            alert(data[3]);
            if (data[4]) {
                $("#" + data[4]).focus();
            }
        }
    </script>
</html>
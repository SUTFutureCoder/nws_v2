<!DOCTYPE html>  
<html>  
<head>  
    <title></title>         
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/jquery-ui.css')?>" /> 
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">        
    <script src="<?= base_url('js/jquery-ui.min.js') ?>"></script>
    <script src="<?= base_url('js/jquery.form.js') ?>"></script>
    <script src="<?= base_url('js/jquery-migrate-1.1.1.js') ?>"></script> 
    <script type="text/javascript" src="<?= base_url('js/jquery-ui-slide.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery-ui-timepicker-addon.js') ?>"></script>   
    <style>
        .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; } 
        .ui-timepicker-div dl { text-align: left; } 
        .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; } 
        .ui-timepicker-div dl dd { margin: 0 10px 10px 65px; } 
        .ui-timepicker-div td { font-size: 90%; } 
        .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; } 
        .ui_tpicker_hour_label,.ui_tpicker_minute_label,.ui_tpicker_second_label, 
        .ui_tpicker_millisec_label,.ui_tpicker_time_label{padding-left:20px} 
        .scroll{
            width:80px;
            height:80px;
            background:#64BFAE;
            color:#fff;
            line-height:80px;
            text-align:center;
            position:fixed;
            right:30px;
            bottom:50px;
            cursor:pointer;
            font-size:14px;
        }
    </style>
    <script>
    $(function (){  
         showScroll();
         function showScroll(){
                $(window).scroll( function() { 
                        var scrollValue=$(window).scrollTop();
                        scrollValue > 100 ? $('div[class=scroll]').fadeIn():$('div[class=scroll]').fadeOut();
                } );	
                $('#scroll').click(function(){
                        $("html,body").animate({scrollTop:0},200);	
                });	
         }
         $('#TimeStart, #TimeEnd').datetimepicker({
            showSecond: true, 
            timeFormat: 'hh:mm:ss'
        });                
    })          
    var options = {
        dataType : "json",
        beforeSubmit : function (){
            $("#submit").attr("value", "正在提交中……请稍后");
            $("#submit").attr("disabled", "disabled");
        },
        success : function (data){
            $("#data").empty();
            if (data['code'])
            {
                alert(data['status']);
                switch (data['code'])
                {
                    case 1:
                        break;
                    case 2:
                        $("#SenderID").val("");
                        $("#SenderID").focus();
                        break;
                    case 3:
                        $("#ReceiverID").val("");
                        $("#ReceiverID").focus();
                        break;
                    case 4:
                        $("#TimeStart").val("");
                        $("#TimeStart").focus();
                        break;
                    case 5:
                        $("#TimeEnd").val("");
                        $("#TimeEnd").focus();
                        break;                            
                }
                $("#submit").removeAttr("disabled");
                $("#submit").attr("value", "提交");
                return 0;
            }
            $("#data_search").resetForm();
            $('body').animate({scrollTop: $('#data').offset().top}, 1000);                
            console.log(data)
            $.each(data, function(n, value)
            {
                $("#data").append("<div class=\"panel panel_info panel-info\" mark=\""+n+"\"></div>");
                $("div[mark='"+n+"']").append("<div class=\"panel-heading\">" + value.Time + "</div>");
                $("div[mark='"+n+"']").append("<div class=\"panel-body\"></div>");
                if (value.SenderID !== null)
                $("div[mark='"+n+"']>.panel-body").append("<p>发送方ID：" +  value.SenderID + "</p>");
                if (value.ReceiverID !== null)
                $("div[mark='"+n+"']>.panel-body").append("<p>接收方ID：" +  value.ReceiverID + "</p>");
                $("div[mark='"+n+"']>.panel-body").append("<hr/>");
                if (value.Pose_x !== null || value.Pose_y !== null)
                $("div[mark='"+n+"']>.panel-body").append("<p>位姿坐标：(" +  value.Pose_x + "," + value.Pose_y + ")</p>");
                if (value.Pose_angle !== null)
                {$("div[mark='"+n+"']>.panel-body").append("<p>位姿角度：" +  value.Pose_angle + "</p>");$("div[mark='"+n+"']>.panel-body").append("<hr/>");}
                if (value.Piexl_x !== null || value.Piexl_y !== null)
                {$("div[mark='"+n+"']>.panel-body").append("<p>像素横纵：(" +  value.Piexl_x + "," + value.Piexl_y + ")</p>");$("div[mark='"+n+"']>.panel-body").append("<hr/>");}
                if (value.Space_x !== null || value.Space_y !== null || value.Space_z !== null)
                {$("div[mark='"+n+"']>.panel-body").append("<p>空间坐标：(" +  value.Space_x + "," + value.Space_y+ "," + value.Space_z + ")</p>");$("div[mark='"+n+"']>.panel-body").append("<hr/>");} 
                if (value.Pose_leftCorner_x !== null || value.Pose_leftCorner_y !== null)
                $("div[mark='"+n+"']>.panel-body").append("<p>位姿左角坐标：(" +  value.Pose_leftCorner_x + "," + value.Pose_leftCorner_y + ")</p>");
                if (value.Pose_rightCorner_x !== null || value.Pose_rightCorner_y !== null)
                {$("div[mark='"+n+"']>.panel-body").append("<p>位姿右角坐标：(" +  value.Pose_rightCorner_x + "," + value.Pose_rightCorner_y + ")</p>");$("div[mark='"+n+"']>.panel-body").append("<hr/>");}

                if (value.ValUSonic1 !== null)
                {
                    $("div[mark='"+n+"']>.panel-body").append("<table class=\"table table-bordered\"></table>");
                    $("div[mark='"+n+"']>.panel-body>table").append("<thead><tr><th>超声1</th><th>超声2</th><th>超声3</th><th>超声4</th><th>超声5</th><th>超声6</th><th>超声7</th><th>超声8</th><th>超声9</th><th>超声10</th><th>超声11</th><th>超声12</th></tr></thead>");
                    $("div[mark='"+n+"']>.panel-body>table").append("<tbody><tr><td>"+value.ValUSonic1+"</td><td>"+value.ValUSonic2+"</td><td>"+value.ValUSonic3+"</td><td>"+value.ValUSonic4+"</td><td>"+value.ValUSonic5+"</td><td>"+value.ValUSonic6+"</td><td>"+value.ValUSonic7+"</td><td>"+value.ValUSonic8+"</td><td>"+value.ValUSonic9+"</td><td>"+value.ValUSonic10+"</td><td>"+value.ValUSonic11+"</td><td>"+value.ValUSonic12+"</td></tr></thead>");
                    $("div[mark='"+n+"']>.panel-body>table").append("<thead><tr><th>超声13</th><th>超声14</th><th>超声15</th><th>超声16</th><th>超声17</th><th>超声18</th><th>超声19</th><th>超声20</th><th>超声21</th><th>超声22</th><th>超声23</th><th>超声24</th></tr></thead>");
                    $("div[mark='"+n+"']>.panel-body>table").append("<tbody><tr><td>"+value.ValUSonic13+"</td><td>"+value.ValUSonic14+"</td><td>"+value.ValUSonic15+"</td><td>"+value.ValUSonic16+"</td><td>"+value.ValUSonic17+"</td><td>"+value.ValUSonic18+"</td><td>"+value.ValUSonic19+"</td><td>"+value.ValUSonic20+"</td><td>"+value.ValUSonic21+"</td><td>"+value.ValUSonic22+"</td><td>"+value.ValUSonic23+"</td><td>"+value.ValUSonic24+"</td></tr></thead>");
                }



                $("div[mark='"+n+"']").append("<ul class=\"list-group\" mark=\""+n+"\"></ul>");
                $("ul[mark='"+n+"']").append("<li class=\"list-group-item\">" + value.DataType + "</li>");
            })
            $("#submit").removeAttr("disabled");
            $("#submit").attr("value", "提交");
            return false;// 返回false可以避免在原链接后加上#
        },
        error : function (msg){
            alert("失败");
            $("#submit").removeAttr("disabled");
            $("#submit").attr("value", "提交");
        }
    };
    $("#data_search").ajaxForm(options);
    </script>
</head>  
<body>  
<div id="search">
    <form action="getDataApi" id="data_search" class="form-horizontal" method="post" role="form">
        <br/>
        <div class="form-group">
            <label for="SenderID" class="col-sm-2 control-label">发送者ID</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="SenderID" name="SenderID">
            </div>
        </div>
        <div class="form-group">
            <label for="ReceiverID" class="col-sm-2 control-label">接受者ID</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ReceiverID" name="ReceiverID">
            </div>
        </div>
        <div class="form-group">
            <label for="TimeStart " class="col-sm-2 control-label">查询起始时间</label>
            <div class="col-sm-9">                      
                <input type="text" class="form-control" id="TimeStart"class="hasDatepicker" name="TimeStart">
            </div>
        </div>
        <div class="form-group">
            <label for="TimeEND " class="col-sm-2 control-label">查询结束时间</label>
            <div class="col-sm-9">                      
                <input type="text" class="form-control" id="TimeEnd" class="hasDatepicker" name="TimeEND">
            </div>
        </div>
        <hr>
        <div class="col-sm-10 col-sm-offset-1">
            <input type="submit" class="form-control btn btn-success" id="submit" name="submit" value="提交">
        </div>
        <br/>
        <br/>
        <hr>
    </form>
</div>

<div class="tab-pane fade active in col-sm-10 col-sm-offset-1" id="data">
    
</div>
<div class="scroll" id="scroll" style="display:none;">
        回到顶部
</div>
</body>  
</html>  

<!DOCTYPE html>  
<html>  
<head>  
    <title></title>             
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="<?= base_url('js/localstorage.js')?>"></script>
</head>
<body>
    <br/>
    <form class="form-inline col-sm-offset-2" role="form">
    <div class="form-group col-sm-5">
        <input type="text" class="form-control" id="act_name" placeholder="活动名称">
    </div>
    <div class="form-group">
        <select class="form-control" id="act_section_only_search">
            <option>部门</option>
            <option>不限制</option>
            <?php foreach ($act_section as $act_section_item):?>
                <option><?= $act_section_item['section_name']?></option>
            <?php endforeach; ?>
        </select> 
    </div>
    <div class="form-group">
        <select class="form-control" id="act_section_only_search">
            <option>类型</option>
            <?php foreach ($act_type as $act_type_item):?>
                <option><?= $act_type_item['activity_type_name']?></option>
            <?php endforeach; ?>
        </select> 
    </div>
    <div class="form-group">
        <input class="form-control btn btn-success" id="submit" value="搜索">
    </div>
    </form>
    <hr>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>活动类型</th>
                <th>活动名称</th>
                <th>部门限制</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
            </tr>
        </thead>
        <tbody id="act_list">
        </tbody>
    </table>
    
<div class="modal fade" id="act_info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="act_info_body">               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success" id="act_join">参加</button>
                <?php if ($authorizee_act_update): ?>
                <button type="button" class="btn btn-info" id="act_update">修改</button>
                <?php endif; ?>
                <?php if ($authorizee_act_propagator): ?>
                <button type="button" class="btn btn-info" id="act_propagator">宣传</button>
                <?php endif; ?>
                <?php if ($authorizee_act_dele): ?>
                <button type="button" class="btn btn-danger" id="act_dele">删除</button>                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="act_deal_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="act_deal_title"></h4>
        </div>        
        <div class="modal-body" id="act_deal_body">            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>            
            <button type="button" class="btn btn-danger" id="act_deal_confirm"></button>                
        </div>
    </div>
  </div>
</div>
</body>
<script>
    //TEST AREA
//$(function(){
//    $.LS.clear();    
//});
</script>
<script>
$(function(){
    $('.dropdown-toggle').dropdown()
    //当没有max_act_id，即之前尚未进行localstorage存储或被清除数据的情况
    if (!$.LS.get("max_act_id")){
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/GetActGlobeListInit';
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"}';
        parent.IframeSend(data);
    } else {
        //对已经写入的进行提取,并进行重绘
//        $.LS.clear();
        var act_list = new Array();
        act_list = JSON.parse($.LS.get("act_list"));
        var max_act_id = $.LS.get("max_act_id");
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));    
        data['api'] = location.href + '/RedrawActList';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
        data['data'] += ', "max_act_id" : "' + max_act_id + '"}';  
        parent.IframeSend(data);
//        console.log(act_list);
        list_draw(act_list, max_act_id, 'append');
    }
})
</script>
<script>
//接收母窗口传来的值
function MotherResultRec(data){
//        console.log(data);
    if (1 != data[2]){
        alert(data[3]);
    }
    
    
    switch (data[3]){
        case 'GetActGlobeInit': 
            //开始绘制列表页面,并设置最大值 
            var max_act_id = list_draw(data[4], 0, 'append');
            $.LS.set("act_list", JSON.stringify(data[4]));
            $.LS.set("max_act_id", max_act_id);
            break;
            
        case 'GetActInfo':
            //开始绘制面板                
            info_draw(data[4]);
            $.LS.set("act_info_" + data[4]['act_id'], JSON.stringify(data[4]));
            break;
            
        case 'RedrawActList':        
            //活动的更新、删除
            if (data[4]){
                var max_act_id = list_draw(data[4], $.LS.get("max_act_id"), 'prepend');      
                $.LS.set("act_list", JSON.stringify(data[4].concat(JSON.parse($.LS.get("act_list")))));
                $.LS.set("max_act_id", max_act_id);     
            }  
            break;
        //如果和RedrawActList放置一起时，如果打开多个实例则会出现同一份数据同步到localstorage两次，最后导致数据并排显示
        case 'B_ActListInsert':
            //WS的数据肯定是一条
            if (data[4]){
                var max_act_id = list_draw(data[4], $.LS.get("max_act_id"), 'prepend');
                $.LS.set("act_list", JSON.stringify(data[4].concat(JSON.parse($.LS.get("act_list")))));
                $.LS.set("max_act_id", max_act_id);     
            }  
            break;
            
        case 'B_ActListDele':
            if (data[4]){
                $("#" + data[4]).remove();
                old_list = JSON.parse($.LS.get("act_list"));
                for (var n in old_list){
                    if (old_list[n].act_id == data[4]){
                        old_list.splice(n, 1);
                        break;
                    }
                }
                //清除残余项
                if ($.LS.get("act_info_" + data[4])){
                    $.LS.remove("act_info_" + data[4]);
                }
                
                $.LS.set("act_list", JSON.stringify(old_list));
            }  
            break;
            
        case 'B_ActListUpdate':
            $.LS.set("act_info_" + data[4]['act_id'], JSON.stringify(data[4]));
            old_list = JSON.parse($.LS.get("act_list"));
            for (var n in old_list){
                if (old_list[n].act_id == data[4]['act_id']){
                    old_list.splice(n, 1, data[4]);
                    break;
                }
            }
            $.LS.set("act_list", JSON.stringify(old_list));
            break;
            
        <?php if($authorizee_act_update): ?>
        case 'ActUpdate':
            //列表即时修改
            $("#list_act_type_name_" + data[4]).html($("#act_type").val());
            $("#list_act_name_" + data[4]).html($("#act_name").val());
            $("#list_section_name_" + data[4]).html($("#act_section_only").val());
            $("#list_act_start_" + data[4]).html($("#act_start").val());
            $("#list_act_end_" + data[4]).html($("#act_end").val());
            
            //广播自动更新活动                
            var B_data = new Array();
            B_data['src'] = '/act_list';
            B_data['api'] = location.href + '/B_ActListUpdate';
            B_data['group'] = "desktop|mobile";
            B_data['data'] = '{"user_key" : "<?= $user_key ?>", "user_id" : "<?= $user_id ?>"';
            B_data['data'] += ', "act_id" : "' + data[4] + '"}';
            parent.IframeSend(B_data, 'group');
            break;
        <?php endif; ?>
                
        <?php if($authorizee_act_dele): ?>
        case 'ActDele':
            //列表中即时删除
            $("#" + data[4]).remove();
            //清除LS残余项
            if ($.LS.get("act_info_" + data[4])){
                $.LS.remove("act_info_" + data[4]);
            }

            //广播自动删除活动                
            var B_data = new Array();
            B_data['src'] = '/act_list';
            B_data['api'] = location.href + '/B_ActListDele';
            B_data['group'] = "desktop|mobile";
            B_data['data'] = '{"user_key" : "<?= $user_key ?>", "user_id" : "<?= $user_id ?>"';
            B_data['data'] += ', "act_id" : "' + data[4] + '"}';
            parent.IframeSend(B_data, 'group');
            break;
        <?php endif;?>
            
        default :
            if (data[4]){
                $("#" + data[4]).focus();
            }
            break;
    }
}

//获取活动详情
function GetActInfo(act_id, act_name){
    $("#myModalLabel").html(act_name);    
    $("#act_info_body").html("<img src='<?= base_url('img/load.gif')?>'>");
    var data = new Array();
    if (!$.LS.get("act_info_" + act_id)){
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/GetActInfo';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
        data['data'] += ', "act_id" : "' + act_id + '"}';  
        parent.IframeSend(data);
    } else {
        var act_info = new Array();
        act_info = JSON.parse($.LS.get("act_info_" + act_id));
//        var data = new Array();
//        data['src'] = location.href;
//        data['api'] = location.href + '/RedrawActList';          
//        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
//        data['data'] += ', "max_act_id" : "' + max_act_id + '"}';  
//        parent.IframeSend(data);
        console.log(act_info);
        info_draw(act_info);
    }
}    

//对于活动的参加、修改、宣传、删除处理
//confirm为确认后执行
function act_deal(act_id, method, confirm){
    var data = new Array();    
    data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
    switch (method){
        case "join":
            if (!confirm){
                
            } else {
                data['api'] = location.href + '/ActJoin';
            }
            
            break;
            
        <?php if($authorizee_act_update): ?>    
        case "update":
            $("#act_deal_modal .modal-dialog").removeClass("modal-sm").addClass("modal-lg");
            
            if (!confirm){
                $('#act_deal_title').html('活动修改');
                $('#act_deal_body').html("<form class=\"form-horizontal\" id=\"act_deal_body_update\" role=\"form\"></form>");
                act_basic_info = JSON.parse($.LS.get('act_info_' + act_id));
                console.log(act_basic_info);
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_name\" class=\"col-sm-2 control-label\">活动名称</label><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" id=\"act_name\" value=\"" + act_basic_info['act_name'] +"\"></div></div>");
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_private\" class=\"col-sm-2 control-label\">社团内部活动</label><div class=\"col-sm-9\"><input type=\"checkbox\" id=\"act_private\"></div></div>");
                if (act_basic_info['act_private']){
                    $('#act_private').attr("checked", true);
                }
                
                //活动类型
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_type\" class=\"col-sm-2 control-label\">活动类别</label><div class=\"col-sm-9\"><select class=\"form-control\" id=\"act_type\"></div>");
                <?php foreach ($act_type as $act_type_item): ?>                    
                    $("#act_type").append("<option><?= $act_type_item['activity_type_name'] ?></option>");
                <?php endforeach; ?>
                //快速选中
                $("#act_type option:contains('" + act_basic_info['activity_type_name'] + "')").attr("selected", "selected");
                
                //部门限制
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_section_only\" class=\"col-sm-2 control-label\">部门限制</label><div class=\"col-sm-9\"><select class=\"form-control\" id=\"act_section_only\"></div>");
                $("#act_section_only").append("<option>不限制</option>");
                <?php foreach ($act_section as $act_section_item): ?>
                    $("#act_section_only").append("<option><?= $act_section_item['section_name'] ?></option>");
                <?php endforeach; ?>
                //快速选中
                if (!act_basic_info['act_global']){
                    $("#act_section_only option:contains('" + act_basic_info['section_name'] + "')").attr("selected", "selected");
                } else {
                    $("#act_section_only option:contains('不限制')").attr("selected", "selected");
                }
                
                //活动描述
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_content\" class=\"col-sm-2 control-label\">活动描述</label><div class=\"col-sm-9\"><textarea class=\"form-control\" rows=\"3\" id=\"act_content\">" + act_basic_info['act_content'] + "</textarea></div></div>");
                
                //活动注意事项
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_warn\" class=\"col-sm-2 control-label\">活动注意事项</label><div class=\"col-sm-9\"><textarea class=\"form-control\" rows=\"3\" placeholder=\"选填\"  id=\"act_warn\">" + act_basic_info['act_warn'] + "</textarea></div></div>");
                
                //活动开始时间
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_start\" class=\"col-sm-2 control-label\">活动开始时间</label><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" placeholder=\"例：2014-08-20 20:05:01\" id=\"act_start\" value=\"" + act_basic_info['act_start'] +"\"></div></div>");
                
                //活动结束时间
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_end\" class=\"col-sm-2 control-label\">活动结束时间</label><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" placeholder=\"例：2014-08-20 20:05:01\" id=\"act_end\" value=\"" + act_basic_info['act_end'] +"\"></div></div>");
                
                //活动需要资金
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_money\" class=\"col-sm-2 control-label\">活动需要资金/人</label><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" placeholder=\"选填\" id=\"act_money\" value=\"" + act_basic_info['act_money'] +"\"></div></div>");
                
                //活动位置
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_position\" class=\"col-sm-2 control-label\">活动地点</label><div class=\"col-sm-9\"><textarea class=\"form-control\" rows=\"3\" id=\"act_position\">" + act_basic_info['act_position'] + "</textarea></div></div>");
                
                //总人数限制
                $('#act_deal_body_update').append("<div class=\"form-group\"><label for=\"act_member_sum\" class=\"col-sm-2 control-label\">总人数限制</label><div class=\"col-sm-9\"><input type=\"text\" class=\"form-control\" placeholder=\"选填\" id=\"act_member_sum\" value=\"" + act_basic_info['act_money'] +"\"></div></div>");
                
                $('#act_deal_confirm').html('修改');
                $('#act_deal_confirm').attr('onclick', "act_deal(" + act_id + ", 'update', 1)")
                $('#act_deal_modal').modal('show');
            } else {
                $('.modal').modal('hide');
                data['api'] = location.href + '/ActUpdate';
                data['data'] += ', "act_name" : "' + $("#act_name").val() + '", "act_type" : "' + $("#act_type").val() + '"';
                data['data'] += ', "act_content" : "' + $("#act_content").val() + '", "act_warn" : "' + $("#act_warn").val() + '"';
                data['data'] += ', "act_start" : "' + $("#act_start").val() + '", "act_end" : "' + $("#act_end").val() + '"';
                data['data'] += ', "act_money" : "' + $("#act_money").val() + '", "act_position" : "' + $("#act_position").val() + '"';
                data['data'] += ', "act_member_sum" : "' + $("#act_member_sum").val() + '", "act_private" : "' + $("#act_private").prop("checked") + '"';
                data['data'] += ', "act_section_only" : "' + $("#act_section_only").val() + '"}'; 
            }
            
            break;
        <?php endif; ?>
        
        case "propagator":
            if (!confirm){
                
            } else {
                data['api'] = location.href + '/ActPropagator';
            }
            
            break;
        <?php if($authorizee_act_dele): ?>
        case "dele":            
            $("#act_deal_modal .modal-dialog").removeClass("modal-lg").addClass("modal-sm");
            if (!confirm){
                $('#act_deal_title').html('删除');
                $('#act_deal_body').html('您正在准备删除' + act_id + '活动');
                $('#act_deal_confirm').html('删除');
                $('#act_deal_confirm').attr('onclick', "act_deal(" + act_id + ", 'dele', 1)")
                $('#act_deal_modal').modal('show');
            } else {
                $('.modal').modal('hide');
                data['api'] = location.href + '/ActDele';
            }
            break;
        <?php endif; ?>
    }
    if (confirm){
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['data'] += ', "act_id" : "' + act_id + '"}';  
        parent.IframeSend(data);
    }
}

var current_act_id = 0;

//遍历数组绘制活动列表
//@para
//data 要遍历绘制的数组
//max_act_id 当前最大的活动id值
//insert_position 如有更新的插入位置（append/prepend）
function list_draw(data, max_act_id, insert_position){ 
    
    $.each(data, function(i, item){
        
        if (item['act_id'] * 1 > max_act_id){
            max_act_id = item['act_id'] * 1;
        }
        
        //防止重绘多绘错误
        if (current_act_id == item['act_id']){
            return true;
        }
        
        switch (insert_position){
            case "append":
                $("#act_list").append("<tr data-toggle=\"modal\" data-target=\"#act_info\" onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\">");
                break;

            case "prepend":
                $("#act_list").prepend("<tr data-toggle=\"modal\" data-target=\"#act_info\" onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\">");
                break;
        }
        //检测是否过期
        if (datetime_to_unix(item['act_end']) <= $.now()){
            $("#" + item['act_id']).append("<td id=\"list_act_type_name_" + item['act_id'] + "\"><span class=\"label label-default\">过期</span>" + item['activity_type_name'] + "</td>");
        } else {
            $("#" + item['act_id']).append("<td id=\"list_act_type_name_" + item['act_id'] + "\">" + item['activity_type_name'] + "</td>");
        }
        
        $("#" + item['act_id']).append("<td id=\"list_act_name_" + item['act_id'] + "\">" + item['act_name'] + "</td>");
        if ("0" == item['act_global']){
            $("#" + item['act_id']).append("<td id=\list_section_name_" + item['act_id'] + "\">" + item['section_name'] + "</td>");
        } else {
            $("#" + item['act_id']).append("<td>无限制</td>");
        }
        $("#" + item['act_id']).append("<td id=\"list_act_start_" + item['act_id'] + "\">" + item['act_start'] + "</td>");
        $("#" + item['act_id']).append("<td id=\"list_act_end_" + item['act_id'] + "\">" + item['act_end'] + "</td>");
        $("#" + item['act_id']).append("</tr>");  
        current_act_id = item['act_id'];
    });
    return max_act_id;
}
 
//绘制面板
function info_draw(data){
    $("#act_info_body").html("");
    $("#act_info_body").append("<dl class=\"dl-horizontal\"></dl>");
    $("#act_info_body dl").append("<dt><h4><strong>活动内容</strong></h4></dt><dd><h4>" + data['act_content'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>开展位置</strong></h4></dt><dd><h4>" + data['act_position'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>开始时间</strong></h4></dt><dd><h4>" + data['act_start'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>结束时间</strong></h4></dt><dd><h4>" + data['act_end'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>发起者姓名</strong></h4></dt><dd><h4>" + data['user_name'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>发起者电话</strong></h4></dt><dd><h4>" + data['user_telephone'] + "</h4></dd>");
    $("#act_info_body dl").append("<dt><h4><strong>发起者QQ</strong></h4></dt><dd><h4><a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&uin=" + data['user_qq'] + "&site=qq&menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:" + data['user_qq'] + ":52\">" + data['user_qq'] + "</a></h4></dd>");
    if ("0" != data['act_money']){
        $("#act_info_body dl").append("<dt><h4><strong>需要资金</strong></h4></dt><dd><h4>" + data['act_money'] + "</h4></dd>");
    }
    if (data['act_warn']){
        $("#act_info_body dl").append("<dt><h4><strong>注意事项</strong></h4></dt><dd><h4>" + data['act_warn'] + "</h4></dd>");
    }
    $("#act_info_body dl").append("<hr>");

    if ("1" == data['act_global']){
        $("#act_info_body dl").append("<center><h4><strong>本活动无部门限制</strong></h4></center>");
    } else {
        $("#act_info_body dl").append("<center><h4><strong>本活动仅限" + data['section_name'] + "成员参加</strong></h4></center>");
    }

    if ("1" == data['act_private']){
        $("#act_info_body dl").append("<center><h4><strong>本活动为社团内部活动</strong></h4></center>");
    }

    //添加点击事件
    $("#act_join").attr("onclick", "act_deal(" + data['act_id'] + ", 'join', 0)");
    $("#act_update").attr("onclick", "act_deal(" + data['act_id'] + ", 'update', 0)");
    $("#act_propagator").attr("onclick", "act_deal(" + data['act_id'] + ", 'propagator', 0)");
    $("#act_dele").attr("onclick", "act_deal(" + data['act_id'] + ", 'dele', 0)");
}

//date("Y-m-d H:i:s")转时间戳
function datetime_to_unix(datetime){
    var tmp_datetime = datetime.replace(/:/g,'-');
    tmp_datetime = tmp_datetime.replace(/ /g,'-');
    var arr = tmp_datetime.split("-");
    var now = new Date(Date.UTC(arr[0],arr[1]-1,arr[2],arr[3]-8,arr[4],arr[5]));
    return parseInt(now.getTime());
}
//时间戳/1000转date("Y-m-d H:i:s")
function unix_to_datetime(unix) {
    var now = new Date(parseInt(unix) * 1000);
    return now.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}
</script>
</html>
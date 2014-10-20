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
        <select class="form-control" id="act_section_only">
            <option>部门</option>
            <option>不限制</option>
            <?php foreach ($act_section as $act_section_item):?>
                <option><?= $act_section_item['section_name']?></option>
            <?php endforeach; ?>
        </select> 
    </div>
    <div class="form-group">
        <select class="form-control" id="act_section_only">
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
    
<div class="modal fade" id="act_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">               
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
</body>
<script>
$(function(){
    $('.dropdown-toggle').dropdown()
    //当没有max_act_id，即之前尚未进行localstorage存储或被清除数据的情况
    if (!$.LS.get("max_act_id")){
        var data = new Array();
        data['src'] = location.href;
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
        data['src'] = location.href;
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
        case 'B_ActListInsert':
            //活动的更新、删除
            if (data[4]){
                console.log(data[4]);
                var max_act_id = list_draw(data[4], $.LS.get("max_act_id"), 'prepend');      
                $.LS.set("act_list", JSON.stringify(data[4].concat(JSON.parse($.LS.get("act_list")))));
                $.LS.set("max_act_id", max_act_id);     
            }  
            break;
    }
}

//获取活动详情
function GetActInfo(act_id, act_name){
    $("#myModalLabel").html(act_name);    
    $(".modal-body").html("<img src='<?= base_url('img/load.gif')?>'>");
    var data = new Array();
    if (!$.LS.get("act_info_" + act_id)){
        data['src'] = location.href;
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
function act_deal(act_id, method){
    var data = new Array();
    data['src'] = location.href;
    switch (method){
        case "join":
            data['api'] = location.href + '/ActJoin';
            break;
        case "update":
            data['api'] = location.href + '/ActUpdate';
            break;
        case "propagator":
            data['api'] = location.href + '/ActPropagator';
            break;
        case "dele":
            data['api'] = location.href + '/ActDele';
            break;
    }
    data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
    data['data'] += ', "act_id" : "' + act_id + '"}';  
    parent.IframeSend(data);
}

//遍历数组绘制活动列表
//@para
//data 要遍历绘制的数组
//max_act_id 当前最大的活动id值
//insert_position 如有更新的插入位置（append/prepend）
function list_draw(data, max_act_id, insert_position){    
    $.each(data, function(i, item){
        if (item['act_id'] * 1 >= max_act_id){
            max_act_id = item['act_id'] * 1;
        } 
        
        switch (insert_position){
            case "append":
                $("#act_list").append("<tr data-toggle=\"modal\" data-target=\"#act_info\" onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\">");
                break;
                
            case "prepend":
                $("#act_list").prepend("<tr data-toggle=\"modal\" data-target=\"#act_info\" onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\">");
                break;
        }
        $("#" + item['act_id']).append("<td>" + item['activity_type_name'] + "</td>");
        $("#" + item['act_id']).append("<td>" + item['act_name'] + "</td>");
        if ("0" == item['act_global']){
            $("#" + item['act_id']).append("<td>" + item['section_name'] + "</td>");
        } else {
            $("#" + item['act_id']).append("<td>无限制</td>");
        }
        $("#" + item['act_id']).append("<td>" + item['act_start'] + "</td>");
        $("#" + item['act_id']).append("<td>" + item['act_end'] + "</td>");
        $("#" + item['act_id']).append("</tr>");  
               
    });
    return max_act_id;
}
 
//绘制面板
function info_draw(data){
    $(".modal-body").html("");
    $(".modal-body").append("<dl class=\"dl-horizontal\"></dl>");
    $(".modal-body dl").append("<dt><h4><strong>活动内容</strong></h4></dt><dd><h4>" + data['act_content'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>开展位置</strong></h4></dt><dd><h4>" + data['act_position'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>开始时间</strong></h4></dt><dd><h4>" + data['act_start'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>结束时间</strong></h4></dt><dd><h4>" + data['act_end'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>发起者姓名</strong></h4></dt><dd><h4>" + data['user_name'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>发起者电话</strong></h4></dt><dd><h4>" + data['user_telephone'] + "</h4></dd>");
    $(".modal-body dl").append("<dt><h4><strong>发起者QQ</strong></h4></dt><dd><h4><a target=\"_blank\" href=\"http://wpa.qq.com/msgrd?v=3&uin=" + data['user_qq'] + "&site=qq&menu=yes\"><img border=\"0\" src=\"http://wpa.qq.com/pa?p=2:" + data['user_qq'] + ":52\">" + data['user_qq'] + "</a></h4></dd>");
    if ("0" != data['act_money']){
        $(".modal-body dl").append("<dt><h4><strong>需要资金</strong></h4></dt><dd><h4>" + data['act_money'] + "</h4></dd>");
    }
    if (data['act_warn']){
        $(".modal-body dl").append("<dt><h4><strong>注意事项</strong></h4></dt><dd><h4>" + data['act_warn'] + "</h4></dd>");
    }
    $(".modal-body dl").append("<hr>");

    if ("1" == data['act_global']){
        $(".modal-body dl").append("<center><h4><strong>本活动无部门限制</strong></h4></center>");
    } else {
        $(".modal-body dl").append("<center><h4><strong>本活动仅限" + data['section_name'] + "成员参加</strong></h4></center>");
    }

    if ("1" == data['act_private']){
        $(".modal-body dl").append("<center><h4><strong>本活动为社团内部活动</strong></h4></center>");
    }

    //添加点击事件
    $("#act_join").attr("onclick", "act_deal(" + data['act_id'] + ", 'join')");
    $("#act_update").attr("onclick", "act_deal(" + data['act_id'] + ", 'update')");
    $("#act_propagator").attr("onclick", "act_deal(" + data['act_id'] + ", 'propagator')");
    $("#act_dele").attr("onclick", "act_deal(" + data['act_id'] + ", 'dele')");
}
</script>
</html>
/* 
 * 对于活动的列表控制和内容控制
 */

//获取活动列表
//STEP1:检测是否存在数据库，如没有则拉取数据后创建
//STEP2:读取网络状态，如断网情况下则仅读取数据库.如已联网，则从最大记录开始往里加入数据
//STEP3:读取活动修改列表
//STEP4:读取活动删除列表
var act_list_current_page = 0;
var act_list_page_step = 20;
//alert(user_key);
function GetActivityList(user_key, user_id, act_list_current_page, act_list_page_step){  
    if (!$.LS.get("max_act_id")){
        data = '{"user_key" : "' + user_key + '", "page" : "' + act_list_current_page + '", "limit" : "' + act_list_page_step + '"}';
        MobileSend('act_list/MobileGetActList', data);
    } else {
        var act_list = new Array();
        act_list = JSON.parse($.LS.get("act_list"));
        var max_act_id = $.LS.get("max_act_id");
        var data = new Array();
        data = '{"user_key" : "' + user_key + '", "page" : "' + act_list_current_page + '", "limit" : "' + act_list_page_step + '", "max_act_id" : "' + max_act_id + '"}';
        MobileSend('act_list/MobileGetActList', data);
        list_draw(act_list, max_act_id, 'append');
    }
}


function list_draw(data, max_act_id, insert_position){    
    $.each(data, function(i, item){
        if (item['act_id'] * 1 > max_act_id){            
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






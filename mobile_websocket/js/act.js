/* 
 * 对于活动的列表控制和内容控制
 */
//注意倒序
var act_list_current_num = 0;
var act_list_page_step = 20;
//alert(user_key);

//绑定事件
$(function(){
    $("#guest_login").attr("onclick", "GetActivityList(" + user_key + "," + user_id + "," + act_list_current_num + "," + act_list_page_step + ")");
});

/**    
*  @Purpose:    
*  移动端活动列表查询
*  
*  @Method Name:
*  GetActivityList(user_key, user_id, act_list_current_num, act_list_page_step)    
*  @Parameter: 
*  user_key 用户密钥
*  user_id  用户id
*  act_list_current_num  列表当前位置
*  act_list_page_step    偏移量    
*  @Return: 
* 
* 
*/
function GetActivityList(user_key, user_id, act_list_current_num, act_list_page_step){      
    if (!$.LS.get("max_act_id")){
        if (user_key && user_id){
        //为登录用户时
            data = '{"user_key" : "' + user_key + '", "user_id" : "' + user_id + '", "limit" : "' + act_list_page_step + '"}';
        }else {
            data = '{"limit" : "' + act_list_page_step + '"}';
        }
        MobileSend('act_list/MobileGetActListInit', data);
    } else {
        var act_list = new Array();
        act_list = JSON.parse($.LS.get("act_list"));
        var max_act_id = $.LS.get("max_act_id");
        var data = new Array();
        if (user_key && user_id){
        //为登录用户时
            data = '{"user_key" : "' + user_key + '", "user_id" : "' + user_id + '", "current" : "' + act_list_current_num + '", "limit" : "' + act_list_page_step + '", "max_act_id" : "' + max_act_id + '"}';
        }else {
            data = '{"current" : "' + act_list_current_num + '", "limit" : "' + act_list_page_step + '", "max_act_id" : "' + max_act_id + '"}';
        }
        MobileSend('act_list/MobileRedrawActList', data);
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

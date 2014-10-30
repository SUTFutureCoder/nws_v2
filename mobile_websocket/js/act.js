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
            data = '{"user_key" : "' + user_key + '", "user_id" : "' + user_id + '", "current" : "' + act_list_current_num + '", "limit" : "' + act_list_page_step + '", "standard_id" : "' + max_act_id + '"}';
        }else {
            data = '{"current" : "' + act_list_current_num + '", "limit" : "' + act_list_page_step + '", "standard_id" : "' + max_act_id + '"}';
        }
        MobileSend('act_list/MobileGetActList', data);
        list_draw(act_list, max_act_id, 'append');
    }   
}

var current_act_id = 0;
//遍历数组绘制活动列表
//@param
//data 要遍历绘制的数组
//max_act_id 当前最大的活动id值
//insert_position 如有更新的插入位置（append/prepend）
function list_draw(data, max_act_id, insert_position){    
    $.each(data, function(i, item){
        if ($("#" + item['act_id']).length){
            return true;
        }
        
        if (item['act_id'] * 1 > max_act_id){            
            max_act_id = item['act_id'] * 1;
        } 
        
        //防止重绘多绘错误
        if (current_act_id == item['act_id']){
            console.log(current_act_id);
            console.log(item['act_id']);
            return true;
        }
        
        switch (insert_position){
            case "append":
                $("#guest_act_list").append("<li onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\"></li>");
                break;

            case "prepend":
                $("#guest_act_list").prepend("<li onclick=\"GetActInfo(" + item['act_id'] + ", '" + item['act_name'] + "')\" id=\"" + item['act_id'] + "\"></li>");
                break;
        }
        
        var act_list_temp = "<a class=\"ui-btn ui-btn-icon-right ui-icon-carat-r\"><h1>" + item['act_name'] + "</h1>";
        if ("0" == item['act_global']){
            act_list_temp += "<p><strong>部门限制：" + item['section_name'] + "</strong></p>";
        } else {
            act_list_temp += "<p><strong>部门限制：无限制</strong></p>";
        }        
        act_list_temp += "<p class=\"ui-li-aside\"><strong>" + item['act_start'] + "至" + item['act_end'] + "</strong></p></a>";
        
        $("#" + item['act_id']).append(act_list_temp);  
    });
    return max_act_id;
}

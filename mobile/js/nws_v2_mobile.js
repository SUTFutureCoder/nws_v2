var base_url = "http://localhost/nws_v2/index.php";

$(function(){
   $("#log_button").css({         
        'text-align' : "center",
        'margin-bottom': ($(window).height() - $("#log_button").outerHeight())/2 - $(document).scrollTop() 
    });         
});

//获取活动列表
function GetActivityList(){
    $.ajax({
            type: "get",
            async: false,
            data : "func=getActList&PageNum=0",
            //url: "http://202.199.100.61/nws/mobile_server/getAct.php",
            url: base_url + "/act_list/MobileGetActList",
            dataType: "jsonp",
            jsonp: "callback",//传递给请求处理程序或页面的，用以获得jsonp回调函数名的参数名(一般默认为:callback)
            jsonpCallback:"flightHandler",//自定义的jsonp回调函数名称，默认为jQuery自动生成的随机函数名，也可以写"?"，jQuery会自动为你处理数据
            success: function(json){
               var content='';
                 $.each( json, function(i, item){
                               if(json[i].act_defunct == 0){

                                       content += "<li>";
                                       content += "<a href=\"#\" data-transition=\"slide\" onclick=\"goTo('ActInfo.html?act_id="+json[i].act_id+"&act_name="+json[i].act_name+
                                               "&section="+json[i].act_section+"&s_name="+json[i].act_s_name+"&telephone="+json[i].act_telephone+
                                               "&section_only="+json[i].act_section_only+"&content="+json[i].act_content+"&warn="+json[i].act_warn+
                                               "&start="+json[i].act_start+"&end="+json[i].act_end+"&money="+json[i].act_money+
                                               "&position="+json[i].act_position+"&regtime="+json[i].act_regtime+"&member_sum="+json[i].act_member_sum+
                                               "&join_num="+json[i].act_join_num+"&defunct="+json[i].act_defunct+"')\">";
                                       content += "<h2>" + json[i].act_name + "\t\t<br/>[" + json[i].act_section + "]</h2>";
                                       content += "<p><strong>";
                                       content += json[i].act_content;
                                       content += "<br/></strong></p>";
                                       content += "<p class=\"ui-li-aside\">\n\<a>自</a><strong>" + json[i].act_start + "</strong><br/><a>至</a><strong>" + json[i].act_end + "</strong><br/><a>活动地点:</a><strong>" + json[i].act_position + "</strong></p>";
                                       content += "</a></li> ";                                 
                                 }           
                               });				
                               $("#thelist").append(content).listview('refresh');		

            },
            error: function(){
                //alert('fail');
            }
        });		
}
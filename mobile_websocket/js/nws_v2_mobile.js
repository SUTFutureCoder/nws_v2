var server_ip = "127.0.0.1";
var base_url = "http://" + server_ip + "/nws_v2/main/index.php/";
var websocket = "ws://" + server_ip + ":8080/";
var user_id = 0;
if (!$.LS.get("user_key")){
    var user_key = 0;
} else {    
    var user_key = $.LS.get("user_key");
}


//if ('undefined' == user_key){
//    alert("a");
//}
var app_key = "ALLHAILNWS!";
var version = 2.00000;
var version_string = "alpha";
//判断是否联网，如未联网则调用本地存储
var online = 0;

$(function(){
   $("#log_button").css({         
        'text-align' : "center",
        'margin-bottom': ($(window).height() - $("#log_button").outerHeight())/2 - $(document).scrollTop() 
    }); 
    
});

//websocket
if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
WEB_SOCKET_SWF_LOCATION = "swf/WebSocketMain.swf";
WEB_SOCKET_DEBUG = true;
var ws, ping, ping_interval, reconnect_interval, name = 'null', user_list={};        

ws = new WebSocket(websocket);   
   
// 当socket连接打开时，输入用户名
ws.onopen = function() {  
    online = 1;    
    if (!user_key){
        ws.send(JSON.stringify({"type":"login","name":"guest","group":"mobile"}));
    }    else {
        //先开放游客登录
    }
//    setInterval("getping()",1000);
    
    data = '{"app_key" : "' + app_key + '", "version" : "' + version + '"}';
    MobileSend('mobile_basic/CheckUpdate', data);
};

//测试连接
//function getping(){ 
//    var date = new Date();
//    ping = date.getTime(); 
//    ws.send('{"type":"ping"}');
//}

// 当有消息时根据消息类型显示不同信息
ws.onmessage = function(e) {  
    var result = JSON.parse(e.data);  
    console.log(result);
    if (result[0] != 'p')
    {
        //alert(result[1]);
    }
    else
    {
        $(".btn").removeAttr("disabled");
        $(".btn").attr("value", "一键配置"); 
    }
    switch (result[0])
    {
        case "p":    //ping
            var date = new Date();
            i = 0;                    
            ping = date.getTime() - ping;
            //alert(date.getTime());
            alert("ping:" + ping + "ms");
            break;

        case "mobile":
            //对于手机端则result[1]为函数名称
            eval(result[1] + "(" + result + ")");
            break;
            
        case "update":       
            
            switch (result[1]){
                case 1:
                    if ($.LS.get("update_ignore") != result[2]){
                        $("#update_hidden_button").trigger("click");
//                    alert('发现新版本！版本号：' + result[2] + '下载地址：' + result[3]);
                        window.location.href = 'index.html#update_dialog';
                        $("#update_version").html(result[2]);
                        $("#update_notice").html(result[3]);
                        $("#app_update").attr("href", result[4]);
                        $("#update_ignore").attr("onclick", "UpdateIgnore(" + result[2] + ")");
                    }                      
                    break;                
            }  
            break;
            
        case 'notice':
            MessagePop(result[2], 2000, '');
            break;
    }
};

ws.onclose = function() {
    setTimeout(function(){  
        $.mobile.loading('show', {
            text: '服务器连接失败，进入离线模式',
            textVisible: true,
            theme:'b',
            textonly: true
//          html:'服务器连接失败<br/>进入离线模式'                        
        });  
    },1); 
    setTimeout(function(){
         $.mobile.loading('hide');
    }, 3500);
    console.log("服务端关闭了连接"); 
};

ws.onerror = function() {
    console.log("出现错误");              
};  

//统一发送接口
function MobileSend(api, data){
    ws.send('{"type":"mobile","api":"' + base_url + api +'","data":' + data + '}'); 
}

//忽略此版本
function UpdateIgnore(version){
    $.LS.set("update_ignore", version);
}

/* @Purpose: 
 * 即时消息提示
 * 
 * @Method Name:
 * 
 * 
 * @Parameter: 
 * data 数据
 * delay 持续时间
 * html  html代码字符串
 * :NOTICE: html将会覆盖data
 */

function MessagePop(data, delay, html){
    setTimeout(function(){  
        $.mobile.loading('show', {
            text: data,
            textVisible: true,
            theme:'b',
            textonly: true,
            html: html                        
        });  
    },1); 
    setTimeout(function(){
         $.mobile.loading('hide');
    }, delay);
}

/**
 * 初始化iScroll控件
 */
function scroll_guest_load_act_list() {
	pullDownEl = document.getElementById('pullDown');
	pullDownOffset = pullDownEl.offsetHeight;
	pullUpEl = document.getElementById('pullUp');	
	pullUpOffset = pullUpEl.offsetHeight;
	
	myScroll = new iScroll('wrapper_guest_act_list', {
		scrollbarClass: 'myScrollbar', /* 重要样式 */
		useTransition: true, /* 此属性不知用意，本人从true改为false */
		topOffset: pullDownOffset,
		onRefresh: function () {
			if (pullDownEl.className.match('loading')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
			} else if (pullUpEl.className.match('loading')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
			}
		},
		onScrollMove: function () {
			if (this.y > 5 && !pullDownEl.className.match('flip')) {
				pullDownEl.className = 'flip';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '松手开始更新...';
				this.minScrollY = 0;
			} else if (this.y < 5 && pullDownEl.className.match('flip')) {
				pullDownEl.className = '';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
				this.minScrollY = -pullDownOffset;
			} else if (this.y < (this.maxScrollY - 5) && !pullUpEl.className.match('flip')) {
				pullUpEl.className = 'flip';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '松手开始更新...';
				this.maxScrollY = this.maxScrollY;
			} else if (this.y > (this.maxScrollY + 5) && pullUpEl.className.match('flip')) {
				pullUpEl.className = '';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
				this.maxScrollY = pullUpOffset;
			}
		},
		onScrollEnd: function () {
			if (pullDownEl.className.match('flip')) {
				pullDownEl.className = 'loading';
				pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';				
				pullDownAction();	// Execute custom function (ajax call?)
			} else if (pullUpEl.className.match('flip')) {
				pullUpEl.className = 'loading';
				pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';				
				pullUpAction();	// Execute custom function (ajax call?)
			}
		}
	});
	
	//setTimeout(function () { document.getElementById('wrapper').style.left = '0'; }, 800);
}
//初始化绑定iScroll控件 
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', scroll_guest_load_act_list, false); 

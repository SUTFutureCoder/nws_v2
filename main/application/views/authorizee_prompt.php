<!DOCTYPE html>  
<html>  
<head>  
    <title></title>             
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">     
</head>
<body>
    <br/>
    <form class="form-horizontal" role="form"> 
    <div class="form-group">
        <label for="update_user_number" class="col-sm-2 control-label">用户学号</label>
        <div class="col-sm-9">
            <input type="type" class="form-control" id="update_user_number" >
        </div>
    </div>    
    <div class="form-group">
    <label for="update_role" class="col-sm-2 control-label">修改角色</label>
    <div class="col-sm-9">
        <select class="form-control" id="update_role">
        <?php foreach ($role as $role_item): ?>
            <option><?= $role_item['role_name'] ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    </div>
    <hr>
    <div class="col-sm-10 col-sm-offset-1">
        <input class="form-control btn btn-danger" id="submit" onclick="UpdateConfirm()" value="确认">
    </div>    
    </form>
    <div id="confirm">        
    </div>
</body>
<script>
//    alert(location.href.slice(0, location.href.lastIndexOf("/")));
//发送到母窗口
    function MotherIframeSend(){  
        if (!$("#role_type").val()){
            alert("请选择一个角色进行操作");
            return 0;
        }
        var authorizee_list = new Array();
        $("input[type=checkbox]:checked").each(function(){
            authorizee_list.push($(this).attr("num"));
        });
        //console.log(authorizee_list);
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/SetRoleAuthorizee';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';        
        data['data'] += ', "role_type" : "' + $("#role_type").val() + '", "authorizee_list" : "' + authorizee_list + '"}';            
        parent.IframeSend(data);
    }
    //接收母窗口传来的值
    function MotherResultRec(data){
//        console.log(data); 
        if (data[3] != 'GetPromptUserBasic'){
            alert(data[3]);      
            //如果更改自己账号则需要重新登录
            if (data[2] == 2){
                 window.parent.window.location.href = '../index.php';
            }
        } else {
            //生成面板
            $("#confirm").html("");
            var title = '确认更改';
            var modal = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            modal += '<h4 class="modal-title" id="myModalLabel">' + title + '</h4></div>';
            modal += '<div class="modal-body"></div>';
            modal += '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">取消</button><button type="button" class="btn btn-danger" onclick="Submit()">确认</button></div></div></div></div>';
            $("#confirm").append(modal);
            $(".modal-body").append('<dl class="dl-horizontal"></dl>');
            $(".modal-body dl").append('<dt><h4><strong>部门</strong></h4></dt><dd><h4>' + data[4]['user_section'] + '</h4></dd><hr>');
            $(".modal-body dl").append('<dt><h4><strong>学号</strong></h4></dt><dd><h4>' + data[4]['user_number'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>姓名</strong></h4></dt><dd><h4>' + data[4]['user_name'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>性别</strong></h4></dt><dd><h4>' + data[4]['user_sex'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>联系方式</strong></h4></dt><dd><h4>' + data[4]['user_telephone'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>QQ</strong></h4></dt><dd><h4>' + data[4]['user_qq'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>专业</strong></h4></dt><dd><h4>' + data[4]['user_major'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>特长</strong></h4></dt><dd><h4>' + data[4]['user_talent'] + '</h4></dd>');
            $(".modal-body dl").append('<dt><h4><strong>加入时间</strong></h4></dt><dd><h4>' + data[4]['user_reg_time'] + '</h4></dd>');            
            $('#myModal').modal('toggle');
        }
    }
    
    //确认修改
    function UpdateConfirm(){
        var update_user_number = $("#update_user_number").val();
        if ("" != update_user_number){
            var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/GetPromptUserBasic';
            data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id?>", "update_user_number" : "' + update_user_number + '"}';
            parent.IframeSend(data);
        } else {
            alert('学号不能为空');
            $("#user_number").focus();
        }
    }
    
    //提交
    function Submit(){
        var update_user_number = $("#update_user_number").val();
        var data = new Array();
        data['src'] = location.href.slice((location.href.lastIndexOf("/")));
        data['api'] = location.href + '/UpdateRole';
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id?>", "update_user_number" : "' + update_user_number + '", "role" : "' + $("#update_role").val() + '"}';
        parent.IframeSend(data);        
    }
</script>
</html>
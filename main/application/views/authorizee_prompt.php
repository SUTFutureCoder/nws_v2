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
        <input class="form-control btn btn-danger" id="submit" onclick="UpdateComfirm()" value="确认">
    </div>    
    </form>
</body>
<script>
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
        if (data[4] != 'GetPromptUserBasic'){
            alert(data[3]);        
        } else {
            //生成面板
            
        }
    }
    
    //确认修改
    function UpdateComfirm(){
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
</script>
</html>
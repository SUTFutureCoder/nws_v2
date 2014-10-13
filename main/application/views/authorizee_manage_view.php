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
        <label for="role_type" class="col-sm-2 control-label">角色类型</label>
        <div class="col-sm-9">
            <select class="form-control" id="role_type">
                <?php foreach ($role as $role_item):?>
                    <option><?= $role_item['role_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>        
    <hr>
    <div class="col-sm-10 col-sm-offset-1">
        <input class="form-control btn btn-success" id="submit" onclick="MotherIframeSend()" value="提交">
    </div>
    <br/>
    <br/>
    <hr>
    </form>
</body>
<script>
$(function(){
    $("#role_type").change(function (){
        var data = new Array();
        data['src'] = location.href;
        data['api'] = location.href + '/GetRoleAuthorizeeList';
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
        data['data'] += ', "role_type" : "' + $("#role_type").val() + '"}'; 
        console.log(data);
        parent.IframeSend(data);
    });
});
</script>
<script>
//发送到母窗口
    function MotherIframeSend(){      
        var data = new Array();
        data['src'] = location.href;
        data['api'] = location.href + '/ActAdd';          
        data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
        data['data'] += ', "act_name" : "' + $("#act_name").val() + '", "act_type" : "' + $("#act_type").val() + '"';
        data['data'] += ', "act_content" : "' + $("#act_content").val() + '", "act_warn" : "' + $("#act_warn").val() + '"';
        data['data'] += ', "act_start" : "' + $("#act_start").val() + '", "act_end" : "' + $("#act_end").val() + '"';
        data['data'] += ', "act_money" : "' + $("#act_money").val() + '", "act_position" : "' + $("#act_position").val() + '"';
        data['data'] += ', "act_member_sum" : "' + $("#act_member_sum").val() + '", "act_private" : "' + $("#act_private").prop("checked") + '"';
        data['data'] += ', "act_section_only" : "' + $("#act_section_only").val() + '"}';            
        //console.log(data);
        parent.IframeSend(data);
    }
    //接收母窗口传来的值
    function MotherResultRec(data){
//        console.log(data);       
        alert(data[3]);
        if (data[4]){
            $("#" + data[4]).focus();
        }
    }
</script>
</html>
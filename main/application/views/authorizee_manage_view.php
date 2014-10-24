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
                <option></option>
                <?php foreach ($role as $role_item):?>
                    <option><?= $role_item['role_name']?></option>
                <?php endforeach; ?>
            </select> 
        </div>
    </div>
    <hr>
    <div class="form-group">
    <div class="col-sm-10 col-sm-offset-1">
        <?php foreach ($type as $type_item): ?>
        <div class="panel panel-primary ">        
            <div class="panel-heading"><?= $type_item['authorizee_column_name'] ?></div>
            <?php if (isset($authorizee_group[$type_item['authorizee_column_id']])): ?>
            <?php foreach ($authorizee_group[$type_item['authorizee_column_id']] as $authorizee_group_item): ?>
            <table class="table table-striped table-hover" id="type<?= $type_item['authorizee_column_id'] ?>">
                <tbody>
                    <tr>
                        <td>
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="authorizee<?= $authorizee_group_item['authorizee_id']?>" num="<?= $authorizee_group_item['authorizee_id'] ?>"><?= $authorizee_group_item['authorizee_describe'] ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
    <hr>
    <div class="col-sm-10 col-sm-offset-1">
        <input class="form-control btn btn-danger" id="submit" onclick="MotherIframeSend()" value="确认">
    </div>
    <br/>
    <br/>
    <hr>
    </form>
</body>
<script>
$(function(){
    $("#role_type").change(function (){    
        //重置
        $("input[type=checkbox]").each(function(){
            $(this).prop("checked", false);
        });
        if ($("#role_type").val()){
            var data = new Array();
            data['src'] = location.href.slice((location.href.lastIndexOf("/")));
            data['api'] = location.href + '/GetRoleAuthorizeeList';
            data['data'] = '{"user_key" : "<?= $user_key?>", "user_id" : "<?= $user_id ?>"';
            data['data'] += ', "role_type" : "' + $("#role_type").val() + '"}'; 
            console.log(data);
            parent.IframeSend(data);
        }
    });
});
</script>
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
        if (data[4] != 'GetRoleAuthorizee'){
            alert(data[3]);        
        } else {
            //开始打钩
            for (var n in data[3]){                
                $("#authorizee" + n).prop("checked", true);
            }
        }
    }
</script>
</html>
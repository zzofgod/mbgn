<?php
$user_index = 'active';
require('../public/common.php');
checkLogin();
$data = array();
$name = $_SESSION['user'];
$query = mysqli_query($connect, "select * from users where nick='" . $name . "';");
if (!$query) exit("数据库查询失败！");

while ($item = mysqli_fetch_assoc($query)) {
    $data = $item;
}

if (empty($data['avatar'])) {
    if ($data['gender'] == '0') {
        $default_avatar = '../static/img/0.png';
    } else if ($data['gender'] == '1') {
        $default_avatar = '../static/img/1.png';
    } else {
        $default_avatar = '../static/img/2.png';
    }
} else {
    $default_avatar = $data['avatar'];
}

$gender0 = '';
$gender1 = '';
$gender2 = '';
if ($data['gender'] == 0) {
    $gender0 = 'checked';
} else if ($data['gender'] == 1) {
    $gender1 = 'checked';
} else {
    $gender2 = 'checked';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="../static/lib/layui/css/layui.css">
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">个人中心</h2>
        <form>

            <input type="hidden" name="id" id="id" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <div><label for="avatar">头像</label></div>
                <a href="../<?php echo $default_avatar ?>"><img style="margin-bottom:0px" height="200" id="avatar" src="../<?php echo $default_avatar ?>" /></a>
            </div>
            <a href="avatar.php" class="btn btn-default">修改头像</a><a href="password.php" class="btn btn-default" style="margin-left:20px">修改密码</a>
            <div style="margin-top:20px" class="form-group">
                <label for="username">用户名</label>
                <input type="text" class="form-control" id="username" name="username" required minlength="6" maxlength="16" value="<?php echo $data['username']; ?>">
            </div>
            <div class="form-group">
                <label for="nick">昵称</label>
                <input type="text" class="form-control" id="nick" name="nick" required minlength="2" maxlength="10" value="<?php echo $data['nick']; ?>">
            </div>
            <div class="form-group">
                <label for="gender">性别</label><br>
                <input type="radio" name="gender" id="nan" value="0" <?php echo $gender0 ?>>
                <label for="nan">男</label>
                <input type="radio" name="gender" id="nv" value="1" <?php echo $gender1 ?>>
                <label for="nv">女</label>
                <input type="radio" name="gender" id="mi" value="2" <?php echo $gender2 ?>>
                <label for="mi">保密</label>
            </div>
            <div class="form-group">
                <label for="birthday">生日</label>
                <input type="date" class="form-control" id="birthday" name="birthday" required value="<?php echo $data['birthday']; ?>">
            </div>
            <div class="form-group">
                <label for="age">年龄</label>
                <input type="number" disabled class="form-control" id="age" name="age" value="<?php echo getAge($data['birthday']); ?>">
            </div>
            <button id="submit" type="button" class="btn btn-success">修改</button>
            <a href="../index.php" class="btn btn-danger">取消</a>
        </form>
    </div>

    </div>
    </div>
    <script src="../static/lib/layui/layui.all.js"></script>
    <script>
        $(function() {
            $("#submit").click(function() {
                $.ajax({
                    type: "POST",
                    url: 'edit.php',
                    data: {
                        id: $("#id").val(),
                        username: $('#username').val(),
                        nick: $('#nick').val(),
                        gender: $('input:radio:checked').val(),
                        birthday: $('#birthday').val(),
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data.code);
                        if (data.code == 4) {
                            layer.tips('用户名不能为空！', '#username', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 1) {
                            layer.tips('昵称不能为空！', '#nick', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 2) {
                            layer.tips('用户名长度必须为6到16位字符！', '#username', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 3) {
                            layer.tips('昵称长度必须为2到10位字符!', '#nick', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 5) {
                            layer.alert('修改失败！，再试一次！');
                        } else if (data.code == 6) {
                            layer.tips('用户名已被注册!', '#username', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 7) {
                            layer.tips('昵称已被注册!', '#nick', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 8) {
                            layer.confirm('恭喜您！修改成功！', {
                                btn: ['刷新'] //按钮
                            }, function() {
                                window.location = "index.php"
                            }, function() {});
                        } else {
                            layer.alert('服务器异常', {
                                icon: 5
                            });
                        }
                    },
                    error: function(err) {
                        //console.log(err.responseText)
                    }
                })
                return false;
            })
        })
    </script>
</body>

</html>
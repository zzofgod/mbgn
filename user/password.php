<?php
require('../public/common.php');
checkLogin();
$name = $_SESSION['user'];
$query = mysqli_query($connect, "select * from users where nick='" . $name . "';");
if (!$query) exit("数据库查询失败！");

while ($item = mysqli_fetch_assoc($query)) {
    $data = $item;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>修改密码</title>
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
    <style>
        table tr td {
            line-height: 100px !important;
        }
    </style>
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">修改密码</h2>
        <form method="post">
            <input type="hidden" name="id" id="id" value="<?php echo $data['id'] ?>">
            <div style="margin-top:20px" class="form-group">
                <label for="username">用户名</label>
                <input type="text" class="form-control" id="username" name="username" disabled value="<?php echo $data['username']; ?>">
            </div>
            <div class="form-group">
                <label for="old">原密码</label>
                <input type="text" class="form-control" id="old" name="old">
            </div>
            <div class="form-group">
                <label for="new">新密码</label>
                <input type="password" class="form-control" id="new" name="new">
            </div>
            <div class="form-group">
                <label for="renew">确认密码</label>
                <input type="possword" class="form-control" id="renew" name="renew">
            </div>
            <button id="submit" type="button" class="btn btn-success">修改</button>
            <a href="index.php" type="button" class="btn btn-danger">取消</a>
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
                    url: 'editpassworld.php',
                    data: {
                        id: $("#id").val(),
                        old: $('#old').val(),
                        new: $('#new').val(),
                        renew: $('#renew').val(),
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data.code)
                        if (data.code == 1) {
                            layer.tips('原密码不能为空！', '#old', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 2) {
                            layer.tips('新密码不能为空！', '#new', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 3) {
                            layer.tips('新密码不能为空！', '#renew', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 4) {
                            layer.alert('修改失败！，稍后重试！');
                        } else if (data.code == 5) {
                            layer.tips('密码长度必须为6到16位字符!', '#old', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 6) {
                            layer.tips('密码长度必须为6到16位字符!', '#new', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 7) {
                            layer.tips('两次密码输入不一致!', '#renew', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 8) {
                            layer.alert('修改失败！，稍后重试！');
                        } else if (data.code == 9) {
                            layer.tips('新密码和原密码重复！', '#renew', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 10) {
                            layer.tips('密码错误！', '#old', {
                                time: 2000,
                                tips: 2
                            });
                        } else {
                            layer.confirm('恭喜您！修改成功！', {
                                btn: ['刷新'] //按钮
                            }, function() {
                                window.location = "index.php"
                            }, function() {});
                        }
                    },
                    error: function(err) {
                        //console.log(err.responseText)
                    }
                })
                // if ($("#old").val() == '') {
                //     layer.tips('原密码不能为空', '#old', {
                //         time: 2000,
                //         tips: 2
                //     });
                //     return false;
                // } else if ($("#new").val() == '') {
                //     layer.tips('新密码不能为空', '#new', {
                //         time: 2000,
                //         tips: 2
                //     });
                //     return false;
                // } else if ($("#old").val().length < 6 || $("#old").val().length > 16) {
                //     layer.tips('密码长度必须为6到16位字符', '#old', {
                //         time: 2000,
                //         tips: 2
                //     });
                //     return false;
                // } else if ($("#new").val().length < 6 || $("#new").val().length > 16) {
                //     layer.tips('密码长度必须为6到16位字符', '#new', {
                //         time: 2000,
                //         tips: 2
                //     });
                //     return false;
                // } else if ($("#new").val() != $("#renew").val()) {
                //     layer.tips('两次密码不一致', '#renew', {
                //         time: 2000,
                //         tips: 2
                //     });
                //     return false;
                // } else {

                // }
            })
        })
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>用户注册</title>
    <link rel="stylesheet" href="static/lib/layui/css/layui.css">
    <link href="static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/register.css">
</head>

<body>

    <div class="container">
        <form class="form-signin">
            <h2 class="form-signin-heading">用户注册</h2>
            <label for="username" class="sr-only">用户名</label>
            <input type="text" id="username" class="form-control" placeholder="请输入用户名" name="username" autofocus>
            <label for="nick" class="sr-only">昵称</label>
            <input type="text" id="nick" class="form-control" placeholder="请输入昵称" name="nick" autofocus>
            <label for="password" class="sr-only">密码</label>
            <input type="password" id="password" class="form-control" placeholder="请输入密码" name="password">
            <label for="repassword" class="sr-only">确认密码</label>
            <input type="password" id="repassword" class="form-control" placeholder="再次确认密码" name="repassword">
            <label for="repassword" class="sr-only">性别</label>
            <label for></label>
            验证码：<input type="text" name='authcode' size="4" id="authcode" value='' />
            <img id="captcha_img" border='1' src='server/captcha.php?r=echo rand(); ?>' style="width:100px; height:30px" />
            <a href="#" id="change">换一个?</a>
            <div class="checkbox">
                <a href="login.php">已有账号？去登录</a>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="button" id="submit">注册</button>
        </form>
    </div>
    <script src="static/lib/jquery/jquery.min.js"></script>
    <script src="static/lib/layui/layui.all.js"></script>
    <script>
        $(function() {
            var layer = layui.layer
            $("#change").click(function(e) {
                e.preventDefault();
                $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
            })
            $('#submit').click(function() {
                var username = $('#username').val(),
                    password = $('#password').val(),
                    repassword = $('#repassword').val(),
                    nick = $('#nick').val(),
                    authcode = $('#authcode').val();
                if (username == '' || username.length <= 0) {
                    layer.tips('用户名不能为空', '#username', {
                        time: 2000,
                        tips: 2
                    });
                    $('#username').focus();
                    return false;
                }
                if (username.length < 6 || username.length > 16) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('用户名长度必须为6到16位字符', '#username', {
                        time: 2000,
                        tips: 2
                    });
                    $('#username').focus();
                    return false;
                }

                if (nick == '' || nick.length <= 0) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('昵称不能为空', '#nick', {
                        time: 2000,
                        tips: 2
                    });
                    $('#nick').focus();
                    return false;
                }
                if (nick.length < 2 || nick.length > 10) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('昵称长度必须为2到10位字符', '#nick', {
                        time: 2000,
                        tips: 2
                    });
                    $('#nick').focus();
                    return false;
                }

                if (password == '' || password.length <= 0) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('密码不能为空', '#password', {
                        time: 2000,
                        tips: 2
                    });
                    $('#password').focus();
                    return false;
                }

                if (password.length < 6 || password.length > 16) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('密码长度必须为6到16位字符', '#password', {
                        time: 2000,
                        tips: 2
                    });
                    $('#password').focus();
                    return false;
                }

                if (repassword == '' || repassword.length <= 0 || (password != repassword)) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('两次密码输入不一致', '#repassword', {
                        time: 2000,
                        tips: 2
                    });
                    $('#repassword').focus();
                    return false;
                }

                if (repassword.length < 6 || repassword.length > 16) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('密码长度必须为6到16位字符', '#password', {
                        time: 2000,
                        tips: 2
                    });
                    $('#password').focus();
                    return false;
                }

                if (authcode.length == '' || authcode.length <= 0) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('验证码长度必须为4位', '#authcode', {
                        time: 2000,
                        tips: 4
                    });
                    $('#authcode').focus();
                    return false;
                }

                if (authcode.length != 4) {
                    $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                    layer.tips('验证码长度必须为4位', '#authcode', {
                        time: 2000,
                        tips: 4
                    });
                    $('#authcode').focus();
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "server/register.php",
                    data: {
                        username: $("#username").val(),
                        password: $("#password").val(),
                        authcode: $("#authcode").val(),
                        nick: $("#nick").val(),
                        repassword: $("#repassword").val()
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data)
                        if (data.code == 0) {
                            $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                            layer.tips('验证码错误', '#authcode', {
                                time: 2000,
                                tips: 4
                            });
                        } else if (data.code == 1) {
                            $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                            layer.tips('用户名已被注册', '#username', {
                                time: 2000,
                                tips: 2
                            });
                        } else if (data.code == 2) {
                            layer.confirm('恭喜您！注册成功！', {
                                btn: ['去登录', '关闭'] //按钮
                            }, function() {
                                window.location = "login.php"
                            }, function() {});
                        } else if (data.code == 3) {
                            $("#captcha_img").attr("src", 'server/captcha.php?r=' + Math.random());
                            layer.tips('昵称已被注册', '#nick', {
                                time: 2000,
                                tips: 2
                            });
                        } else {
                            layer.alert('注册失败！，再试一次！');
                        }
                    }
                })
                return true;
            })
        })
    </script>
</body>
<!--https://www.cnblogs.com/m-m-g-y0416/p/5689797.html-->

</html>
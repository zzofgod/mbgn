<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>提示</title>
    <link rel="stylesheet" href="static/lib/layui/css/layui.css">
    <link href="static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/register.css">
</head>

<body>
    <!-- <div style="margin:0 auto;width:300px;text-align:center;margin-top:400px">
        <h3><a href="login.php">去登录</a></h3>
        <h3><a href="register.php">去注册</a></h3>
    </div> -->
    <script src="static/lib/jquery/jquery.min.js"></script>
    <script src="static/lib/layui/layui.all.js"></script>
    <script>
        $(function() {
            layer.confirm('登录过期了，请重新登录！', {
                btn: ['去登录', '去注册'] //按钮
            }, function() {
                window.location = "login.php";
            }, function() {
                window.location = "register.php";
            });
        })
    </script>
</body>
<!--https://www.cnblogs.com/m-m-g-y0416/p/5689797.html-->

</html>
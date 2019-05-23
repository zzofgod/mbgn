<?php
//表单进行了提交处理
session_start();
if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repassword']) && !empty($_POST['nick']) && !empty($_POST['authcode'])) {

    require("common.php");
    $username = trim($_POST['username']); //mysql_real_escape_string()进行过滤
    $nick = trim($_POST['nick']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    $time = date('Y-m-d H:i:s');
    $authcode = $_POST['authcode'];
    $query = mysqli_query($connect, "select count(id) as id from users where username='{$username}';");
    if (!$query) {
        die(json_encode(array("code" => "4")));
        exit("服务器错误");
    }
    $query_nick = mysqli_query($connect, "select count(id) as id from users where nick='{$nick}';");
    if (!$query_nick) {
        die(json_encode(array("code" => "4")));
        exit("服务器错误");
    }
    $result = mysqli_fetch_assoc($query);
    $result1 = mysqli_fetch_assoc($query_nick);
    if (isset($result['id']) && $result['id'] > 0) {
        // echo "<h2>注册失败,用户名重复</h2><a href='../register.php'>返回</a>";
        die(json_encode(array("code" => "1")));
        exit();
    } elseif (isset($result1['id']) && $result1['id'] > 0) {
        // echo "<h2>注册失败,昵称重复</h2><a href='../register.php'>返回</a>";
        die(json_encode(array("code" => "3")));
        exit();
    } elseif (strtolower($authcode) != $_SESSION['authcode']) {
        // echo "<h2>注册失败,验证码错误</h2><a href='../register.php'>返回</a>";
        die(json_encode(array("code" => "0")));
        exit();
    } else {
        $query_ok = mysqli_query($connect, "insert into users values(null,'{$username}','{$password}','{$nick}','{$time}','../static/img/2.png','{$time}',2,null);");
        if (!$query_ok) {
            die(json_encode(array("code" => "4")));
            exit("服务器错误");
        }
        // echo "<h2>注册成功</h2><a href='../login.php'>返回登录</a>";
        die(json_encode(array("code" => "2")));
    }
}

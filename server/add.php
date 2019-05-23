<?php
require('common.php');
checkLogin();
if (empty($_POST['name'] || empty($_POST['msg']))) {
    echo "错误，数据不能为空！";
}
$name = $_POST['name'];
$msg = $_POST['msg'];
$www = $_POST['www'];
$time = date('Y-m-d H:i:s');
$user = $_SESSION["user"];
$query = mysqli_query($connect, "insert into template values(null,'{$name}','{$msg}','{$www}','{$time}');");
if (!$query) {
    exit("添加失败");
}
$ip = get_server_ip();
$query_history = mysqli_query($connect, "insert into history values(null,'{$ip}','{$user}','{$time}','{$msg}','{$www}','增加');");
if (!$query_history) {
    exit("添加失败");
}
header("Location: ../index/index.php");

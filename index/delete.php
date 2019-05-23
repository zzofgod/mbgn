<?php
require("../public/common.php");
checkLogin();
if (empty($_GET["id"])) {
    echo "删除失败";
    return;
}
$id = $_GET["id"];
$name = $_GET["name"];
$query_data = mysqli_query($connect, 'select msg,www,name from template where id=' . $id . ';');
if (!$query_data) {
    exit("数据库查询失败");
}
$item = mysqli_fetch_assoc($query_data);
$msg = $item["msg"];
$www = $item["www"];
$query_delete = mysqli_query($connect, 'delete from template where id=' . $id . ';');
if (!$query_delete) {
    exit("数据库查询失败");
}
$time = $time = date('Y-m-d H:i:s');
$ip = get_server_ip();
$query_history = mysqli_query($connect, "insert into history values(null,'{$ip}','{$name}','{$time}','{$msg}','{$www}','删除');");
if (!$query_history) {
    exit("添加失败");
}
header("Location:index.php");

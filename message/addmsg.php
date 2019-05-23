<?php
require('../public/common.php');
checkLogin();
//后端验证
if (empty($_POST['nick'])) {
    die(json_encode(array("code" => "1")));
} else if (empty($_POST['msg'])) {
    die(json_encode(array("code" => "2")));
    return;
} else if (strlen($_POST['nick']) < 2 || strlen($_POST['nick']) > 10) {
    die(json_encode(array("code" => "3")));
    return;
} else if (strlen($_POST['msg']) < 5 || strlen($_POST['msg']) > 100) {
    die(json_encode(array("code" => "4")));
    return;
} else {
    $nick = $_POST['nick'];
    $msg = $_POST['msg'];
    $time = date('Y-m-d H:i:s');
    $query = mysqli_query($connect, "select avatar from users where nick='{$nick}';");
    if (!$query) {
        exit("服务器异常");
    }
    $avatar = mysqli_fetch_assoc($query)['avatar'];
    $query = mysqli_query($connect, "insert into msg values(null,'{$nick}','{$msg}','{$time}','{$avatar}');");
    if (!$query) {
        die(json_encode(array("code" => "5")));
        exit;
    }
    die(json_encode(array("code" => "0")));
}

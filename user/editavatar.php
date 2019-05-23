<?php
require('../public/common.php');
checkLogin();
//后端验证

$id = $_POST['id'];
if (!empty($_FILES['avatar'])) {
    require("../class/Upload.php");
    $upload = new Upload();
    $avatar = $upload->uploadFile('avatar');
}

$query = mysqli_query($connect, "update users set avatar='{$avatar}' where id=" . $id . ";");
if (!$query) {
    exit("上传失败");
}

header('Location:avatar.php');

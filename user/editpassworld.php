<?php
require('../public/common.php');
checkLogin();
$id = $_POST['id'];
$old = $_POST['old'];
$new = $_POST['new'];
$renew = $_POST['renew'];

if (empty($old)) {
    die(json_encode(array("code" => "1")));
    return;
} else if (empty($new)) {
    die(json_encode(array("code" => "2")));
    return;
} else if (empty($renew)) {
    die(json_encode(array("code" => "3")));
    return;
} else if (empty($id)) {
    die(json_encode(array("code" => "4")));
    return;
} else if (strlen($old) < 6 || strlen($old) > 16) {
    die(json_encode(array("code" => "5")));
    return;
} else if (strlen($new) < 6 || strlen($new) > 16) {
    die(json_encode(array("code" => "6")));
    return;
} else if ($new != $renew) {
    die(json_encode(array("code" => "7")));
    return;
} else {
    $query = mysqli_query($connect, "select password from users where id={$id};");
    if (!$query) {
        die(json_encode(array("code" => "8")));
        exit("服务器错误");
    }
    $oldpassworld = mysqli_fetch_assoc($query)['password'];
    if ($new == $oldpassworld) {
        die(json_encode(array("code" => "9")));
    } else if ($old != $oldpassworld) {
        die(json_encode(array("code" => "10")));
    } else {
        $query = mysqli_query($connect, "update users set password ='{$new}' where password='{$old}';");
        if (!$query) {
            die(json_encode(array("code" => "8")));
        }
        $_SESSION['user'] = '';
        die(json_encode(array("code" => "0")));
    }
}

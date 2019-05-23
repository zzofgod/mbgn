<?php
require('../public/common.php');
checkLogin();
//后端验证

if (empty($_POST['nick'])) {
    die(json_encode(array("code" => "1")));
    return;
} else if (strlen($_POST['username']) < 6 || strlen($_POST['username']) > 16) {
    die(json_encode(array("code" => "2")));
    return;
} else if (strlen($_POST['nick']) < 2 || strlen($_POST['nick']) > 10) {
    die(json_encode(array("code" => "3")));
    return;
} else if (empty($_POST['username'])) {
    die(json_encode(array("code" => "4")));
    return;
}

$session = $_SESSION['user'];
$username = trim($_POST['username']);
$nick = trim($_POST['nick']);
$birthday = $_POST['birthday'];
if (empty($birthday)) {
    $birthday = null;
}
$age = getAge($birthday);
$gender = (int)$_POST['gender'];
$id = $_POST['id'];

$query_avatar = mysqli_query($connect, "select avatar from users where id=" . $id . ";");
if (!$query_avatar) {
    die(json_encode(array("code" => "5")));
    exit("修改失败！");
}

$avatar = mysqli_fetch_assoc($query_avatar)['avatar'];

if (empty($avatar) || strlen($avatar) < 20) {
    if ($gender == 0) {
        $avatar = "../static/img/0.png";
    } else if ($gender == 1) {
        $avatar = "../static/img/1.png";
    } else {
        $avatar = "../static/img/2.png";
    }
    $query = mysqli_query($connect, "update users set avatar='{$avatar}' where id=" . $id . ";");
    if (!$query) {
        exit("数据库执行失败2");
        die(json_encode(array("code" => "5")));
    }
}

$query_username = mysqli_query($connect, "select count(id) as count from users where username='{$username}';");
if (!$query_username) {
    die(json_encode(array("code" => "5")));
    exit("服务器错误");
}
$result_username = (int)mysqli_fetch_assoc($query_username)['count'];

$query_nick = mysqli_query($connect, "select count(id) as count from users where nick='{$nick}';");
if (!$query_nick) {
    die(json_encode(array("code" => "5")));
    exit("服务器错误");
}
$result_nick = (int)mysqli_fetch_assoc($query_nick)['count'];

$query_name_nick = mysqli_query($connect, "select username,nick from users where id='{$id}';");
if (!$query_name_nick) {
    die(json_encode(array("code" => "5")));
    exit("服务器错误");
}
$result_name_nick = mysqli_fetch_assoc($query_name_nick);

// die(json_encode(array("code" => $result_name_nick['username'])));
if ($result_name_nick["username"] != $username && $result_username >= 1) {
    die(json_encode(array("code" => "6")));
    exit();
} elseif ($result_name_nick["nick"] != $nick && $result_nick >= 1) {
    die(json_encode(array("code" => "7")));
    exit();
} else {
    $age = getAge($birthday);
    $query = mysqli_query($connect, "update users set username='{$username}',nick='{$nick}',birthday='{$birthday}',gender={$gender},age={$age} where id=" . $id . ";");
    if (!$query) {
        die(json_encode(array("code" => "5")));
        exit("数据库执行失败2");
    }
    $query = mysqli_query($connect, "select username,nick from users where id=" . $id . ";");
    if (!$query) {
        die(json_encode(array("code" => "5")));
        exit("数据库执行失败3");
    }
    $nick = mysqli_fetch_assoc($query);
    $_SESSION['user'] = $nick["nick"];

    die(json_encode(array("code" => "8")));
    header('Location:index.php');
}

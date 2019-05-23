<?php 
session_start();
if (strtolower($_POST['authcode']) != $_SESSION['authcode']) {
    die(json_encode(array("code"=>"0")));
    return;
} 
if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['authcode'])) {
    require("common.php");
    $username = trim($_POST['username']); //mysql_real_escape_string()进行过滤
    $password = trim($_POST['password']);
    $query = mysqli_query($connect, "select count(id) as id from users where username='{$username}' and password='{$password}';");
    if (!$query) {
        die(json_encode(array("code"=>"4")));
        exit();
    }
    $result = mysqli_fetch_assoc($query);
    if ($result['id'] > 0 && strtolower($_POST['authcode']) == $_SESSION['authcode']) {
        $query_nick = mysqli_query($connect, "select nick from users where username='{$username}' and password='{$password}';");
        if (!$query_nick) {
            die(json_encode(array("code"=>"4")));
            exit();
        }
        $nick = mysqli_fetch_assoc($query_nick);
        $_SESSION['user'] = $nick["nick"];
        die(json_encode(array("code"=>"2")));
        exit();
    } else {
        die(json_encode(array("code"=>"1")));
        exit();
    }
} else {
    die(json_encode(array("code"=>"0")));
}

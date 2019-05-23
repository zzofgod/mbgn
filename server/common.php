<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'yx110120';
$dbName = 'user';

$connect = mysqli_connect($host, $user, $password, $dbName);
if (mysqli_connect_error($connect)) {
    echo "数据库连接失败:" . mysql_connect_error();
}

date_default_timezone_set("Asia/Shanghai");



//检查session
function checkLogin()
{
    //开启session
    session_start();
    //用户未登录
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header('Location: tip.php');
        return false;
    }
    return true;
}



function get_server_ip()
{
    if (isset($_SERVER['SERVER_NAME'])) {
        return gethostbyname($_SERVER['SERVER_NAME']);
    } else {
        if (isset($_SERVER)) {
            if (isset($_SERVER['SERVER_ADDR'])) {
                $server_ip = $_SERVER['SERVER_ADDR'];
            } elseif (isset($_SERVER['LOCAL_ADDR'])) {
                $server_ip = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip ? $server_ip : '获取不到服务器IP';
    }
}

<?php
$host = '127.0.0.1';
$user = 'root';
$password = 'yx110120';
$dbName = 'user';
date_default_timezone_set('PRC');
$connect = mysqli_connect($host, $user, $password, $dbName);
if (mysqli_connect_error($connect)) {
    echo "数据库连接失败:" . mysql_connect_error();
}


//检查session
function checkLogin()
{
    //开启session
    session_start();
    //用户未登录
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header('Location: ../tip.php');
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

function getAge($birthday)
{
    $age = strtotime($birthday);
    if ($age === false) {
        return false;
    }
    list($y1, $m1, $d1) = explode("-", date("Y-m-d", $age));
    $now = strtotime("now");
    list($y2, $m2, $d2) = explode("-", date("Y-m-d", $now));
    $age = $y2 - $y1;
    if ((int)($m2 . $d2) < (int)($m1 . $d1))
        $age -= 1;
    return $age;
}

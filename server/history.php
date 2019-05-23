<?php
require("./.public/common.php");
checkLogin();
$query = mysqli_query($connect, 'select * from history');
if (!$query) {
    exit("查询失败");
}
while ($item = mysqli_fetch_assoc($query)) {
    $data[] = $item;
}
foreach ($data as $history) {
    echo $history['time'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;ip为' .
        $history['ip'] . '和昵称是' . $history['nick'] . $history['crud'] . '名称：' . $history['msg'] .
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;域名：' . $history['www'] . '<br>';
}

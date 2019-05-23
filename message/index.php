<?php
$query = mysqli_query($connect, "select * from msg order by id desc");
if (!$query) {
    exit("服务器异常");
}
$data = array();
while ($item = mysqli_fetch_assoc($query)) {
    $data[] = $item;
}

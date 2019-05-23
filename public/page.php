<?php
$pagesize = 10;
$count = (int)mysqli_fetch_assoc($query_count)["count"];
$page = new Page($pagesize, $count);
$currentpage = $page->page;
//第一页
$fristUrl = $page->first();
//最后一页
$lastUrl = $page->end();
//下一页
$next = $page->next();
//上一页
$prev = $page->prev();
//limit m,n
$limit = $page->limit();

$sql = "select * from template order by id desc limit {$limit};";

$qeury_select = mysqli_query($connect, $sql);
if (!$qeury_select) {
    exit('数据库查询失败');
}
while ($item = mysqli_fetch_assoc($qeury_select)) {
    $data[] = $item;
}

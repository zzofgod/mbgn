<?php
$index_edit = 'active';
require("../public/common.php");
checkLogin();
$username = 1;
if (empty($_GET["id"])) {
    echo "<h1>你没有传参<a href='index.php'>返回首页</a><h1>";
    return;
}
$data = array();
$id = $_GET["id"];
$query = mysqli_query($connect, "select * from template where id=" . $id . ';');
if (!$query) exit("数据库查询失败！");

while ($item = mysqli_fetch_assoc($query)) {
    $data = $item;
}
?>
<!DOCTYPE html>

<html lang="zh-CN">

<head>
    <title>编辑</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">编辑信息</h2>
        <form action="../server/edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div class="form-group">
                <label for="name">姓名</label>
                <input type="text" class="form-control" id="name" name="name" required minlength="1" maxlength="10" value="<?php echo $data['name']; ?>">
            </div>
            <div class="form-group">
                <label for="msg">名称</label>
                <input type="text" class="form-control" id="msg" name="msg" required minlength="1" maxlength="100" value="<?php echo $data['msg']; ?>">
            </div>
            <div class="form-group">
                <label for="www">域名</label>
                <input class="form-control" type="text" id="www" maxlength="100" name="www" required value="<?php echo $data['www']; ?>">
            </div>
            <button type="submit" class="btn btn-success">修改</button>
            <a href="index.php" class="btn btn-danger">取消</a>
        </form>
    </div>
    </div>
    </div>
</body>

</html>
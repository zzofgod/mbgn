<?php
$index_add = 'active';
require("../public/common.php");
checkLogin();
$username = 1;
?>
<!DOCTYPE html>

<html lang="zh-CN">

<head>
    <title>添加</title>
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
        <h2 class="sub-header">添加学生</h2>
        <form action="../server/add.php" method="post">
            <div class="form-group">
                <label for="">姓名</label>
                <input type="text" class="form-control" id="" name="name" required minlength="2" maxlength="10" value="<?php echo $user; ?>">
            </div>
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" class="form-control" id="" name="msg" required minlength="2" maxlength="100">
            </div>
            <div class="form-group">
                <label for="">域名</label>
                <input class="form-control" type="text" id="" name="www" maxlength="100" required>
            </div>
            <button type="submit" class="btn btn-success">提交</button>
            <a href="index.php" class="btn btn-danger">取消</a>
        </form>
    </div>
    </div>
    </div>
</body>

</html>
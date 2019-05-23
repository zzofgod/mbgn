<?php
$user_edit_avatar = 'active';
require('../public/common.php');
checkLogin();
$data = array();
$name = $_SESSION['user'];
$query = mysqli_query($connect, "select * from users where nick='" . $name . "';");
if (!$query) exit("数据库查询失败！");

while ($item = mysqli_fetch_assoc($query)) {
    $data = $item;
}

if (empty($data['avatar'])) {
    if ($data['gender'] == '0') {
        $default_avatar = '../static/img/0.png';
    } else if ($data['gender'] == '1') {
        $default_avatar = '../static/img/1.png';
    } else {
        $default_avatar = '../static/img/2.png';
    }
} else {
    $default_avatar = $data['avatar'];
}

$gender0 = '';
$gender1 = '';
$gender2 = '';
if ($data['gender'] == 0) {
    $gender0 = 'checked';
} else if ($data['gender'] == 1) {
    $gender1 = 'checked';
} else {
    $gender2 = 'checked';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="../static/lib/layui/css/layui.css">
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">个人中心</h2>
        <form method="post" action="editavatar.php" id="formdata" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <h4>头像</h4>
                <img id="big" style="margin-bottom:20px" height="400" src="../<?php echo $default_avatar ?>" />
                <input type="file" style="display: none" class="form-control" accept="image/jpeg" id="avatar" name="avatar">
                <div class="input-append">
                    <!-- 用于展示上传文件名的表单 -->
                    <input id="showname" class="input-large" type="text" disabled style="height:30px;width:350px">
                    <!-- 点击触发按钮 -->
                    <a class="btn btn-primary btn-sm" onclick="makeThisfile()" id="browse">浏览</a>
                </div>
            </div>
            <button id="submit" type="submit" class="btn btn-success">上传</button>
            <a href="index.php" class="btn btn-danger">返回</a>
        </form>
    </div>

    </div>
    </div>
    <script src="../static/lib/layui/layui.all.js"></script>
    <script type="text/javascript">
        //触发隐藏的file表单
        function makeThisfile() {
            $('#avatar').click();
        }
        //file表单选中文件时,让file表单的val展示到showname这个展示框
        $('#avatar').change(function() {
            $('#showname').val($(this).val())
        })
    </script>
</body>

</html>
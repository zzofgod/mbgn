<?php
$user_list = 'active';
require('../public/common.php');
checkLogin();

$data = array();
$query = mysqli_query($connect, 'select * from users order by id desc;');
if (!$query) {
    exit('数据库查询失败');
}
while ($item = mysqli_fetch_assoc($query)) {
    $data[] = $item;
}

$query_count = mysqli_query($connect, 'select count(*) as count from users;');
if (!$query_count) {
    exit('数据库查询失败');
}
$count = (int)mysqli_fetch_assoc($query_count)["count"];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户列表</title>
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
    <style>
        table tr td {
            line-height: 100px !important;
        }
    </style>
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h2 class="sub-header">用户列表</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>头像</th>
                        <th>用户名(
                            <?php echo $count ?>)</th>
                        <th>昵称</th>
                        <th>性别</th>
                        <th>年龄</th>
                        <th>创建时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $student) : ?>
                        <tr>
                            <td style="width:20%">
                                <img src="<?php if (empty($student['avatar'])) {
                                                if ($student['gender'] == 0) {
                                                    echo '../static/img/0.png';
                                                } else if ($student['gender'] == 1) {
                                                    echo '../static/img/1.png';
                                                } else {
                                                    echo '../static/img/2.png';
                                                }
                                            } else {
                                                echo $student['avatar'];
                                            }
                                            ?>  
                                                                                                                                    " height="100" />
                            </td>
                            <td>
                                <?php echo $student['username'] ?>
                            </td>
                            <td>
                                <?php echo $student['nick'] ?>
                            </td>
                            <td>
                                <?php
                                if ($student['gender'] == 0) {
                                    echo "男";
                                } else if ($student['gender'] == 1) {
                                    echo "女";
                                } else {
                                    echo "保密";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if (empty($student['age'])) echo "未设置";
                                else echo $student['age']; ?>
                            </td>
                            <td>
                                <?php echo $student['time'] ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</body>

</html>
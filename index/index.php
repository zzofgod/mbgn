<?php
$index = 'active';
$search = 'search';
require("../public/common.php");
checkLogin();
$data = array();
require('../class/Page.php');
$query_count = mysqli_query($connect, 'select count(*) as count from template;');
if (!$query_count) {
    exit('数据库查询失败');
}

require('../public/page.php');

$sql = "select * from template order by id desc limit {$limit};";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $query = mysqli_query($connect, "select * from template where name='{$username}' or www like '%{$username}%';");
    if (!$query) {
        exit('数据库查询失败111');
    }
    $data = array();
    while ($item = mysqli_fetch_assoc($query)) {
        $data[] = $item;
    }
    $query_count = mysqli_query($connect, "select count(*) as count from template where name='{$username}' or www like '%{$username}%';");
    if (!$query_count) {
        exit('数据库查询失败222');
    }
    $count = (int)mysqli_fetch_assoc($query_count)["count"];
}
?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <title>首页</title>
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
        <h2 class="sub-header">信息列表</h2>
        <a class="btn btn-success" href="add.php">添加信息</a>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>姓名</th>
                        <th>名称</th>
                        <th>域名(<?php echo $count ?>)</th>
                        <th>时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($data as $student) : ?>
                        <tr>
                            <td>
                                <?php echo $student['id'] ?>
                            </td>
                            <td>
                                <?php echo $student['name'] ?>
                            </td>
                            <td>
                                <?php echo $student['msg'] ?>
                            </td>
                            <td>
                                <?php echo "<a target='_blank' href=http://" . str_replace('http://', '', $student['www']) . ">" . $student['www'] . "</a>" ?>
                            </td>
                            <td>
                                <?php echo $student['time'] ?>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?php echo $student['id'] ?>">编辑</a>
                                <?php $url = "delete.php?id=" . $student['id'] . '&name=' . $user ?>
                                <a class="btn btn-danger btn-sm" onclick="delcfm('<?php echo $url ?>')">删除</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    <?php if (count($data) == 0) {
                        echo "<tr><td style='text-align:center;color:#999' colspan='6'>什么都没有...<td><tr>";
                    } ?>
                </tbody>

            </table>
            <?php if ($_SERVER['REQUEST_METHOD'] != 'POST') : ?>
                <nav>

                    <ul class="pagination text-center">
                        <li><a href="<?php echo $prev ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                        <?php for ($i = 1; $i <= $page->totalPage; $i++)
                            if ($currentpage == $i) {
                                echo "<li class='active' href=''><a>" . $i . "</a></li>";
                            } else {
                                echo "<li><a href='http://www.zzofgod.xyz:80/mbgn/index/index.php?page={$i}'>" . $i . "</a></li>";
                            }
                        ?>

                        <li>
                            <a href="<?php echo $next ?>" aria-label="Next">
                                <span aria-hidden="true ">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif ?>
            <div class="modal fade" id="delcfmModel">
                <div class="modal-dialog">
                    <div class="modal-content message_align">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">提示信息</h4>
                        </div>
                        <div class="modal-body">
                            <p>您确认要删除吗？删除后将无法恢复！</p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="url" />
                            <a onclick="urlSubmit()" class="btn btn-danger" data-dismiss="modal">确定</a>
                            <button type="button" class="btn btn-success" data-dismiss="modal">取消</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
    </div>
    <script>
        function delcfm(url) {
            $('#url').val(url); //给会话中的隐藏属性URL赋值  
            $('#delcfmModel').modal();
        }

        function urlSubmit() {
            var url = $.trim($("#url").val()); //获取会话中的隐藏属性URL  
            window.location.href = url;
        }
    </script>
</body>

</html>
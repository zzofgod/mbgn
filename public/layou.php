        <?php
        $user = $_SESSION["user"];
        $query_avatar_gender = mysqli_query($connect, 'select avatar,gender from users where nick="' . $user . '";');
        if (!$query_avatar_gender) {
            exit;
            header('Location:../tip.php');
        }
        $avatar = mysqli_fetch_assoc($query_avatar_gender)['avatar'];
        $gender = mysqli_fetch_assoc($query_avatar_gender)['gender'];
        if (empty($avatar)) {
            if ($gender == '0') {
                $default_avatar = 'static/img/0.png';
            } else if ($gender == '1') {
                $default_avatar = 'static/img/1.png';
            } else {
                $default_avatar = 'static/img/2.png';
            }
        } else {
            $default_avatar = str_replace('../', '', $avatar);
        }
        ?>
        <script src="../static/lib/jquery/jquery.min.js"></script>
        <script src="../static/lib/bootstrap/js/bootstrap.min.js"></script>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">模板归纳</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li class="pull-left"><a href="user/index.php">设置</a></li> -->
                        <!-- Single button -->

                        <li class="pull-left">
                            <div class="btn-group">
                                <a id="menu" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    设置 <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="http://localhost/mbgn/user/index.php">个人中心</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/mbgn/user/password.php">修改密码</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/mbgn/user/avatar.php">修改头像</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/mbgn/message/msglist.php">留言中心</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/mbgn/login.php">切换账号</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/mbgn/server/logout.php">退出登录</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="pull-left"><a href="http://localhost/mbgn/user/index.php" style="padding:0;line-height:50px"><img height="40" src="../<?php echo $default_avatar ?>">&nbsp;&nbsp;<?php echo $user; ?></a></li>
                        <li class="pull-left"><a href="http://localhost/mbgn/index/index.php" title="刷新"><i class="glyphicon glyphicon-repeat" style="color:white;font-size:18px"></i></a></li>
                        <li><a href="http://localhost/mbgn/server/history.php" title="历史记录"><i class="glyphicon glyphicon-cloud" style="color:white;font-size:18px"></i></a></li>
                        <li><a href="http://localhost/mbgn/server/logout.php" title="退出登录"><i class="glyphicon glyphicon-off" style="color:white;font-size:18px"></i></a></li>
                    </ul>
                    <?php if (isset($search)) : ?>
                        <form class="navbar-form navbar-right" action="index.php" method="post">
                            <input type="text" name="username" class="form-control" placeholder="搜索...">
                            <input type="submit" value="搜索" class="btn btn-default">
                        </form>
                    <?php endif ?>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
                        <li class="<?php if ($index) echo 'active' ?>"><a href="http://localhost/mbgn/index/index.php">信息管理</a></li>
                        <li class="<?php if ($index_add) echo 'active' ?>"><a href="http://localhost/mbgn/index/add.php">添加信息</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li class="<?php if ($user_index) echo 'active' ?>"><a href="http://localhost/mbgn/user/index.php">个人中心</a></li>
                        <li class="<?php if ($user_list) echo 'active' ?>"><a href="http://localhost/mbgn/user/userlist.php">用户列表</a></li>
                    </ul>
                    <ul class="nav nav-sidebar">
                        <li class="<?php if ($msg_list) echo 'active' ?>"><a href="http://localhost/mbgn/message/msglist.php">留言中心</a></li>
                    </ul>
                </div>
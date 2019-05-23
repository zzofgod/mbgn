<?php
$msg_list = 'active';
require("../public/common.php");
checkLogin();
require('index.php');

?>
<!DOCTYPE html>

<html lang="zh-CN">

<head>
    <title>留言中心</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../static/css/main.css" rel="stylesheet">
    <style>
        #txt {
            display: block;
            padding: 5px;
            resize: none;
            border: 1px solid #61b3e6;
            border-radius: 5px;
            outline: none;
        }

        .list {
            width: 100%;
            overflow: hidden;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 30px 0;
        }

        .list .nick {
            font-size: 14px;
            padding: 5px 0;
            text-align: left;
        }

        .list .msg {
            font-size: 16px;
            height: 60px;
            line-height: 20px;
        }

        .list .time {
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php require('../public/layou.php'); ?>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <form>
            <h2 class="sub-header">给我留言</h2>
            <textarea name="msg" id="txt" class="form-control" cols="30" rows="8"></textarea>
            <input type="hidden" name="nick" id="nick" value="<?php echo $user; ?>" />
            <button style="margin-top:10px" type="button" id="submit" class="btn btn-primary pull-right">发布</button>
        </form>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <?php foreach ($data as $msg) : ?>
            <div class="list">
                <div class="col-sm-12 col-md-3"><img src="<?php echo $msg['avatar'];?>" height="60" />
                    <p class="nick">昵称：<?php echo $msg['nick']; ?></p>
                </div>
                <div class="col-sm-12 col-md-9">
                    <p class="msg"><?php echo $msg['msg']; ?><p>
                            <p class="time"><?php echo $msg['time']; ?><p>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    </div>
    </div>
    <script src="../static/lib/layui/layui.all.js"></script>
    <script>
        $(function() {
            $("#submit").click(function() {
                if ($("#txt").val() == '' || $('#txt').val().length <= 0) {
                    layer.tips('内容不能为空！', '#txt', {
                        time: 2000,
                        tips: 2
                    });
                } else if ($("#txt").val().length > 100 || $('#txt').val().length < 5) {
                    layer.tips('内容长度必须是5-100个字符！', '#txt', {
                        time: 2000,
                        tips: 2
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: 'addmsg.php',
                        data: {
                            nick: $("#nick").val(),
                            msg: $("#txt").val()
                        },
                        success: function(res) {
                            var data = JSON.parse(res);
                            if (data.code == 0) {

                                layer.confirm('发布成功！', {
                                    btn: ['刷新'] //按钮，
                                }, function() {
                                    window.location = "msglist.php"
                                }, function() {});
                            } else if (data.code == 1) {
                                layer.tips('昵称不能为空!', '#txt', {
                                    time: 2000,
                                    tips: 2
                                });
                            } else if (data.code == 2) {
                                layer.tips('内容不能为空!', '#txt', {
                                    time: 2000,
                                    tips: 2
                                });
                            } else if (data.code == 3) {
                                layer.tips('昵称必须是2-10个字符串', '#txt', {
                                    time: 2000,
                                    tips: 2
                                });
                            } else if (data.code == 4) {
                                layer.tips('内容长度必须是5-100个字符', '#txt', {
                                    time: 2000,
                                    tips: 2
                                });
                            } else if (data.code == 5) {
                                layer.alert('服务器异常', {
                                    icon: 6
                                });
                            }
                        }
                    })
                }
            })
        })
    </script>
</body>

</html>
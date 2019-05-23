<?php
        require("common.php");
        checkLogin();
        if(empty($_POST['id'])){
            echo "<h1>你没有传参<a href='../index.php'>返回首页</a><h1>";
            return;
        }
        //update c set age=66 where id=2;
        $id=$_POST['id'];
        $name = $_POST['name'];
        $msg = $_POST['msg'];
        $www= $_POST['www'];
        $time = date('Y-m-d H:i:s');
        $query = mysqli_query($connect,"update template set name='{$name}',msg='{$msg}',www='{$www}' where id=".$id.";");
        if(!$query){
            exit("添加失败");
        }
        $ip = get_server_ip();
        $user = $_SESSION["user"];
        $query_history = mysqli_query($connect, "insert into history values(null,'{$ip}','{$user}','{$time}','{$msg}','{$www}','编辑');");
        if (!$query_history) {
            exit("添加失败");
        }
        header('Location:../index/index.php');

?>

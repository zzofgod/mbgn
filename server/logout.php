<?php
session_start();
//释放user
unset($_SESSION['user']);
header('Location:../tip.php');
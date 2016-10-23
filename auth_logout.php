<?php

session_start();
session_destroy();
setcookie('servicejfauth', "", -1);
header('location:index.php');
?>
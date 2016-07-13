<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connSQL = "localhost";
$database_connSQL = "taiwan";
$username_connSQL = "homestead";
$password_connSQL = "secret";
$connSQL = mysqli_connect($hostname_connSQL, $username_connSQL, $password_connSQL,$database_connSQL) or trigger_error(mysqli_connect_error(),E_USER_ERROR);
mysqli_query($connSQL,"SET NAMES 'utf8'"); 
ini_set("display_errors", "On"); // 顯示錯誤是否打開( On=開, Off=關 )
error_reporting(E_ALL & ~E_NOTICE);
?>
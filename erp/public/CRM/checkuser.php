<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']==""){
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
    header("Location:index.php");
    exit;
}
?>
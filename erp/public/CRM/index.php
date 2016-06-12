<?php
if(isset($_POST['ad_account'])) { //判斷是否有送出使用者名稱的值
	if(isset($_POST['rememberMe'])) { //判斷是否要記錄
		setcookie("remuser", $_POST['ad_account'], time()+86400*30); //設定使用者名稱的 Cookie 值
		setcookie("rempass", $_POST['ad_pw'], time()+86400*30); //設定密碼的 Cookie 值
		setcookie("rememberMe", $_POST['rememberMe'], time()+86400*30); //設定是否要記錄的 Cookie 值
	}else{
		setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
		setcookie("rempass", '', time()); //去除密碼的 Cookie 值
		setcookie("rememberMe", '', time()); //去除密碼的 Cookie 值
	}
}
?>
<?php require_once('Connections/connSQL.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

if($_SESSION['MM_Username']!=""){
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
	setcookie("rempass", '', time()); //去除使用者密碼的 Cookie 值
	//echo "<div class=\"alert alert-danger\"><strong>您的帳號密碼有誤，請重新輸入！</strong></div>";
	//echo "<script>location.href=\"company_system.php\";</script>";
    header("Location:company_system.php");
    exit;
}

// ** Logout the current user. **
/*
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
  setcookie("rempass", '', time()); //去除密碼的 Cookie 值
	
  $path=$_SERVER["PHP_SELF"];//抓網頁名稱,給<h3>用
  $file = basename($path);
	
  $logoutGoTo = $file;
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
*/
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connSQL,$theValue) : mysqli_escape_string($connSQL,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
//mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT * FROM admin_tb WHERE ad_account = %s", GetSQLValueString($colname_RecUser, "text"));
//echo $query_RecUser;
$RecUser = mysqli_query($connSQL,$query_RecUser) or die(mysqli_error());
$row_RecUser = mysqli_fetch_assoc($RecUser);
$totalRows_RecUser = mysqli_num_rows($RecUser);
  $_SESSION['LoginName'] = $row_RecUser['ad_name'];
?>
<script>
function show(id){
  var o=document.getElementById(id);
  if( o.style.display == 'none' )  {
    o.style.display='';	
  }
}
</script>
<?php
// *** Validate request to login to this site.


$loginFormAction = $_SERVER['PHP_SELF'];


//echo $_POST['ad_account'];
if (isset($_POST['ad_account'])) {
  $loginUsername=$_POST['ad_account'];
  //$password=md5($_POST['ad_pw']);
  $password=password_hash($_POST['ad_pw'], PASSWORD_DEFAULT);
  //$MM_fldUserAuthorization = "m_level";
  $MM_redirectLoginSuccess = "company_system.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  //mysql_select_db($database_connSQL, $connSQL);
  $_SESSION['MM_Username'] = $loginUsername;
  
  $sql_pw=sprintf("select ad_pw,ad_name from admin_tb where ad_account=%s",GetSQLValueString($_SESSION['MM_Username'], "text"));
  $rs_pw=mysqli_query($connSQL,$sql_pw) or die(mysqli_error());
  $row_pw=mysqli_fetch_array($rs_pw);
  $pw=$row_pw["ad_pw"];
 
/*  $LoginRS__query=sprintf("SELECT * FROM admin_tb WHERE ad_account=%s AND ad_pw=%s",
  GetSQLValueString($_SESSION['MM_Username'], "text"), GetSQLValueString($password, "text")); 
//echo $LoginRS__query."<BR>";
  $LoginRS = mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $loginFoundUser = mysqli_num_rows($LoginRS);
  $row_LoginRS = mysqli_fetch_assoc($LoginRS);
  $_SESSION['LoginName'] = $row_LoginRS['ad_name'];
//echo $MM_redirectLoginSuccess;exit;
	*/
  if (password_verify($_POST['ad_pw'], $pw)) {
	$_SESSION['LoginName'] = $row_pw['ad_name'];
    header("Location: " . $MM_redirectLoginSuccess );
	exit;
  }
  else {
	 //echo "<script>show('hiddenbox')</script>";
	//echo "<script>show(\"hiddenbox\");location.href=(\"$MM_redirectLoginFailed\");</script>";
    header("Location: ". $MM_redirectLoginFailed );
	exit;
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php
		$sql_adm="select * from admsetup";
		$rs_adm=mysqli_query($connSQL,$sql_adm);
		$row_adm=mysqli_fetch_array($rs_adm);
		$sys_name=$row_adm["system_name"];
	?>
    <title><?php echo $sys_name;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                
                <a class="navbar-brand" href="index.php"><?php echo $sys_name;?></a>
            </div>
         </nav>
  <div class="container">
               <div class="row">
                     <div class="col-md-6 col-lg-6 col-sm-6 col-xs-10 col-md-offset-3 col-lg-offset-3 col-sm-offset-3 col-xs-offset-1">
                            
                         <div class="panel panel-default">
                                <div class="panel-heading">
           
<?php if ($totalRows_RecUser == 0) { // Show if recordset empty ?>
   <h3 class="panel-title">會員登入</h3>
   </div>
     <div class="panel-body">
                                   <form class="form-horizontal" role="form" ACTION="<?php echo $loginFormAction; ?>" name="form1" method="POST">
										<div class="form-group">
                                         <label for="account" class="col-sm-2 control-label">帳號</label>
                                          <div class="col-sm-10">
                                             <input type="text" class="form-control" name="ad_account" id="ad_account" placeholder="請輸入帳號" value="<?php if(isset($_COOKIE['remuser'])) echo $_COOKIE['remuser']; //帳號 ?>">
                                          </div>
                                     </div>
									<div class="form-group">
                                         <label for="password" class="col-sm-2 control-label">密碼</label>
                                         <div class="col-sm-10">
                                             <input type="password" name="ad_pw" class="form-control" id="ad_pw" placeholder="請輸入密碼" value="<?php if(isset($_COOKIE['rempass'])) echo $_COOKIE['rempass']; //密碼 ?>">
                                         </div>
                                    </div>
									<div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <div class="checkbox">
            <label>
               <input name="rememberMe" type="checkbox" id="rememberMe" value="1" checked> 請記住我
            </label>
         </div>
		 <!--<div class="alert alert-danger" style="display:none;" id="hiddenbox"><strong>帳號密碼有誤</strong></div>-->
      </div>
   </div>
       <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" class="btn btn-default" name="submit" >登入</button> <!--a href="membersendpass.php">忘記密碼</a>  <a href="memberadd.php">申請會員</a>  <a href="index.html">回主頁</a-->
		<!--<button type ="button" onclick="javascript:location.href='memberadd.php'" class="btn btn-default" >申請會員</button>
		<button type ="button" onclick="javascript:location.href='index.html'" class="btn btn-default" >回主頁</button>-->
	  </div>
   </div>
</form>

                               </div>
                         </div>
                     
                     
                     </div>
               </div>
         </div>
     
     
 
  <?php } // Show if recordset empty ?></td>
<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>
</html>
<?php
mysqli_free_result($RecUser);
?>

<?php require_once('Connections/connSQL.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']!=""){

	if(isset($_GET["deliid"]))
	{
		$sql_de = "delete from company_system where auto_id = '".$_GET["deliid"]."'";
		mysqli_query($connSQL,$sql_de)or die(mysqli_error());
		$sql_de2 = "delete from cust_purchase where c_id = '".$_GET["deliid"]."'";//echo $sql_de2;
		mysqli_query($connSQL,$sql_de2)or die(mysqli_error());
	}

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
  //setcookie("rempass", '', time()); //去除密碼的 Cookie 值
	
  $path=$_SERVER["PHP_SELF"];
  $file = basename($path);
	
  $logoutGoTo = $file;
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}


$MM_authorizedUsers = "admin,member";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
/*
$MM_restrictGoTo = "indexerror.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}*/
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysql_real_escape_string") ? mysqli_real_escape_string($connSQL,$theValue) : mysqli_escape_string($connSQL,$theValue);
  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecMember = 10;
$pageNum_RecMember = 0;
if (isset($_GET['pageNum_RecMember'])) {
  $pageNum_RecMember = $_GET['pageNum_RecMember'];
}
$startRow_RecMember = $pageNum_RecMember * $maxRows_RecMember;

$colname_RecMember = "company_name";
if (isset($_GET['colname'])) {
  $colname_RecMember = $_GET['colname'];
}
$keyword_RecMember = "%";
if (isset($_GET['keyword'])) {
  $keyword_RecMember = "%".$_GET['keyword']."%";
}
if (empty($_GET['keyword'])) {
  $keyword_RecMember = "%";
}
//mysql_select_db($database_connSQL, $connSQL);
$query_RecMember = sprintf("SELECT * FROM company_system WHERE  %s LIKE %s ORDER BY auto_id", $colname_RecMember,GetSQLValueString($keyword_RecMember, "text"));
$query_limit_RecMember = sprintf("%s LIMIT %d, %d", $query_RecMember, $startRow_RecMember, $maxRows_RecMember);
$RecMember = mysqli_query($connSQL,$query_limit_RecMember);
$row_RecMember = mysqli_fetch_assoc($RecMember);

if (isset($_GET['totalRows_RecMember'])) {
  $totalRows_RecMember = $_GET['totalRows_RecMember'];
} else {
  $all_RecMember = mysqli_query($connSQL,$query_RecMember);
  $totalRows_RecMember = mysqli_num_rows($all_RecMember);
}
$totalPages_RecMember = ceil($totalRows_RecMember/$maxRows_RecMember)-1;

$queryString_RecMember = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecMember") == false && 
        stristr($param, "totalRows_RecMember") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecMember = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecMember = sprintf("&totalRows_RecMember=%d%s", $totalRows_RecMember, $queryString_RecMember);
?>
<!DOCTYPE html>

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
<script type="text/javascript">
<!--
function tfm_confirmLink(message) { //v1.0
	if(message == "") message = "Ok to continue?";	
	document.MM_returnValue = confirm(message);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="company_system.php"><?php echo $sys_name; ?></a>
            </div>
            <!-- Top Menu Items -->
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
          
					
					<?php 
						$sql_menu="select * from menu order by mid";
						$rs=mysqli_query($connSQL,$sql_menu);
						while($row=mysqli_fetch_array($rs)){
							$path=$_SERVER["PHP_SELF"];//抓網頁名稱,給<h3>用
							$file = basename($path);
							if($file==$row["menu_url"]) $file_name=$row["menu_name"];
							echo "<li><a href=\"".$row["menu_url"]."\"><i class=\"".$row["menu_class"]."\"></i> ".$row["menu_name"]."</a></li>";	
						}
					?>				
					<li id="lo"><a ><i class="fa fa-sign-out"></i>登出</a></li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                   
                 <div class="row">
                    <div class="col-md-12">
                          
                          <h3><?php echo $file_name; ?></h3>
         <div class="search">
           <form name="form1" method="get" action="company_system.php"  class="form-inline" >
<strong>
               <select name="colname" id="colname" class="btn btn-primary dropdown-toggle">
			    <!--<select name="search" id="search" class="btn btn-primary dropdown-toggle">-->
					<option value="company_name" selected>查詢公司名稱</option>
					<option value="company_add">查詢公司住址</option>	
					<option value="VTA_NO">查詢統一編號</option>
					<option value="company_contact">查詢聯絡人</option>
					<option value="company_con_tel">查詢聯絡人電話</option>
               </select>
               </strong>
               <input type="text" class="form-control" name="keyword" id="keyword">
			   <!--<input type="text" class="form-control" name="p_keyword" id="p_keyword">-->
             
             <input type="submit" name="button" id="button" class="btn btn-default" value="查詢">
             <input name="button2" type="button" id="button2" class="btn btn-default" onClick="MM_goToURL('parent','company_system.php');return document.MM_returnValue" value="顯示所有資料">
			 <button type="button" class="btn btn-link" onclick="window.open('company_add.php', 'newwindow', 'height=700, width=800');">新增廠商資料</button>
          
		   </form>
        </div><BR>
	    <div class="btn-group">
		<div class="container-fluid">
            <button type="button" class="btn btn-info" onclick="location.href='school_system.php';">學校資料管理</button>
			<button type="button" class="btn btn-info" onclick="location.href='addressbook_system.php';">通訊錄</button>
       </div><BR>
	   <div class="container-fluid">
            <ul class="nav nav-tabs">
			  <li  class="active"><a href="company_system.php">客戶資料管理</a></li>
			  <li><a href="customers_buy_system.php">已購客戶資料管理</a></li>
			  <li><a href="customers_rent_system.php">租用客戶資料管理</a></li>
			  <li><a href="customers_nobuy_system.php">未購客戶資料管理</a></li>
			  <li><a href="customers_maintain_system.php">客戶維護資料管理</a></li>
			  <li><a href="approval_code_system.php">授權碼</a></li>
			</ul>
       </div><BR>
     </div>	 
     
   
   </div>
            
            
            <div class="container-fluid">
           
  <table class="table table-striped table_01" style="table-layout: fixed;word-break: break-all;">
<?php $i=1; do {  $auto_id=$row_RecMember['auto_id'];?>
      <tr class="th_row" style="background-color:#5599FF;">
        <th>公司名稱</th>
		<th>郵箱NO</th>
		<th>公司簡稱</th>
        <th>聯絡人</th>
		<th>聯絡人電話</th>
		<th>聯絡人信箱</th>
		<th>聯絡人傳真</th>
		<th>統一編號</th>
	  </tr>
	  <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="公司名稱"><?php echo $row_RecMember['company_name'];?></td>
			<td data-th="郵箱NO"><?php echo $row_RecMember['mailbox'];?></td>
			<td data-th="公司簡稱"><?php echo $row_RecMember['company_abb'];?></td>
			<td data-th="聯絡人"><?php echo $row_RecMember['company_contact'];?></td>
			<td data-th="聯絡人電話"><?php echo $row_RecMember['company_con_tel'];?></td>
			<td data-th="聯絡人信箱"><?php echo $row_RecMember['company_con_email'];?></td>
			<td data-th="聯絡人傳真"><?php echo $row_RecMember['company_con_fax'];?></td>
			<td data-th="統一編號"><?php echo $row_RecMember['VTA_NO'];?></td>
	  </tr>
	 <tr class="th_row"  style="background-color:#5599FF;">
		<th>公司電話</th>
		<th>公司傳真</th>
		<th>網路電話號碼</th>
		<th>公司地址</th>
		<th>使用狀態</th>
		<th>備註</th>
		<th colspan="2">功能</th>
      </tr>
      <tr class="td_row" style="background-color:#CCEEFF">
			
			<td data-th="公司電話"><?php echo $row_RecMember['company_tel'];?></td>
			<td data-th="公司傳真"><?php echo $row_RecMember['company_fax'];?></td>
			<td data-th="公司傳真"><?php echo $row_RecMember['internet_phone'];?></td>
			<td data-th="公司地址"><?php echo $row_RecMember['company_add'];?></td>
			<td data-th="使用狀態"><?php 
			switch($row_RecMember['company_status']){
				case 1:
					echo"購買";
					break;
				case 2:
					echo "租用";
					break;
				case 3:
					echo "不使用";
					break;
			}	?></td>
			<td data-th="備註"><?php echo $row_RecMember['company_remark'];?></td>
			<td data-th="功能" colspan="2">
				<input type="button" value="修改" class="btn btn-default" onclick="window.open('company_system_edit.php?nid=<?PHP echo $auto_id;?>', 'newwindow', 'height=450, width=550, top=50, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no');">
				<!--<input type="button" id="del" value="刪除" class="btn btn-default" onclick="if(confirm('確定要刪除這一筆資料?'))location.href='company_system.php?deliid=<?php echo $auto_id;?>';">-->
				<input type="button" id="del<?php echo $i;?>" name="del<?php echo $i;?>" value="刪除" class="btn btn-default">
			</td>
        </tr>
		<tr><td colspan="7" style="border: 0px;background-color:#FFF;">&nbsp;</td></tr>
	   <?php $i++;} while ($row_RecMember = mysqli_fetch_assoc($RecMember)); ?>
  </table>

  <ul class="pager">
  <?php if ($pageNum_RecMember > 0) { // Show if not first page ?>
  <li><a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, 0, $queryString_RecMember); ?>">第一頁</a></li>
  <?php } // Show if not first page ?>
  
  <?php if ($pageNum_RecMember > 0) { // Show if not first page ?>
  <li><a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, max(0, $pageNum_RecMember - 1), $queryString_RecMember); ?>">上一頁</a></li>
  <?php } // Show if not first page ?></td>
  
  <?php if ($pageNum_RecMember < $totalPages_RecMember) { // Show if not last page ?>
  <li><a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, min($totalPages_RecMember, $pageNum_RecMember + 1), $queryString_RecMember); ?>">下一頁</a></li>
  <?php } // Show if not first page ?></td>
  
  <?php if ($pageNum_RecMember < $totalPages_RecMember) { // Show if not last page ?>
  <li><a href="<?php printf("%s?pageNum_RecMember=%d%s", $currentPage, $totalPages_RecMember, $queryString_RecMember); ?>">最後一頁</a></li>
  <?php } // Show if not first page ?></td>
  
	</ul>
</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?php
include("inc_js.php");
?>
<script>

</script>
</body>

</html>
<?php
}
else{
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
    header("Location:index.php");
    exit;
}
mysqli_free_result($RecMember);
?>

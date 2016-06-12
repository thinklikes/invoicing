<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
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
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$search = "donation_name";
if (isset($_GET['search'])) {
  $search = $_GET['search'];
}
$keyword = "%";
if (isset($_GET['p_keyword'])) {
  $keyword = "%".$_GET['p_keyword']."%";
}
if (empty($_GET['p_keyword'])) {
  $keyword = "%";
}
//mysql_select_db($database_connSQL, $connSQL);
/*
$query_RecMember = sprintf("SELECT * FROM pray WHERE  %s LIKE %s ORDER BY auto_id", $colname_RecMember,GetSQLValueString($keyword_RecMember, "text"));
$query_limit_RecMember = sprintf("%s LIMIT %d, %d", $query_RecMember, $startRow_RecMember, $maxRows_RecMember);
$RecMember = mysqli_query($connSQL,$query_limit_RecMember);
*/
//==============計算總數
/*	$rs2 =  mysqli_query($connSQL,"select * from donation_db WHERE $search like '$keyword%'");	
	$donation = mysqli_fetch_row($rs2);
	$donation_money=$donation["donation_money"];
	*/
//==============計算總數END
$query_RecMember= "select * from account_db3 WHERE $search like '$keyword' ORDER BY account_id desc ";
//echo $query_RecMember."<BR>";
$RecMember = mysqli_query($connSQL,$query_RecMember);
//$row_RecMember = mysqli_fetch_assoc($RecMember);
/*
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

mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT * FROM  pray WHERE pray_name = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);
$totalRows_RecUser = mysql_num_rows($RecUser);*/
?>
<script type="text/javascript">
function printout() {
if (!window.print){alert("列印功能暫時停用，請按 Ctrl-P 來列印"); return;}
window.print();}

</script>
	
<!DOCTYPE html>

<html lang="zh">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>廟宇管理系統</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<link href="./css/components/css/default.css" rel="stylesheet" type="text/css" />
  
</head>
<body>


			<!-- ▼LOGO圖片 -->
			<div id="wrap">
			  <!-- InstanceBeginEditable name="IN" -->
			  <div id="contents">
 <center>
<h4>朝天五穀宮帳冊</h4>

<table class="table01">
<?php 
	while($row_RecMember = mysqli_fetch_assoc($RecMember)){
?>
	<tr  align="center"  style="background-color: #159;color: #fff;" >
			<th>年份</th>
			<th>科目</th>
			<th>摘要</th>
			<th>地址</th>
			<th>收入金額</th>
			<th>支出金額</th>
			<th>餘額</th>
			<th>備註</th>
	</tr>
	<tr>
			<td data-th="年份" class="a_01"><?php echo $row_RecMember["account_year"];?></td>
			<td data-th="科目" class="a_01"><?php echo $row_RecMember["account_subject"];?></td>
			<td data-th="摘要" class="a_01"><?php echo $row_RecMember["account_abstract"];?></td>
			<td data-th="地址" class="a_01"><?php echo $row_RecMember["account_address"];?></td>
			<td data-th="收入金額" class="a_01"><?php echo $row_RecMember["account_income"];?></td>
			<td data-th="支出金額" class="a_01" ><?php echo $row_RecMember["account_expenses"];?></td>	
			<td data-th="餘額" class="a_01"><?php echo $row_RecMember["account_surplus"];?></td>
			<td data-th="備註" class="a_01"><?php echo $row_RecMember["account_remark"];?></td>			
	</tr>
	<!--<tr align="center"  style="background-color: #159;color: #fff;" >
			
	</tr>-->
	<tr>
			
	</tr>
	<tr><td colspan="11" style="border: 0px;">&nbsp;</td></tr>
<?php
	}

//餘額--計算總數
	$rs2 =  mysqli_query($connSQL,"SELECT SUM(account_surplus) as account_surplus,SUM(account_expenses) as account_expenses,SUM(account_income) as account_income  FROM account_db3 WHERE $search like '$keyword' ");	
	//echo "SELECT SUM(account_surplus) as account_surplus,SUM(account_expenses) as account_expenses,SUM(account_income) as account_income  FROM account_db2 WHERE $search like '$keyword' ";
	$row2 = mysqli_fetch_array($rs2);
	$account_surplus=$row2["account_surplus"];
	$account_expenses=$row2["account_expenses"];
	$account_income=$row2["account_income"];
?>
	<tr  align="center"  style="background-color: #159;color: #fff;" >
			<th>合計</th>
			<th></th>
			<th></th>
			<th></th>
			<th>收入金額</th>
			<th>支出金額</th>
			<th>餘額</th>
			<th></th>
	</tr>
	<tr>
			<td data-th="合計" class="a_01"></td>
			<td data-th="" class="a_01"></td>
			<td data-th="" class="a_01"></td>
			<td data-th="" class="a_01"></td>
			<td data-th="收入金額" class="a_01"><?php echo $account_income;?></td>
			<td data-th="支出金額" class="a_01" ><?php echo $account_expenses;?></td>	
			<td data-th="餘額" class="a_01"><?php echo $account_income-$account_expenses;?></td>
			<td data-th="" class="a_01"></td>			
	</tr>
<?php
	mysqli_free_result($RecMember);
?>
</table>
	</center>

			  </div>
			  <!-- InstanceEndEditable -->

			  </div>
	
	<!-- ▼版權聲明 -->
<table width="100%" border="0px">
<tr align="center"><td>
<a href="javascript:printout()" >【列印本頁】</a>
</td><tr>
</table>

</body>
<!-- InstanceEnd --></html>
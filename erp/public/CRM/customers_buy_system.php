<?php require_once('Connections/connSQL.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']!=""){

	if(isset($_GET["deliid"]))
	{
		$sql_de = "delete from cust_purchase where no = '".$_GET["deliid"]."'";
		mysqli_query($connSQL,$sql_de)or die(mysqli_error());
	}
	if(isset($_GET["upid"]))
	{
		$sql_up = "update  cust_purchase  set company_status='2' where no = '".$_GET["upid"]."'";
		mysqli_query($connSQL,$sql_up)or die(mysqli_error());
		$sql_up2="update company_system set company_status='2' where auto_id='".$_GET["c_id"]."'";
		mysqli_query($connSQL,$sql_up2)or die(mysqli_error());
	}
	if(isset($_GET["upid2"]))
	{
		$sql_up = "update  cust_purchase  set company_status='3' ,soft_contract='',soft_end_date='',hardware_contract='',hardware_end_date='' where no = '".$_GET["upid2"]."'";
		mysqli_query($connSQL,$sql_up)or die(mysqli_error());
		$sql_up2="update company_system set company_status='3' where auto_id='".$_GET["c_id"]."'";
		mysqli_query($connSQL,$sql_up2)or die(mysqli_error());
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

$colname_RecMember = "c_id";
if (isset($_GET['colname'])) {
  $colname_RecMember = $_GET['colname'];
  if($colname_RecMember=="company_name"){
	  $sql_com="select auto_id from company_system where company_abb like '%".$_GET['keyword']."%'";
	  $rs_com=mysqli_query($connSQL,$sql_com);
	  $rows_com=mysqli_fetch_array($rs_com);
	  $c_id=$rows_com["auto_id"];
	  $colname_RecMember="c_id";
  }
}
$keyword_RecMember = "%";
if (isset($_GET['keyword'])) {
	if($c_id!="")$keyword_RecMember=$c_id;
	else  $keyword_RecMember = "%".$_GET['keyword']."%";
}
if (empty($_GET['keyword'])) {
  $keyword_RecMember = "%";
}
//mysql_select_db($database_connSQL, $connSQL);
$query_RecMember = sprintf("SELECT * FROM cust_purchase WHERE  company_status='1' and %s LIKE %s ORDER BY no", $colname_RecMember,GetSQLValueString($keyword_RecMember, "text"));
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
q1=document.form1.start_date.value;
document.form1.start_date.value=q1;
return true;
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
                <a class="navbar-brand" href="customers_buy_system.php"><?php echo $sys_name; ?></a>
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
					<li><a href="<?php echo $file."?doLogout=true";?>" onclick="return  confirm('是否要登出');"><i class="fa fa-sign-out"></i>登出</a></li>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">
                   
                 <div class="row">
                    <div class="col-md-12">
                          
                          <h3>已購客戶資料管理</h3>
         <div class="search">
           <form name="form1" method="get" action="customers_buy_system.php"  class="form-inline" >
<strong>
               <select name="colname" id="colname" class="btn btn-primary dropdown-toggle">
			    <!--<select name="search" id="search" class="btn btn-primary dropdown-toggle">-->
					<option value="company_name" selected>查詢公司簡稱</option>
					<option value="soft_end_date">軟約到期日</option>	
					<option value="hardware_end_date">硬約到期日</option>
               </select>
               </strong>
               <input type="text" class="form-control" name="keyword" id="keyword">
			   <!--<input type="text" class="form-control" name="p_keyword" id="p_keyword">-->
             
             <input type="submit" name="button" id="button" class="btn btn-default" value="查詢">
             <input name="button2" type="button" id="button2" class="btn btn-default" onClick="MM_goToURL('parent','customers_buy_system.php');return document.MM_returnValue" value="顯示所有資料">
          
		   </form>
        </div><BR>
	    <div class="btn-group">
		<div class="container-fluid">
            <!--<button type="button" class="btn btn-info" onclick="window.open('customers_buy_add.php', 'newwindow', 'height=700, width=800');">新增購買廠商資料</button>-->
       </div><br>
	   <div class="container-fluid">
            <ul class="nav nav-tabs">
			  <li><a href="company_system.php">客戶資料管理</a></li>
			  <li class="active"><a href="customers_buy_system.php">已購客戶資料管理</a></li>
			  <li><a href="customers_rent_system.php">租用客戶資料管理</a></li>
			  <li><a href="customers_nobuy_system.php">未購客戶資料管理</a></li>
			  <li><a href="customers_maintain_system.php">客戶維護資料管理</a></li>
			  <li><a href="approval_code_system.php">授權碼</a></li>
			</ul>
       </div>
     </div>	 
     
   
   </div>
            
            
            <div class="container-fluid">
           
  <table class="table table-striped table_01" style="white-space: nowrap">
  <?php $i=1; do {  $auto_id=$row_RecMember['no'];?>
      <tr class="th_row" style="background-color:#5599FF;">
        <th >公司名稱</th>
		<th>郵箱NO</th>
		<th>公司簡稱</th>
        <th>聯絡人</th>
		<th>聯絡人電話</th>
		<th>聯絡人傳真</th>
		<th>網路電話號碼</th>
		<th>統一編號</th>
		<th colspan="3">地址</th>
      </tr>
      <tr class="td_row" style="background-color:#CCEEFF">
			<?php
				$sql_com="select * from company_system where auto_id='".$row_RecMember['c_id']."'";
				//echo $sql_com;
				$rs_com=mysqli_query($connSQL,$sql_com)or die(mysqli_error());
				$rows_com=mysqli_fetch_array($rs_com);
			?>
			<td data-th="公司名稱" ><?php echo $rows_com['company_name'];?></td>
			<td data-th="郵箱NO"><?php echo $rows_com['mailbox'];?></td>
			<td data-th="公司簡稱"><?php echo $rows_com['company_abb'];?></td>
			<td data-th="聯絡人"><?php echo $rows_com['company_contact'];?></td>
			<td data-th="聯絡人電話"><?php echo $rows_com['company_con_tel'];?></td>
			<td data-th="聯絡人傳真"><?php echo $rows_com['company_con_fax']; ?></td>
			<td data-th="網路電話號碼"><?php echo $rows_com['internet_phone'];?></td>
			<td data-th="統一編號"><?php echo $rows_com['VTA_NO'];?></td>
			<td data-th="地址" colspan="3"><?php echo $rows_com['company_add'];?></td>
        </tr>
		<tr class="th_row" style="background-color:#5599FF;">
        <th>軟約</th>
		<th>軟約到期日</th>
		<th>硬約</th>
        <th>硬約到期日</th>
		<th>購買日期</th>
		<th>DCS</th>
		<th>DES</th>
		<th>DAS</th>
		<th>DGL</th>
		<th>DCST</th>
		<th>購PDF轉檔</th>
      </tr>
	  <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="軟約"><?php if($row_RecMember['soft_contract']==1)echo "V";?></td>
			<td data-th="軟約到期日"><?php echo $row_RecMember['company_contact'];?></td>
			<td data-th="硬約"><?php if($row_RecMember['hardware_contract']==1) echo "V";?></td>
			<td data-th="硬約到期日"><?php echo $row_RecMember['soft_end_date'];?></td>
			<td data-th="購買日期"><?php echo $row_RecMember[buy_date];?></td>
			<td data-th="DCS"><?php if($row_RecMember['DCS']==1) echo "V";?></td>
			<td data-th="DES"><?php if($row_RecMember['DES']==1) echo "V";?></td>
			<td data-th="DAS"><?php if($row_RecMember['DAS']==1) echo "V";?></td>
			<td data-th="DGL"><?php if($row_RecMember['DGL']==1) echo "V";?></td>
			<td data-th="DCST"><?php if($row_RecMember['DCST']==1) echo "V";?></td>
			<td data-th="購PDF轉檔"><?php if($row_RecMember['topdf']==1)echo "V";?></td>
        </tr>
		<tr class="th_row" style="background-color:#5599FF;">
		<th>X501</th>
		<th>匯出轉檔</th>
        <th>汎宇方案</th>
		<th>汎宇方案<BR>抵維護合約</th>
		<th>固定IP位置</th>
		<th>報關行</th>
		<th>公司</th>
		<th>轄區</th>
		<th>關貿貿捷<BR>用戶代碼</th>
		<th>關貿貿捷<BR>用戶密碼</th>
		<th>公司或連線人<BR>之Email</th>
      </tr>
	  <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="X501"><?php if($row_RecMember['X501']==1)echo "V";?></td>
			<td data-th="匯出轉檔"><?php echo $row_RecMember['export_file'];?></td>
			<td data-th="汎宇方案"><?php if($row_RecMember['py_program']==1)echo "V";?></td>
			<td data-th="汎宇方案抵維護合約"><?php  if($row_RecMember['py_offset']==1)echo "V";?></td>
			<td data-th="固定IP位置"><?php echo $row_RecMember['IP_address']; ?></td>
			<td data-th="報關行"><?php if($row_RecMember['customs_brokers']==1) echo "V";?></td>
			<td data-th="公司"><?php if($row_RecMember['cb_com']==1) echo "V";?></td>
			<td data-th="轄區"><?php echo $row_RecMember['area'];?></td>
			<td data-th="關貿貿捷用戶代碼"><?php $row_RecMember['user_id'];?></td>
			<td data-th="關貿貿捷用戶代碼"><?php $row_RecMember['user_pw'];?></td>
			<td data-th="關貿貿捷用戶代碼"><?php $row_RecMember['com_email'];?></td>
		</tr>
	  <tr class="th_row" style="background-color:#5599FF;">
		<th>負責人</th>
		<th>網路</th>
        <th>安裝日期</th>
		<th>原使用軟體</th>
		<th>合約台數<BR><實際台數></th>
		<th>旺旺友聯<BR>環成帳號</th>
		<th>旺旺友聯<BR>環成密碼</th>
		<th>設定旺旺友聯<BR>程式帳號日期</th>
		<th>FDA帳號<BR>X601</th>
		<th>貿捷用關貿傳輸</th>
		<th>EDI傳輸</th>
      </tr>
	  <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="負責人"><?php echo $row_RecMember['principal'];?></td>
			<td data-th="網路"><?php echo $row_RecMember['net'];?></td>
			<td data-th="安裝日期"><?php echo $row_RecMember['inst_date'];?></td>
			<td data-th="原使用軟體"><?php echo $row_RecMember['before_soft'];?></td>
			<td data-th="合約台數<實際台數>"><?php  echo $row_RecMember['contract_amount']."<".$row_RecMember['actual_amount'].">";?></td>
			<td data-th="旺旺友聯環成帳號"><?php echo $row_RecMember['wan_id']; ?></td>
			<td data-th="旺旺友聯環成密碼"><?php echo $row_RecMember['wan_pw']; ?></td>
			<td data-th="設定旺旺友聯程式帳號日期"><?php echo $row_RecMember['wan_inst_date']; ?></td>
			<td data-th="FDA帳號X601"><?php echo $row_RecMember['FDA_id'];?></td>
			<td data-th="貿捷用關貿傳輸"><?php if($row_RecMember['mk_trans']==1) echo "V";?></td>
			<td data-th="EDI傳輸"><?php echo $row_RecMember['EDI_trans'];?></td>
        </tr>
	   <tr class="th_row" style="background-color:#5599FF;">
			<th>變更關貿<BR>貿捷日期</th>
			<th>關貿(貿捷)<BR>貿E網傳送帳號</th>
			<th>變更汎宇<BR>貿捷日期</th>
			<th>通關網路</th>
			<th>郵箱代號</th>
			<th>郵箱密碼</th>
			<th>收件人代碼</th>
			<th colspan="2">備註</th>
			<th colspan="2">功能</th>
      </tr>
	  <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="變更關貿貿捷日期"><?php echo $row_RecMember['change_mk_date'];?></td>
			<td data-th="關貿(貿捷)貿E網傳送帳號"><?php echo $row_RecMember['trans_account'];?></td>
			<td data-th="變更汎宇貿捷日期"><?php echo $row_RecMember['change_fy_date'];?></td>
			<td data-th="通關網路"><?php echo $row_RecMember['customs_clearance_net'];?></td>
			<td data-th="郵箱代號"><?php  echo $row_RecMember['mailbox_code'];?></td>
			<td data-th="郵箱密碼"><?php echo $row_RecMember['mailbox_pw']; ?></td>
			<td data-th="收件人代碼"><?php echo $row_RecMember['addressee_code']; ?></td>
			<td data-th="備註" colspan="2"><?php echo $row_RecMember['remark']; ?></td>
			<td data-th="功能" colspan="2">
				<input type="button" value="修改" class="btn btn-default" onclick="window.open('customers_buy_system_edit.php?nid=<?PHP echo $auto_id;?>', 'newwindow', 'height=450, width=550, top=50, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no');">
				<input type="button" value="租用" class="btn btn-warning" onclick="if(confirm('客戶是否要改為租用?'))location.href='customers_buy_system.php?upid=<?php echo $auto_id;?>&c_id=<?php echo $row_RecMember['c_id'];?>';">
				<input type="button" value="不使用" class="btn btn-danger" onclick="if(confirm('客戶是否不使用系統?'))location.href='customers_buy_system.php?upid2=<?php echo $auto_id;?>&c_id=<?php echo $row_RecMember['c_id'];?>';">
				<!--<input type="button" value="刪除" class="btn btn-default" onclick="if(confirm('確定要刪除這一筆資料?'))location.href='customers_buy_system.php?deliid=<?php echo $auto_id;?>';">-->
			</td>
        </tr>
		<tr><td colspan="11" style="border: 0px;background-color:#FFF;">&nbsp;</td></tr>
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
}
else{
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
    header("Location:index.php");
    exit;
}
mysqli_free_result($RecMember);
?>

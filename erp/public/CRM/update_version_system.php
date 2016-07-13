<?php require_once('Connections/connSQL.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']!=""){

	if(isset($_GET["deliid"]))
	{
		$sql_de = "delete from update_version where no = '".$_GET["deliid"]."'";
		mysqli_query($connSQL,$sql_de)or die(mysqli_error());
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
  if($colname_RecMember=="c_id"){
	  $sql_com="select auto_id from company_system where company_abb like '%".$_GET['keyword']."%'";
	  $rs_com=mysqli_query($connSQL,$sql_com);
	  $rows_com=mysqli_fetch_array($rs_com);
	  $c_id=$rows_com["auto_id"];
  }
}
$keyword_RecMember = "%";
if (isset($_GET['keyword'])) {
	if($c_id!="")$keyword_RecMember=$c_id;
	else  $keyword_RecMember = "%".$_GET['keyword']."%";
}
if (empty($_GET['keyword'])) {
  if($colname_RecMember=="quote"){
	$keyword_RecMember="1";
  }
  else
	$keyword_RecMember = "%";
}
//mysql_select_db($database_connSQL, $connSQL);

$query_RecMember = sprintf("SELECT * FROM update_version WHERE %s LIKE %s ORDER BY no", $colname_RecMember,GetSQLValueString($keyword_RecMember, "text"));
$query_limit_RecMember = sprintf("%s LIMIT %d, %d", $query_RecMember, $startRow_RecMember, $maxRows_RecMember);
//echo $query_limit_RecMember;
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
                <a class="navbar-brand" href="update_version_system.php"><?php echo $sys_name; ?></a>
            </div>
            <!-- Top Menu Items -->
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
          
					
					<?php 
						$sql_menu="select * from menu order by mid";
						$rs=mysqli_query($connSQL,$sql_menu);
						while($row=mysqli_fetch_array($rs)){
							//$path=$_SERVER["PHP_SELF"];//抓網頁名稱,給<h3>用
							//$file = basename($path);
							$file = "update_kao_system.php";//因為menu裡面沒有放這隻程式,所以寫死
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
           <form name="form1" method="get" action="update_version_system.php"  class="form-inline" >
<strong>
               <select name="colname" id="colname" class="btn btn-primary dropdown-toggle">
			    <!--<select name="search" id="search" class="btn btn-primary dropdown-toggle">-->
					<option value="c_id" selected>查詢公司名稱</option>
               </select>
               </strong>
               <input type="text" class="form-control" name="keyword" id="keyword">
			   <!--<input type="text" class="form-control" name="p_keyword" id="p_keyword">-->
             
             <input type="submit" name="button" id="button" class="btn btn-default" value="查詢">
             <input name="button2" type="button" id="button2" class="btn btn-default" onClick="MM_goToURL('parent','update_version_system.php');return document.MM_returnValue" value="顯示所有資料">
			 <button type="button" class="btn btn-link" onclick="window.open('update_version_add.php', 'newwindow', 'height=700, width=800');">新增版本更新資料</button>
		   </form>
        </div><BR>
	    <div class="btn-group">
		<div class="container-fluid">
            <!--<button type="button" class="btn btn-info" onclick="window.open('update_version_add.php', 'newwindow', 'height=700, width=800');">新增</button>-->
       </div><br>
<div class="container-fluid">
            <ul class="nav nav-tabs">
				<?php
				$status=3;
					if (isset($_GET["s"]) and !empty($_GET["s"])) {
						$status=$_GET["s"];
					}
					switch($status){
						case 1:
						$tmp1='class="active"';
						break;
						case 2:
						$tmp2='class="active"';
						break;
						case 3:
						$tmp3='class="active"';
						break;
						case 4:
						$tmp4='class="active"';
						break;
					}
				?>
			  <li <?php echo $tmp1;?>><a href="update_kao_system.php?s=1">高雄更新資料</a></li>
			  <li <?php echo $tmp2;?>><a href="update_nan_system.php?s=2">台南更新資料</a></li>
			  <li <?php echo $tmp3;?>><a href="update_version_system.php?s=3">版本更新資料</a></li>
			  <li <?php echo $tmp4;?>><a href="das_system.php?s=4">DAS</a></li>
			</ul>
       </div><BR>
     </div>	 <BR>
     
   
   </div>
            
            
            <div class="container-fluid">
           
  <table class="table table-striped table_01" ><!--  style="table-layout: fixed;word-break: break-all;"  -->
  <?php $i=1; do {  $auto_id=$row_RecMember['no'];?>
      <tr class="th_row" style="background-color:#5599FF;">
		<th>公司名稱</th>
		<th>產證更新日期</th>
		<th>產證版本eTrade</th>
		<th>程式版本DES</th>
		<th>已更新EDI</th>
		<th>已更新EDI日期</th>
		<th>新EDI版本</th>
		<th>海運</th>
		<th>空運</th>
	  </tr>
	  <tr class="td_row"  style="background-color:#CCEEFF">
			<?php
				$sql_com="select company_name from company_system where auto_id='".$row_RecMember['c_id']."'";
				//echo $sql_com;
				$rs_com=mysqli_query($connSQL,$sql_com)or die(mysqli_error());
				$rows_com=mysqli_fetch_array($rs_com);
			?>
			<td data-th="公司名稱"><?php echo $rows_com['company_name'];?></td></td>
			<td data-th="產證更新日期"><?php echo $row_RecMember['pro_permit_update'];?></td>
			<td data-th="產證版本eTrade"><?php echo $row_RecMember['pro_permit_version'];?></td>
			<td data-th="程式版本DES"><?php echo $row_RecMember['program_version'];?></td>
			<td data-th="已更新EDI"><?php  if($row_RecMember['updateEDI']==1)echo "V";?></td>
			<td data-th="已更新EDI日期"><?php echo $row_RecMember['updateEDI_date'];?></td>
			<td data-th="新EDI版本"><?php echo $row_RecMember['newEDI'];?></td>
			<td data-th="海運"><?php  if($row_RecMember['ocean']==1)echo "V";?></td>
			<td data-th="空運"><?php  if($row_RecMember['air']==1)echo "V";?></td>
	  </tr>
	  <tr class="th_row" style="background-color:#5599FF;">
		<th>MySQL DES</th>
		<th>MySQL DAS</th>
		<th>DAS安裝日期</th>
		<th>DAS版本</th>
		<th>DGL安裝日期</th>
		<th>DGL版本</th>
		<th>D33FORM修改</th>
		<th>所在地</th>
		<th>功能</th>
      </tr>

      <tr class="td_row" style="background-color:#CCEEFF">
			<td data-th="MySQL DES"><?php  if($row_RecMember['DES']==1)echo "V";?></td>
			<td data-th="MySQL DAS"><?php  if($row_RecMember['DAS']==1)echo "V";?></td>
			<td data-th="DAS安裝日期"><?php echo $row_RecMember['DAS_insdate'];?></td>
			<td data-th="DAS版本"><?php echo $row_RecMember['DAS_ver'];?></td>
			<td data-th="DGL安裝日期"><?php echo $row_RecMember['DGL_insdate'];?></td>
			<td data-th="DGL版本"><?php echo $row_RecMember['DGL_ver'];?></td>
			<td data-th="D33FORM修改"><?php echo $row_RecMember['D33_edit'];?></td>
			<td data-th="所在地"><?php if($row_RecMember['place']=="k")echo "高雄"; elseif($row_RecMember['place']=="n") echo "台南";?></td>
			<td data-th="功能">
				<input type="button" value="修改" class="btn btn-default" onclick="window.open('update_version_system_edit.php?nid=<?PHP echo $auto_id;?>', 'newwindow', 'height=450, width=550, top=50, left=200, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no');">
				<!--<input type="button" id="del" value="刪除" class="btn btn-default" onclick="if(confirm('確定要刪除這一筆資料?'))location.href='company_system.php?deliid=<?php echo $auto_id;?>';">-->
				<input type="button" id="del<?php echo $i;?>" name="del<?php echo $i;?>" value="刪除" class="btn btn-default">
			</td>
        </tr>
		<tr><td colspan="9" style="border: 0px;background-color:#FFF;">&nbsp;</td></tr>
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

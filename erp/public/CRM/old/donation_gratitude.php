<?php require_once('Connections/connSQL.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']!=""){
	
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

// *** Redirect if username exists
	if (isset($_GET["nid"])) {
	  $donation_id=$_GET["nid"];
	  $LoginRS__query = sprintf("SELECT donation_id,donation_year,donation_name,donation_money,donation_address,donation_remark,handled,donation_id2 FROM donation_db WHERE donation_id=%s", GetSQLValueString($donation_id, "text"));
	  //echo $LoginRS__query;
	  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
	  $result=mysqli_fetch_array($LoginRS);//print_r($result);
	  $donation_id=$result["donation_id"];
	  $donation_year=$result["donation_year"];
	  $donation_name=$result["donation_name"];
	  $donation_money=$result["donation_money"];
	  $donation_address=$result["donation_address"];
	  $donation_remark=$result["donation_remark"];
	  $handled=$result["handled"];
	  $donation_id2=$result["donation_id2"];
	  $search="donation_relation";
	}
	else
	{
		echo "<script>location.href='donation_system.php';</script>";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja"><!-- InstanceBegin template="/Templates/mode-ad_new.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-tw">
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<!-- ▼頁面標題 -->
<!-- InstanceBeginEditable name="doctitle" -->
<title>列印</title>
<!-- InstanceEndEditable -->
<!--meta name="description" content="" />
<meta name="keywords" content="" />
<link href="../components/css/default.css" rel="stylesheet" type="text/css" /-->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<script type="text/javascript">
window.print();

</script>

</head>
<body>
<center>
	<h4>感  謝  狀</h4><br>

	<?php $t=getdate();?>
	<?php
		//list($donation_id,$donation_year,$donation_name,$donation_money,$donation_address,$donation_remark,$handled,$donation_id2)= mysqli_fetch_row($LoginRS);
	?>
	<form name="newsfm" id="newsfm" action="" method="post" onSubmit="return newsDataCheck()">
		<input name="donation_id" type="hidden" value="<?php echo $donation_id;?>">
		<table width="500px" border="0px">
			<tr><td align="center"><?php echo $donation_name;?></td></tr>
			<tr><td align="center">-------------------------------------</td></tr>
			<tr><td align="center" >捐獻日期 ： <?php echo $donation_year;?></td></tr>
			<tr><td align="center">捐獻編號 ： <?php echo $donation_id2;?></td></tr>	
			<tr><td align="center">捐獻金額 ：$ <?php echo number_format($donation_money);?></td></tr>
			<tr><td align="center">經手人 ： <?php echo $handled;?></td></tr>

			<tr><td align="center">-------------------------------------</td></tr>
						
			
		</table>
	<br>
	<!--input type="submit" value="修改"-->
	</form>
</center>
<address> </address>



</body>
<!-- InstanceEnd --></html>
<?php
}
else{
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
    header("Location:login.php");
    exit;
}
mysqli_free_result($LoginRS);
?>
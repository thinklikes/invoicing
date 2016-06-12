<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
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

// *** Redirect if username exists
	if (isset($_GET["nid"])) {
	  $borrow_id=$_GET["nid"];
	  $LoginRS__query = sprintf("SELECT * FROM borrow_db WHERE borrow_id =%s", GetSQLValueString($borrow_id, "text"));
	  //echo $LoginRS__query;
	  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
	  $result=mysqli_fetch_array($LoginRS);//print_r($result);
	  $borrow_name=$result["borrow_name"];
	  $borrow_date=$result["borrow_date"];
	  $back_date=$result["back_date"];
	  $borrow_barcode=$result["borrow_barcode"];
	  $borrow_request=$result["borrow_request"];
	  $borrow_back=$result["borrow_back"];
	}
	else
	{
		echo "<script>location.href='borrow_system.php';</script>";
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
	<h4>收 據</h4><br>

	<?php $t=getdate();?>
	<?php
		//list($donation_id,$donation_year,$donation_name,$donation_money,$donation_address,$donation_remark,$handled,$donation_id2)= mysqli_fetch_row($LoginRS);
	?>
	<form name="newsfm" id="newsfm" action="" method="post" onSubmit="return newsDataCheck()">
		<input name="borrow_id" type="hidden" value="<?php echo $borrow_id;?>">
		<table width="55%" border="0px" align="left">
			<tr><td align="center" ><font size="5">收 據</font></td></tr>

			<tr><td align="center"></br></br>收據</td></tr>
			<tr><td align="center">--------------------</td></tr>
			<tr><td align="center"><?php echo $borrow_name;?></td></tr>
			<tr><td align="center">借金日期 ： <?php echo $borrow_date;?></td></tr>
			<tr><td align="center">還金日期 ： <?php echo $back_date;?></td></tr>
			<tr><td align="center">求金編號 ： <?php echo $borrow_barcode;?></td></tr>	
			<tr><td align="center">求金金額 ： <?php echo $borrow_request;?></td></tr>
			<tr><td align="center">還金金額 ： <?php echo $borrow_back;?></td></tr>
			<tr><td align="center">--------------------</td></tr>
				
			
		</table>
	<br>
	<!--input type="submit" value="修改"-->
	</form>
</center>
<address> </address>



</body>
<!-- InstanceEnd --></html>

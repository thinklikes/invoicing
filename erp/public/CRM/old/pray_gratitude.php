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
	  $auto_id=$_GET["nid"];
	  $LoginRS__query = sprintf("SELECT auto_id,pray_name,pray_address,fd_pray_receivables,fd_end_receivables,tang_money,light_money FROM pray WHERE auto_id=%s", GetSQLValueString($auto_id, "text"));
	  //echo $LoginRS__query;
	  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
	  $result=mysqli_fetch_array($LoginRS);//print_r($result);
	  $auto_id=$result["auto_id"];
	  $pray_name=$result["pray_name"];
	  $pray_address=$result["pray_address"];
	  $search="pray_relation";
	  $keyword=$_GET["pray_relation"];
	}
	else
	{
		echo "<script>location.href='pray_system.php';</script>";
	}

?>
	<?php  //計算總數
	$total__query="SELECT SUM(fd_pray_receivables) as fd_pray_receivables,SUM(fd_end_receivables) as fd_end_receivables,SUM(tang_money) as tang_money,SUM(light_money) as light_money FROM pray WHERE  $search like '%$keyword%' ";
	//echo $total__query;exit;
	$rs2=mysqli_query($connSQL,$total__query) or die(mysqli_error());
	//$rs2 =  mysqli_query($connSQL,$total__query)or die(mysqli_error());	
	/*list($fd_pray_receivables,$fd_end_receivables,$tang_money,$light_money) = mysqli_fetch_row($rs2)*/
	$row=mysqli_fetch_array($rs2);
		$fd_pray_receivables=$row["fd_pray_receivables"];
		$fd_end_receivables=$row["fd_end_receivables"];
		$tang_money=$row["tang_money"];
		$light_money=$row["light_money"];
	
	//$rs3 =  mysql_query("SELECT SUM(fd_end_receivables) FROM light WHERE $search like '%$keyword%' ");	
	//list($fd_end_receivables) = mysql_fetch_row($rs3)
	//echo $light_sum;
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
	<!--tr><td color="#000000"><h4>感   謝   狀</h4></tr></td-->

	<?php
		//list($auto_id,$pray_name,$pray_address)= mysqli_fetch_row($rs);
		
	?>
	<?php $t=getdate();?>
	<form name="newsfm" id="newsfm" action="" method="post" onSubmit="return newsDataCheck()">
		<input name="auto_id" type="hidden" value="<?php echo $auto_id;?>">
		<!--table width="500px" border="0px"-->

			<?php //STYLE="margin-left:24px"?>
			<!--br><br><tr><td align="center"><HR color="#000000" width="70%"></td></tr-->
			
			<!--tr><td align="center">上係款&nbsp &nbsp &nbsp 貴大德捐獻本宮油香，如額收訖無訛功德無量並祝闔家平安、萬事如意</td></tr-->
			</br>
			<table width="100%" border="0px" ></br>
			<?php  
			$a[0]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 祈福/完福 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
			$a[1]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 堂份/光明燈 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
			$a[2]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 光明燈 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
			$a[3]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 堂份 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ';
			$a[4]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 祈福 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
			$a[5]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 完福 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ';
			$a[6]='&nbsp &nbsp &nbsp &nbsp ';
			$a[7]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 祈福/堂份 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ';
			$a[8]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 堂份/完福 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp ';
			$a[9]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 祈福/光明燈 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
			$a[10]='&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 完福/光明燈 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
		
			?>	

			<?php if($fd_pray_receivables==0 && $fd_end_receivables==0 && $tang_money==0 && $light_money==0) ///////nothing
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[6]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>	
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables==0 && $tang_money==0 && $light_money==0) ///////祈福
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[4]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>	
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables!=0 && $tang_money==0 && $light_money==0) ///////完福
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[5]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables!=0 && $tang_money==0 && $light_money==0) ///////祈福/完福
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[0]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables==0 && $tang_money!=0 && $light_money==0) ///////堂份
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[3]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables==0 && $tang_money==0 && $light_money!=0) ///////光明燈
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[2]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables==0 && $tang_money!=0 && $light_money!=0) ///////堂份/光明燈
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[1]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables==0 && $tang_money==0 && $light_money!=0) ///////祈福/光明燈
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[9]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables==0 && $tang_money!=0 && $light_money==0) ///////祈福/堂份
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[7]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables!=0 && $tang_money!=0 && $light_money==0) ///////完福/堂份
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[8]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables!=0 && $tang_money==0 && $light_money!=0) ///////完福/光明燈
			{	?>	<h2> <?php echo $a[6]?></h2> <h2> <?php echo $a[10]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables!=0 && $tang_money==0 && $light_money!=0) ///////完福/祈福/光明燈
			{	?>	<h2> <?php echo $a[4],$a[6]?></h2> <h2> <?php echo $a[10]?><?echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>	
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables!=0 && $tang_money!=0 && $light_money==0) ///////完福/祈福/堂份
			{	?>	<h2> <?php echo $a[4],$a[6]?></h2> <h2> <?php echo $a[8]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>	
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables==0 && $tang_money!=0 && $light_money!=0) ////////祈福/堂份/光明燈
			{	?>	<h2> <?php echo $a[4],$a[6]?></h2> <h2> <?php echo $a[1]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables==0 && $fd_end_receivables!=0 && $tang_money!=0 && $light_money!=0) ////////完福/堂份/光明燈
			{	?>	<h2> <?php echo $a[5],$a[6]?></h2> <h2> <?php echo $a[1]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
			
			<?php if($fd_pray_receivables!=0 && $fd_end_receivables!=0 && $tang_money!=0 && $light_money!=0) ////////祈福/完福/堂份/光明燈
			{	?>	<h2> <?php echo $a[0],$a[6]?></h2> <h2> <?php echo $a[1]?><?php echo $fd_pray_receivables+$fd_end_receivables+$tang_money+$light_money;?></h2> <?php  } ?>
						
			</table>
			
			<table width="800px" border="0px"></br></br>
			<tr><td align="left"  ><h2> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <?php echo $pray_name;?></h2> </td></tr>
			
			<tr><td align="left"  ><h2>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <?php echo $pray_address;?> </h2> </td></tr>
			</table>
			</br></br>
			<table width="700px" border="0px">
			<tr><td align="left"  ></br></br></br></br></br></br><h2> &nbsp &nbsp &nbsp &nbsp中華民國<?php echo $t["year"]-1911;?>年<?php echo $t["mon"];?>月<?php echo $t["mday"];?>日</h2> </td></tr>
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
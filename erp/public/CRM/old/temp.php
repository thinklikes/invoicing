<?php
	require("config.ini.php");
	if(!isset($_SESSION["adminid"]))
	{
		header("location:index.php");
	}
	
	if(isset($_GET["nid"]))
	{
		$auto_id = $_GET["nid"];
		$sql = "SELECT * FROM pray WHERE auto_id = '$auto_id'";
		$rs = mysql_query($sql);
		
	}
	else
	{
		echo "<script>location.href='pray_system_edit.php';</script>";
	}
	
	if(isset($_POST["auto_id"]))
	{
		$auto_id = $_POST["auto_id"];
		$pray_id = $_POST["pray_id"];
		$pray_nickname = $_POST["pray_nickname"];
		$pray_family = $_POST["pray_family"];
		$pray_name = $_POST["pray_name"];
		$pray_gender = $_POST["pray_gender"];
		$pray_birthday = $_POST["pray_birthday"];
		$pray_phone = $_POST["pray_phone"];
		$pray_address = $_POST["pray_address"];
		$fd_pray_year = $_POST["fd_pray_year"];
		$fd_pray_dateone = $_POST["fd_pray_dateone"];
		$fd_pray_datetwo = $_POST["fd_pray_datetwo"];
		$fd_pray_receivables = $_POST["fd_pray_receivables"];
		$fd_end_year = $_POST["fd_end_year"];
		$fd_end_dateone = $_POST["fd_end_dateone"];
		$fd_end_datetwo = $_POST["fd_end_datetwo"];
		$fd_end_receivables = $_POST["fd_end_receivables"];
		$tang_year = $_POST["tang_year"];
		$tang_money = $_POST["tang_money"];
		$light_year = $_POST["light_year"];
		$light_money = $_POST["light_money"];
		
	
		$sql = "UPDATE pray SET pray_id ='$pray_id',pray_nickname ='$pray_nickname',pray_family ='$pray_family',pray_name ='$pray_name',pray_gender='$pray_gender' ,pray_birthday='$pray_birthday',pray_phone='$pray_phone'
		,pray_address='$pray_address',fd_pray_year='$fd_pray_year',fd_pray_dateone='$fd_pray_dateone',fd_pray_datetwo='$fd_pray_datetwo',fd_pray_receivables='$fd_pray_receivables',fd_end_year='$fd_end_year'
		,fd_end_dateone='$fd_end_dateone',fd_end_datetwo='$fd_end_datetwo',fd_end_receivables='$fd_end_receivables',tang_year='$tang_year',tang_money='$tang_money'
		,light_year='$light_year',light_money='$light_money' where auto_id = '$auto_id'";		
//		$sql1 = "UPDATE family_dependant SET fd_number ='$pray_phone',fd_nickname ='$pray_nickname',fd_family ='$pray_family',fd_name='$pray_name' ,fd_gender='$pray_gender' where fd_number = '$pray_phone'  ";
//		$sql2 = "UPDATE tang SET tang_number ='$pray_phone',tang_name='$pray_family' ,tang_gender='$pray_gender' where tang_number = '$pray_phone'  ";
//		$sql3 = "UPDATE light SET light_number ='$pray_phone',light_name='$pray_family' ,light_gender='$pray_gender' where light_number = '$pray_phone'  ";
		//echo $sql;
		mysql_query($sql);
//		mysql_query($sql1);
//		mysql_query($sql2);
//		mysql_query($sql3);
		
		echo "<script>window.opener.location=window.opener.location.href;window.close();</script>";
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
<title>信徒資訊管理</title>
<!-- InstanceEndEditable -->
<meta name="description" content="" />
<meta name="keywords" content="" />
<link href="../temple_system/components/css/default.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script>
	function newsDataCheck()
		{
			var re = /^20\d{2}\.[0,1]?\d.[0,1,2,3]?\d$/; //檢查修改日期
			if(document.newsfm.pray_name.value == "")
			{
				alert("姓名不可為空白");
				return false;
			}
			if(document.newsfm.pray_phone.value == "")
			{
				alert("電話不得為空白");
				return false;
			}

			else
			{
				return true;
			}
		}

</script>
</head>
<body>
<center>
	<h1>修改信徒資料</h1><br>
	<?php
		list($auto_id,$pray_id,$pray_nickname,$pray_family,$pray_name,$pray_gender,$pray_birthday,$pray_phone,$pray_address,$fd_pray_year
		,$fd_pray_dateone,$fd_pray_datetwo,$fd_pray_receivables,$fd_end_year,$fd_end_dateone,$fd_end_datetwo,$fd_end_receivables
		,$tang_year,$tang_money,$light_year,$light_money)= mysql_fetch_row($rs);
	?>
	<form name="newsfm" id="newsfm" action="" method="post" onSubmit="return newsDataCheck()">
		<input name="auto_id" type="hidden" value="<?php echo $auto_id;?>">
		<table width="500px" border="1px">
			
			<tr>
			<td>編號</td>
			<td><input name="pray_id" cols="40" rows="3" value="<?php echo $pray_id;?>"></td>
			</tr>
			
			<tr>
			<td>姓名</td>
			<td><input name="pray_name" cols="40" rows="3" value="<?php echo $pray_name;?>"></td>
			</tr>

					
			<tr>
			<td>眷屬名</td>
			<td><input name="pray_family" cols="40" rows="3" value="<?php echo $pray_family;?>"></td>
			</tr>			
								
			<tr><td>出生年月日</td>
			<td><input name="pray_birthday" cols="40" rows="3" value="<?php echo $pray_birthday;?>"></td>				
			</tr>	
			
			<tr><td>電話</td>				
				<!--option name="pray_phone"  -->									
				<td><input name="pray_phone" cols="40" rows="3" value="<?php echo $pray_phone;?>"></td>				
			</tr>
			
			<tr>
				<td>地址</td>				
				<td><input name="pray_address" cols="40" rows="3" value="<?php echo $pray_address;?>" ></td>
			</tr>	
			<!-----------------------祈福-------------------->
<input name="fd_pray_year" value="<?php echo $fd_pray_year;?>" type="hidden">
<input name="fd_pray_dateone" value="<?php echo $fd_pray_dateone;?>" type="hidden">							
<input name="fd_pray_datetwo" value="<?php echo $fd_pray_datetwo;?>" type="hidden">
<input name="fd_pray_receivables" value="<?php echo $fd_pray_receivables;?>" type="hidden">
			<!-----------------------完福-------------------->
<input name="fd_end_year" value="<?php echo $fd_end_year;?>" type="hidden">
<input name="fd_end_dateone" value="<?php echo $fd_end_dateone;?>" type="hidden">							
<input name="fd_end_datetwo" value="<?php echo $fd_end_datetwo;?>" type="hidden">
<input name="fd_end_receivables" value="<?php echo $fd_end_receivables;?>" type="hidden">		
			<!-----------------------堂份-------------------->
<input name="tang_year" value="<?php echo $tang_year;?>" type="hidden">
<input name="tang_money" value="<?php echo $tang_money;?>" type="hidden">
			<!-----------------------光明燈-------------------->
<input name="light_year" value="<?php echo $light_year;?>" type="hidden">
<input name="light_money" value="<?php echo $light_money;?>" type="hidden">
			
		</table><!-----////////////////////////////////////////表格/----->
	<br>
	<input type="submit" value="修改">
	</form>
</center>
<address> </address>
</body>
<!-- InstanceEnd --></html>
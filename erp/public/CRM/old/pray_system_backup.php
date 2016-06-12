<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
    $filename="信徒資訊".date("YmdHi").".xls";   // 建立檔名
    header("Content-type:application/vnd.ms-excel"); // 送出header
    header("Content-Disposition:filename=$filename");  // 指定檔名€
	
?> 
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<!--head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-tw">
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" /-->
<!-- ▼頁面標題 -->
<!-- InstanceBeginEditable name="doctitle" -->
<!--title>瑞昶租賃管理系統</title-->
<!-- InstanceEndEditable -->
<!--meta name="description" content="" />
<meta name="keywords" content="" />
<link href="../components/css/default.css" rel="stylesheet" type="text/css" /-->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<!--/head-->
<body>


			<!-- ▼LOGO圖片 -->
			<div id="wrap">
			  <!-- InstanceBeginEditable name="IN" -->
			  <div id="contents">
 <center>
<h4>信徒資訊</h4>

<table border="1" cellpadding="0px">
	<tr align="center" style="background-color: #999999;">		
			<td width="70">編號</td>			
			<td width="70">姓名</td>			
			<td width="50px">稱謂</td>
			<td width="50px">眷屬</td>
			<td width="50px">性別</td>
			<td width="70px">出生年月日</td>
			<td width="90px">電話</td>
			<td width="180px">地址</td>	
			<td width="70px">祈福年份</td>
			<td width="70px">祈福日期</td>
			<td width="70px">祈福收款日</td>
			<td width="70px">祈福金額</td>
			<td width="70px">完福年份</td>
			<td width="70px">完福日期</td>
			<td width="70px">完福收款日</td>
			<td width="70px">完福金額</td>
			<td width="70px">堂份年份</td>
			<td width="70px">堂份金額</td>
			<td width="70px">光明燈年份</td>
			<td width="70px">光明燈金額</td>
				
			
	</tr>
<?php
	//以下頁數控制
	if(isset($_GET["page"]))
	{
		if(($_GET["page"]==""))
		{
			$page=1;
			//echo "1.page(set_empty) = ".$page."<br>";
		}
		else
		{
			$page=$_GET["page"];
			//echo "2.page(set) = ".$page."<br>";
		}
	}
	else
	{
		$page=1;
		//echo "3.page(non set) = ".$page."<br>";
	}
	$num_per_page = 999999999;
	//以上頁數控制
	$sql = "select * from pray ORDER BY auto_id";
	//echo $sql;borrow_barcode
	$rs = mysqli_query($connSQL,$sql);
	//$colorctrl = 0;
	while(list($auto_id,$pray_id,$pray_nickname,$pray_family,$pray_name,$pray_gender,$pray_birthday,$pray_phone,$pray_address,$fd_pray_year,$fd_pray_dateone
	,$fd_pray_datetwo,$fd_pray_receivables,$fd_end_year,$fd_end_dateone,$fd_end_datetwo,$fd_end_receivables,$tang_year,$tang_money
	,$light_year,$light_money,$pray_relation) = mysqli_fetch_row($rs))
	{
?>
		<tr bgcolor="<?php echo ($colorctrl%2==0)?$color01:$color02?>">	
<?//////////////////////////////////////////////////////////////////////////////////?>

		<td align="center"><?php echo $pray_id;?><!--編號--></td>
		<td align="center"><?php echo $pray_name;?><!--姓名--></td>
		<td align="center"><?php echo $pray_nickname;?><!--稱謂--></td>
		<td align="center"><?php echo $pray_family;?><!--眷屬--></td>
		<td align="center"><?php echo $pray_gender;?><!--性別--></td>
		<td align="center"><?php echo $pray_birthday;?><!--出生年月日--></td>
		<td>&nbsp;0<?php echo $pray_phone;?><!--電話--></td>
		<td align="left"><?php echo $pray_address;?><!--地址--></td>			
			<td align="center"><?php echo $fd_pray_year;?></td>							
			<td align="center"><?php echo $fd_pray_dateone;?></td>
			<td align="center"><?php echo $fd_pray_datetwo;?></td>
			<td align="right"><?php echo number_format($fd_pray_receivables);?></td>
			<td align="center"><?php echo $fd_end_year;?></td>
			<td align="center"><?php echo $fd_end_dateone;?></td>
			<td align="center"><?php echo $fd_end_datetwo;?></td>
			<td align="right"><?php echo number_format($fd_end_receivables);?></td>
			<td align="center"><?php echo $tang_year;?></td>
			<td align="right"><?php echo number_format($tang_money);?></td>
			<td align="center"><?php echo $light_year;?></td>
			<td align="right"><?php echo number_format($light_money);?></td>

			
			

<?/////////////////////////////////////////////////////////////////////////////////?>
			
		</tr>
<?php
	}
?>
</table>
	</center>
			  </div>
			  <!-- InstanceEndEditable -->

			  </div>
	
	<!-- ▼版權聲明 -->


</body>
<!-- InstanceEnd --></html>
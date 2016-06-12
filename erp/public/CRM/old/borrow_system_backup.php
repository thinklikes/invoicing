<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
    $filename="福德基金".date("YmdHi").".xls";   // 建立檔名
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
<h4>福德基金</h4>

<table border="1" cellpadding="0px">
	<tr align="center" style="background-color: #999999;">
			<td width="6%">編號</td>
			<td width="5%">年份</td>
			<td width="5%">姓名</td>
			<td width="5%">身分證字號</td>
			<td width="5%">電話</td>
			<td width="15%">地址</td>
			<td width="5%">求金金額</td>	
			<td width="5%">借出金額</td>		
			<td width="5%">還金金額</td>		
			<td width="5%">還金日期</td>		
			<td width="10%">備註</td>
	
			
	</tr>
<?php

	//以上頁數控制
	$sql = "select * from borrow_db ORDER BY borrow_id DESC";
	//echo $sql;borrow_barcode
	$rs = mysqli_query($connSQL,$sql);
	//$colorctrl = 0;
	while(list($borrow_id,$borrow_date,$borrow_name,$borrow_identity,$borrow_phone,$borrow_address,$borrow_request,$borrow_out,$borrow_back,$back_date,$borrow_remark,$borrow_barcode) = mysqli_fetch_row($rs))
	{
?>
		<tr bgcolor="<?php echo ($colorctrl%2==0)?$color01:$color02?>">
		
<?//////////////////////////////////////////////////////////////////////////////////?>
		
			<td align="left">
				<?php echo $borrow_barcode;?><!--編號-->
			</td>
			<td align="left">
				<?php echo $borrow_date;?><!--年份-->
			</td>
			<td align="left">
				<?php echo $borrow_name;?><!--姓名-->
			</td>
			<td align="left">
				<?php echo $borrow_identity;?><!--身分證-->
			</td>
			<td align="left">
				0<?php echo $borrow_phone;?><!--電話-->
			</td>
			<td align="left">
				<p align="left"><?php echo $borrow_address;?></p><!--地址-->
			</td>
			<td align="left">
				<p align="right"><?php echo  number_format($borrow_request);?></p><!--求金金額-->
			</td>
			<td align="left">
				<p align="right"><?php echo  number_format($borrow_out);?></p><!--借出-->
			</td>			
			<td align="left">
				<p align="right"><?php echo  number_format($borrow_back);?></p><!--歸還-->
			</td>
			<td align="left">
				<?php echo  ($back_date);?><!--歸還日期-->
			</td>
			<td align="left">
				<?php echo $borrow_remark;?><!--備註-->
			</td>			

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
</body>
<!-- InstanceEnd --></html>
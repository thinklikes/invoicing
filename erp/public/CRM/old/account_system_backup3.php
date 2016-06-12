<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
    $filename="福德-零用金".date("YmdHi").".xls";   // 建立檔名
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
<h4>福德-零用金</h4>

<table border="1" cellpadding="0px">
	<tr align="center" style="background-color: #999999;">		
			<td width="70px" colspan="3">年份</td>
			<td width="70px">科目</td>
			<td width="70px">摘要</td>
			<td width="70px">地址</td>
			<td width="90px">收入金額</td>
			<td width="90px">支出金額</td>	
			<td width="90px">餘額</td>		
			<td width="90px">備註</td>		
			
	</tr>
<?php

	//以上頁數控制
	$sql = "select * from account_db3 ORDER BY account_year";
	//echo $sql;borrow_barcode
	$rs = mysqli_query($connSQL,$sql);
	//$colorctrl = 0;
	while(list($account_id,$account_year,$account_subject,$account_abstract,$account_address,$account_income,$account_expenses,$account_surplus,$account_remark) = mysqli_fetch_row($rs))
	{
?>
		<tr bgcolor="<?php echo ($colorctrl%2==0)?$color01:$color02?>">
		
<?//////////////////////////////////////////////////////////////////////////////////?>
		
			<td align="center"><?php echo substr("$account_year", -7, 3);?><!--年份-->
			</td>
            <td align="center">&nbsp;<?php echo substr("$account_year", -4, 2);?><!--年份-->
			</td>
            <td align="center">
				&nbsp;<?php echo substr("$account_year", -2, 2);?><!--年份-->
			</td>
			<td align="center">
				<?php echo $account_subject;?><!--科目-->
			</td>
			<td>
				<?php echo $account_abstract;?><!--摘要-->
			</td>
			<td>
				<?php echo $account_address;?><!--地址-->
			</td>
			<td>
				<?php echo  number_format($account_income);?><!--收入-->
			</td>
			<td>
				<?php echo number_format($account_expenses);?><!--支出-->
			</td>
			<td>
				<?php echo  number_format($account_surplus);?><!--餘額-->
			</td>
			<td>
				<?php echo $account_remark;?><!--備註-->
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
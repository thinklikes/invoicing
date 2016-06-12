<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
    $filename="功德入會-捐獻名冊".date("YmdHi").".xls";   // 建立檔名
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
<h4>感謝狀-捐獻名冊</h4>

<table border="1" cellpadding="0px">
	<tr align="center" style="background-color: #999999;">		
			<td>捐獻編號</td>		
			<td>年份</td>
			<td>姓名</td>
			<td>住址</td>
			<td>品項</td>
			<td>捐獻金額</td>
			<td>經手人</td>	
			<td>備註</td>
            	
            
			
			
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
	$sql = "select * from donation_3_db ORDER BY donation_id";
	//echo $sql;borrow_barcode
	$rs = mysqli_query($connSQL,$sql);
	//$colorctrl = 0;
	while(list($donation_id,$donation_year,$donation_name,$donation_item,$donation_money,$donation_address,$donation_remark,$handled,$donation_id2) = mysqli_fetch_row($rs))
	{
?>
		<tr bgcolor="<?php echo ($colorctrl%2==0)?$color01:$color02?>">	
<?//////////////////////////////////////////////////////////////////////////////////?>

<td>&nbsp;<?php echo $donation_id2;?><!--捐獻編號--></td>
		<td align="center"><?php echo $donation_year;?><!--年份--></td>
		<td><?php echo $donation_name;?><!--姓名--></td>
		<td><?php echo $donation_address;?><!--住址--></td>
		<td><?php echo $donation_item;?><!--品項--></td>
		<td><?php echo number_format($donation_money);?><!--捐獻金額--></td>
		<td><?php echo $handled;?><!-- 經手人--></td>
		<td><?php echo $donation_remark;?><!--備註--></td>

			
			

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
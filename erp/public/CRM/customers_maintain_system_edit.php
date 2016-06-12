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
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "'NULL'";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "'NULL'";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "'NULL'";
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
  $LoginRS__query = sprintf("SELECT * FROM cust_maintain WHERE  no=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	for($i=1;$i<=6;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$soft_end_date=$tmp[0];
	$hardware_end_date=$tmp[1];
	$send_contract=$tmp[2];
	$contract=$tmp[3];
	$invoice=$tmp[4];
	$charge=$tmp[5];
  if($send_contract=="0000")$send_contract="";
  if($contract=="0000")$contract="";
  if($invoice=="0000")$invoice="";
  if($charge=="0000")$charge="";

  $updateSQL = sprintf("update cust_maintain set `c_id`=%s, `soft_end_date`=%s, `contract_amount`=%s, `actual_amount`=%s, `newcust_end`=%s, `hardware_end_date`=%s, `year`=%s, `cost`=%s, `send_contract`=%s, `contract`=%s, `invoice`=%s, `charge`=%s, `remark`=%s where no=%s",
                       GetSQLValueString($_POST['c_id'], "text"),
                       GetSQLValueString($soft_end_date, "text"),
                       GetSQLValueString($_POST['contract_amount'], "text"),
					   GetSQLValueString($_POST['actual_amount'], "text"),
					   GetSQLValueString($_POST['newcust_end'], "text"),
					   GetSQLValueString($hardware_end_date, "text"),
					   GetSQLValueString($_POST['year'], "text"),
					   GetSQLValueString($_POST['cost'], "text"),
					   GetSQLValueString($send_contract, "text"),
					   GetSQLValueString($contract, "text"),
					   GetSQLValueString($invoice, "text"),
					   GetSQLValueString($charge, "text"),
					   GetSQLValueString($_POST['remark'], "text"),
					   GetSQLValueString($auto_id, "text"));
	//$updateSQL=htmlspecialchars($updateSQL, ENT_QUOTES);
	//echo  $updateSQL."<BR>";
	//echo $_POST['c_id']."<BR>".$company_abb;
  $Result1 = mysqli_query($connSQL,$updateSQL) or die("修改資料錯誤".mysqli_error());
  echo "<script>alert('完成');window.opener.location=window.opener.location.href;window.close();</script>";
}	
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
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script>
function dateCheck(){
	if(document.form1.c_id.value==""){
		alert("請選擇公司");
		document.form1.c_id.focus();
		return false;
	}
	//if(document.getElementById('soft_contract').checked){
		<?php
			for($i=1;$i<=2;$i++){
				switch($i){
					case 1:
						$name="軟約";
						break;
					case 2:
						$name="硬約";
						break;
					case 3:
						$name="送合約";
						break;
					case 4:
						$name="已簽約";
						break;
					case 5:
						$name="已送發票";
						break;
					case 6:
						$name="已收款";
						break;
			}
		?>
				if(document.form1.yyy<?php echo $i;?>.value==""){alert("請選擇<?php echo $name;?>到期年份");document.form1.yyy<?php echo $i;?>.focus();return false;}
				if(document.form1.mm<?php echo $i;?>.value==""){alert("請選擇<?php echo $name;?>到期月份");document.form1.mm<?php echo $i;?>.focus();return false;}
				if(document.form1.dd<?php echo $i;?>.value==""){alert("請選擇<?php echo $name;?>到期日期");document.form1.dd<?php echo $i;?>.focus();return false;}
		
		<?php
			}
		?>
	//}

}
</script>
</head>
<body>

<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
			<!--
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				-->
                <a class="navbar-brand" href=""><?php echo $sys_name;?></a>
            </div>
			<!--
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.html"><i class="fa fa-fw fa-newspaper-o"></i> 最新消息</a>
                    </li>
                    <li>
                        <a href="login.php"><i class="fa fa-fw fa-users"></i> 會員登入</a>
                    </li>
					 <li>
                        <a href="memberadd.php"><i class="fa fa-fw fa-user"></i> 會員申請</a>
                    </li>
               </ul>
            </div>
			-->
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
		<div class="panel-heading">
 <h3>修改廠商維護資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onsubmit="return dateCheck()">
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司名稱</label>
                                         <div class="col-sm-10"><span id="sprytextfield1">
                 <!--<select name="c_id" id="c_id" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"> 
										<?php  
											$sql_com="select auto_id,company_name from company_system order by auto_id";
											$rs_com=mysqli_query($connSQL,$sql_com);
											echo "<option>請選擇公司</option>";
											while($row_com=mysqli_fetch_array($rs_com)){
										?>
											<option value="<?php echo $row_com["auto_id"];  ?>" <?php if($row_com["auto_id"]==$result["c_id"]) echo "selected";?>><?php echo $row_com["company_name"];  ?></option>
										<?php
											}
										?></select>-->
										<?php  
											$sql_com="select auto_id,company_name from company_system where auto_id='".$result["c_id"]."'";
											$rs_com=mysqli_query($connSQL,$sql_com);
											$row_com=mysqli_fetch_array($rs_com);
											echo $row_com["company_name"];
										?>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">軟約到期日</label>
                                         <div class="col-sm-10"><span id="sprytextfield2"><?php $j=date("Y")-1911;$i=$j; ?>
										 <?php
											$yyy=substr($result["soft_end_date"],0,3);
											$mm=substr($result["soft_end_date"],3,2);
											$dd=substr($result["soft_end_date"],5,2);
										 ?>
				 <select name="yyy1" id="yyy1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm1" id="mm1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd1" id="dd1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">合約台數</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="contract_amount" type="text" class="form-control" id="contract_amount" value="<?php echo $result["contract_amount"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">實際台數</label>
                                         <div class="col-sm-10"><span id="sprytextfield14">
                 <input name="actual_amount" type="text" class="form-control" id="actual_amount" value="<?php echo $result["actual_amount"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">新客戶到期</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="newcust_end" type="text" class="form-control" id="newcust_end" value="<?php echo $result["newcust_end"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">硬約到期日</label>
                                         <div class="col-sm-10"><span id="sprytextfield5"><?php $j=date("Y")-1911;$i=$j; ?>
										 <?php
											$yyy=substr($result["hardware_end_date"],0,3);
											$mm=substr($result["hardware_end_date"],3,2);
											$dd=substr($result["hardware_end_date"],5,2);
										 ?>
				 <select name="yyy2" id="yyy2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm2" id="mm2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd2" id="dd2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">年度</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <select name="year" id="year" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"><?php $j=date("Y")-1911;$i=$j; ?>
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($result["year"]==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">維護費用</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="cost" type="text" class="form-control" id="cost" value="<?php echo $result["cost"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">送合約日期</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
				 <select name="yyy3" id="yyy3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"><?php $j=date("Y")-1911;$i=$j; ?>
										<?php
											$yyy=substr($result["send_contract"],0,3);
											$mm=substr($result["send_contract"],3,2);
											$dd=substr($result["send_contract"],5,2);
										 ?>
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm3" id="mm3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd3" id="dd3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">已簽約</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <select name="yyy4" id="yyy4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"><?php $j=date("Y")-1911;$i=$j; ?>
				 <?php
											$yyy=substr($result["contract"],0,3);
											$mm=substr($result["contract"],3,2);
											$dd=substr($result["contract"],5,2);
										 ?>
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm4" id="mm4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd4" id="dd4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">已送發票</label>
                                         <div class="col-sm-10"><span id="sprytextfield11">
				 <select name="yyy5" id="yyy5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"><?php $j=date("Y")-1911;$i=$j; ?>
				 <?php
											$yyy=substr($result["contract"],0,3);
											$mm=substr($result["contract"],3,2);
											$dd=substr($result["contract"],5,2);
										 ?>
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm5" id="mm5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd5" id="dd5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">已收款</label>
                                         <div class="col-sm-10"><span id="sprytextfield12">
                 <select name="yyy6" id="yyy6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"><?php $j=date("Y")-1911;$i=$j; ?>
				 <?php
											$yyy=substr($result["contract"],0,3);
											$mm=substr($result["contract"],3,2);
											$dd=substr($result["contract"],5,2);
										 ?>
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm6" id="mm6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($mm==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd6" id="dd6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($dd==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield13">
                 <input name="remark" type="text" class="form-control" id="remark" value="<?php echo $result["remark"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
								
       <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
	  
         <button type="submit" class="btn btn-default" name="Submit2">修改</button>
         <button type="reset" class="btn btn-default" name="Submit3">重設</button>         
         <button type="button" class="btn btn-default" name="button" onclick="window.close();">關閉</button>
		 
      </div>
   </div>
   <input type="hidden" name="MM_insert" value="form1">
</form>
                   

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
<script type="text/javascript">
</script>
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<script src="css//bootstrap-select.min.js"></script>
</body>

</html>

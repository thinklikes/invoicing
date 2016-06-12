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
  $LoginRS__query = sprintf("SELECT * FROM cust_purchase WHERE  no=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  if($_POST["mm"]!="")
  $company_abb=$_POST["yyy"].str_pad($_POST["mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd"],2,'0',STR_PAD_LEFT);
if($_POST["mm2"]!="")
  $hardware_end_date=$_POST["yyy2"].str_pad($_POST["mm2"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd2"],2,'0',STR_PAD_LEFT);
if($_POST["buy_mm"]!="")
  $buy_date=$_POST["buy_yyy"].str_pad($_POST["buy_mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["buy_dd"],2,'0',STR_PAD_LEFT);
if($_POST["ins_mm"]!="")
  $inst_date=$_POST["ins_yyy"].str_pad($_POST["ins_mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["ins_dd"],2,'0',STR_PAD_LEFT);
if($_POST["wan_mm"]!="")
  $wan_inst_date=$_POST["wan_yyy"].str_pad($_POST["wan_mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["wan_dd"],2,'0',STR_PAD_LEFT);
if($_POST["mk_mm"]!="")
  $change_mk_date=$_POST["mk_yyy"].str_pad($_POST["mk_mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["mk_dd"],2,'0',STR_PAD_LEFT);
if($_POST["fy_mm"]!="")
  $change_fy_date=$_POST["fy_yyy"].str_pad($_POST["fy_mm"],2,'0',STR_PAD_LEFT).str_pad($_POST["fy_dd"],2,'0',STR_PAD_LEFT);

  if($company_abb=="年份月份日期")$company_abb="";
  if($hardware_end_date=="年份月份日期")$hardware_end_date="";
  if($buy_date=="年份月份日期")$buy_date="";
  if($inst_date=="年份月份日期")$inst_date="";
  if($wan_inst_date=="年份月份日期")$wan_inst_date="";
  if($change_mk_date=="年份月份日期")$change_mk_date="";
  if($change_fy_date=="年份月份日期")$change_fy_date="";
  
  $net=implode($_POST['net'],",");

  $updateSQL = sprintf("update cust_purchase set `c_id`=%s, `soft_contract`=%s, `soft_end_date`=%s, `hardware_contract`=%s, `hardware_end_date`=%s, `buy_date`=%s, `DCS`=%s, `DES`=%s, `DAS`=%s, `DGL`=%s, `DCST`=%s, `topdf`=%s, `X501`=%s, `export_file`=%s, `py_program`=%s, `py_offset`=%s, `IP_address`=%s, `customs_brokers`=%s, `cb_com`=%s, `area`=%s, `user_id`=%s, `user_pw`=%s, `com_email`=%s, `principal`=%s, `net`=%s, `inst_date`=%s, `before_soft`=%s, `contract_amount`=%s, `actual_amount`=%s, `wan_id`=%s, `wan_pw`=%s, `wan_inst_date`=%s, `FDA_id`=%s,`remark`=%s,`mk_trans`=%s, `EDI_trans`=%s, `change_mk_date`=%s, `trans_account`=%s, `change_fy_date`=%s, `customs_clearance_net`=%s, `mailbox_code`=%s, `mailbox_pw`=%s, `addressee_code`=%s where no=%s ",
                       GetSQLValueString($_POST['c_id'], "text"),
                       GetSQLValueString($_POST['soft_contract'], "text"),
                       GetSQLValueString($company_abb, "text"),
                       GetSQLValueString($_POST['hardware_contract'], "text"),
                       GetSQLValueString($hardware_end_date, "text"),
					   GetSQLValueString($buy_date, "text"),
					   GetSQLValueString($_POST['DCS'], "text"),
					   GetSQLValueString($_POST['DES'], "text"),
					   GetSQLValueString($_POST['DAS'], "text"),
					   GetSQLValueString($_POST['DGL'], "text"),
					   GetSQLValueString($_POST['DCST'], "text"),
					   GetSQLValueString($_POST['topdf'], "text"),
					   GetSQLValueString($_POST['X501'], "text"),
					   GetSQLValueString($_POST['export_file'], "text"),
					   GetSQLValueString($_POST['py_program'], "text"),
					   GetSQLValueString($_POST['py_offset'], "text"),
					   GetSQLValueString($_POST['IP_address'], "text"),
					   GetSQLValueString($_POST['customs_brokers'], "text"),
					   GetSQLValueString($_POST['cb_com'], "text"),
					   GetSQLValueString($_POST['area'], "text"),
					   GetSQLValueString($_POST['user_id'], "text"),
					   GetSQLValueString($_POST['user_pw'], "text"),
					   GetSQLValueString($_POST['com_email'], "text"),
					   GetSQLValueString($_POST['principal'], "text"),
					   GetSQLValueString($net, "text"),
					   GetSQLValueString($inst_date, "text"),
					   GetSQLValueString($_POST['before_soft'], "text"),
					   GetSQLValueString($_POST['contract_amount'], "text"),
					   GetSQLValueString($_POST['actual_amount'], "text"),
					   GetSQLValueString($_POST['wan_id'], "text"),
					   GetSQLValueString($_POST['wan_pw'], "text"),
					   GetSQLValueString($wan_inst_date, "text"),
					   GetSQLValueString($_POST['FDA_id'], "text"),
					   GetSQLValueString($_POST['remark'], "text"),
					   GetSQLValueString($_POST['mk_trans'], "text"),
					   GetSQLValueString($_POST['EDI_trans'], "text"),
					   GetSQLValueString($change_mk_date, "text"),
					   GetSQLValueString($_POST['trans_account'], "text"),
					   GetSQLValueString($change_fy_date, "text"),
					   GetSQLValueString($_POST['customs_clearance_net'], "text"),
					   GetSQLValueString($_POST['mailbox_code'], "text"),
					   GetSQLValueString($_POST['mailbox_pw'], "text"),
					   GetSQLValueString($_POST['addressee_code'], "text"),
					   GetSQLValueString($_GET["nid"], "text"));
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
function productDataCheck(){
	if(document.form1.c_id.value=="請選擇公司"){
		alert("請選擇公司");
		document.form1.c_id.focus();
		return false;
	}
	if(document.getElementById('soft_contract').checked){
		if(document.form1.yyy.value==""){alert("請選擇軟約到期年份");document.form1.yyy.focus();return false;}
		if(document.form1.mm.value==""){alert("請選擇軟約到期月份");document.form1.mm.focus();return false;}
		if(document.form1.dd.value==""){alert("請選擇軟約到期日期");document.form1.dd.focus();return false;}
	}
	else{
		document.form1.yyy.value="";document.form1.mm.value="";document.form1.dd.value="";
	}
	if(document.getElementById('hardware_contract').checked){
		if(document.form1.yyy2.value==""){alert("請選擇硬約到期年份");document.form1.yyy.focus();return false;}
		if(document.form1.mm2.value==""){alert("請選擇硬約到期月份");document.form1.mm.focus();return false;}
		if(document.form1.dd2.value==""){alert("請選擇硬約到期日期");document.form1.dd.focus();return false;}
	}
	else{
		document.form1.yyy2.value="";document.form1.mm2.value="";document.form1.dd2.value="";
	}
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
 <h3>修改廠商購買資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onSubmit="return productDataCheck()">
									<!--<div class="form-group">
                                         <label  class="col-sm-2 control-label">編號</label>
                                         <div class="col-sm-10"><span id="sprytextfield1">
                 <input name="auto_id" type="text" class="form-control" id="pray_id" value="<?php  echo $result["auto_id"]; ?>">
                 </span><br>
										 </div>
                                    </div>-->
									
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
										<input type="hidden" name="c_id" id="c_id" value=<?php echo $result["c_id"]; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">軟約</label>
                                         <div class="col-sm-1"><span id="sprytextfield2">
				 <input type="checkbox" name="soft_contract" id="soft_contract" value="1" <?php if($result["soft_contract"]==1) echo "checked=checked"; ?>>
                 </span>
										 </div>
										 <?php
											$yyy=substr($result["soft_end_date"],0,3);
											$mm=substr($result["soft_end_date"],3,2);
											$dd=substr($result["soft_end_date"],5,2);
										 ?>
										 <label  class="col-sm-2 control-label">軟約到期日</label>
                                         <div class="col-sm-5"><span id="sprytextfield3"><?php $j=date("Y")-1911;$i=$j;$j=$j-8; ?>
				 <select name="yyy" id="yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm" id="mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd" id="dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
                                         <label  class="col-sm-2 control-label">硬約</label>
                                         <div class="col-sm-1"><span id="sprytextfield4">
				 <input type="checkbox" name="hardware_contract" id="hardware_contract"  value="1" <?php if($result["hardware_contract"]==1) echo "checked=checked"; ?>>
                 </span>
										 </div>
										 <?php
											$y3=substr($result["hardware_end_date"],0,3);
											$m2=substr($result["hardware_end_date"],3,2);
											$d2=substr($result["hardware_end_date"],5,2);
										 ?>
										 <label  class="col-sm-2 control-label">硬約到期日</label>
                                         <div class="col-sm-5"><span id="sprytextfield5"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy2" id="yyy2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+20){
							if($y3==$j)$selected="selected";else $selected="";
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
							if($m2==$m)$selected="selected";else $selected="";
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
							if($d2==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">購買日期</label>
										 <?php
											$y3=substr($result["buy_date"],0,3);
											$m2=substr($result["buy_date"],3,2);
											$d2=substr($result["buy_date"],5,2);
										 ?>
                                         <div class="col-sm-10"><span id="sprytextfield6"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="buy_yyy" id="buy_yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>年份</option>
					<?php
						while($j>$i-20){
							if($y3==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j--;
						}
					?>
				 </select>
				 <select name="buy_mm" id="buy_mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m2==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="buy_dd" id="buy_dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($d2==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DCS</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <input name="DCS" type="checkbox" id="DCS" value="1" <?php if($result["DCS"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DES</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="DES" type="checkbox" id="DES" value="1" <?php if($result["DES"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DAS</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="DAS" type="checkbox" id="DAS" value="1" <?php if($result["DAS"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DGL</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="DGL" type="checkbox" id="DGL" value="1" <?php if($result["DGL"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DCST</label>
                                         <div class="col-sm-10"><span id="sprytextfield11">
                 <input name="DCST" type="checkbox" id="DCST" value="1" <?php if($result["DCST"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">購PDF轉檔</label>
                                         <div class="col-sm-10"><span id="sprytextfield12">
                 <input name="topdf" type="checkbox" id="topdf" value="1" <?php if($result["topdf"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X501</label>
                                         <div class="col-sm-10"><span id="sprytextfield13">
                 <input name="X501" type="checkbox" id="X501" value="1" <?php if($result["X501"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">匯出轉檔</label>
                                         <div class="col-sm-10"><span id="sprytextfield14">
                 <input name="export_file" type="checkbox" id="export_file" value="1" <?php if($result["export_file"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">汎宇方案</label>
                                         <div class="col-sm-10"><span id="sprytextfield15">
                 <input name="py_program" type="checkbox" id="py_program" value="1" <?php if($result["py_program"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">汎宇方案抵維護合約</label>
                                         <div class="col-sm-10"><span id="sprytextfield16">
                 <input name="py_offset" type="checkbox" id="py_offset" value="1" <?php if($result["py_offset"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">固定IP位址</label>
                                         <div class="col-sm-10"><span id="sprytextfield17">
                 <input name="IP_address" type="text" class="form-control" id="IP_address" value="<?php echo $result["IP_address"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">報關行</label>
                                         <div class="col-sm-10"><span id="sprytextfield18">
                 <input name="customs_brokers" type="checkbox"  id="customs_brokers" value="1" <?php if($result["customs_brokers"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司</label>
                                         <div class="col-sm-10"><span id="sprytextfield19">
                 <input name="cb_com" type="checkbox" id="cb_com" value="1" <?php if($result["cb_com"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">轄區</label>
                                         <div class="col-sm-10"><span id="sprytextfield20">
                 <input name="area" type="text" class="form-control" id="area" value="<?php echo $result["area"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">關貿貿捷用戶代碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield21">
                 <input name="user_id" type="text" class="form-control" id="user_id" value="<?php echo $result["user_id"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">關貿貿捷密碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield22">
                 <input name="user_pw" type="text" class="form-control" id="user_pw" value="<?php echo $result["user_pw"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司或連線人之E-MAIL</label>
                                         <div class="col-sm-10"><span id="sprytextfield23">
                 <input name="com_email" type="text" class="form-control" id="com_email" value="<?php echo $result["com_email"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">負責人</label>
                                         <div class="col-sm-10"><span id="sprytextfield24">
                 <input name="principal" type="text" class="form-control" id="principal" value="<?php echo $result["principal"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">網路</label>
                                         <div class="col-sm-10"><span id="sprytextfield25">
										 <?php
											$net=explode(",",$result["net"]);
											$i=0;
										 ?>
				 <select name="net[]" id="net[]" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit" multiple="multiple">
				 <option value="關貿"<?php while($net[$i]=="關貿") {echo "selected"; $i++;}?>>關貿</option>
				 <option value="汎宇"<?php while($net[$i]=="汎宇"){ echo "selected"; $i++;}?>>汎宇</option>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">安裝日期</label>
										 <?php
											$y3=substr($result["inst_date"],0,3);
											$m2=substr($result["inst_date"],3,2);
											$d2=substr($result["inst_date"],5,2);
										 ?>
                                         <div class="col-sm-10"><span id="sprytextfield26"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="ins_yyy" id="ins_yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>年份</option>
					<?php
						while($j>$i-20){
							if($y3==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j--;
						}
					?>
				 </select>
				 <select name="ins_mm" id="ins_mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m2==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="ins_dd" id="ins_dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($d2==$m)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">原始使用軟體</label>
                                         <div class="col-sm-10"><span id="sprytextfield27">
                 <input name="before_soft" type="text" class="form-control" id="before_soft" value="<?php echo $result["before_soft"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">合約台數</label>
                                         <div class="col-sm-10"><span id="sprytextfield28">
                 <input name="contract_amount" type="text" class="form-control" id="contract_amount" value="<?php echo $result["contract_amount"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">實際台數</label>
                                         <div class="col-sm-10"><span id="sprytextfield29">
                 <input name="actual_amount" type="text" class="form-control" id="actual_amount" value="<?php echo $result["actual_amount"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">旺旺友聯環成帳號</label>
                                         <div class="col-sm-10"><span id="sprytextfield30">
                 <input name="wan_id" type="text" class="form-control" id="wan_id" value="<?php echo $result["wan_id"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">旺旺友聯環成密碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield31">
                 <input name="wan_pw" type="text" class="form-control" id="wan_pw" value="<?php echo $result["wan_pw"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">設定旺旺友聯程式帳號日期</label>
										 <?php
											$y3=substr($result["wan_inst_date"],0,3);
											$m2=substr($result["wan_inst_date"],3,2);
											$d2=substr($result["wan_inst_date"],5,2);
										 ?>
                                         <div class="col-sm-10"><span id="sprytextfield32"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="wan_yyy" id="wan_yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>年份</option>
					<?php
						while($j>$i-20){
							if($y3==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j--;
						}
					?>
				 </select>
				 <select name="wan_mm" id="wan_mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="wan_dd" id="wan_dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($d2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">FDA帳號X601</label>
                                         <div class="col-sm-10"><span id="sprytextfield33">
                 <input name="FDA_id" type="text" class="form-control" id="FDA_id" value="<?php echo $result["FDA_id"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">貿捷用關貿傳輸</label>
                                         <div class="col-sm-10"><span id="sprytextfield34">
                 <input name="mk_trans" type="checkbox" id="mk_trans" value="1" <?php if($result["mk_trans"]==1) echo "checked=checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">EDI傳輸</label>
                                         <div class="col-sm-10"><span id="sprytextfield35">
                 <select name="EDI_trans" id="EDI_trans" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option ="">請選擇</option>
					<option ="關貿" <?php if($result["EDI_trans"]=="關貿") echo "checked=checked"; ?>>關貿</option>
					<option ="汎宇" <?php if($result["EDI_trans"]=="汎宇") echo "checked=checked"; ?>>汎宇</option>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">變更關貿貿捷日期</label>
										<div class="col-sm-10"><span id="sprytextfield36"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="mk_yyy" id="mk_yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>年份</option>
					<?php
						while($j>$i-20){
							if($y3==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j--;
						}
					?>
				 </select>
				 <select name="mk_mm" id="mk_mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="mk_dd" id="mk_dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($d2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">關貿貿E網傳送帳號<br>汎宇貿E網傳送帳號</label>
                                         <div class="col-sm-10"><span id="sprytextfield37">
                 <input name="trans_account" type="text" class="form-control" id="trans_account" value="<?php echo $result["trans_account"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">變更汎宇貿捷日期</label>
										<div class="col-sm-10"><span id="sprytextfield38"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="fy_yyy" id="fy_yyy" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>年份</option>
					<?php
						while($j>$i-20){
							if($y3==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j--;
						}
					?>
				 </select>
				 <select name="fy_mm" id="fy_mm" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="fy_dd" id="fy_dd" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option>日期</option>
					<?php
						$m=1;
						while($m<=31){
							if($d2==$j)$selected="selected";else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">通關網路</label>
                                         <div class="col-sm-10"><span id="sprytextfield39">
                 <input name="customs_clearance_net" type="text" class="form-control" id="customs_clearance_net" value="<?php echo $result["customs_clearance_net"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">郵箱代號</label>
                                         <div class="col-sm-10"><span id="sprytextfield40">
                 <input name="mailbox_code" type="text" class="form-control" id="mailbox_code" value="<?php echo $result["mailbox_code"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">郵箱密碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield41">
                 <input name="mailbox_pw" type="text" class="form-control" id="mailbox_pw" value="<?php echo $result["mailbox_pw"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">收件人代碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield42">
                 <input name="addressee_code" type="text" class="form-control" id="addressee_code" value="<?php echo $result["addressee_code"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield43">
				 <textarea name="remark" rows="4" cols="50" class="form-control" id="remark" ><?php echo $result["remark"]; ?></textarea>
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

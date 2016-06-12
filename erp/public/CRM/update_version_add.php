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
/*if (isset($_GET["nid"])) {
  $auto_id=$_GET["nid"];
  $LoginRS__query = sprintf("SELECT * FROM company_system WHERE auto_id=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}*/

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
for($i=1;$i<=10;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$pro_permit_update=$tmp[0];
	$pro_permit_version=$tmp[1];
	$program_version=$tmp[2];
	$updateEDI_date=$tmp[3];
	$newEDI=$tmp[4];
	$DAS_insdate=$tmp[5];
	$DAS_ver=$tmp[6];
	$DGL_insdate=$tmp[7];
	$DGL_ver=$tmp[8];
	$D33_edit=$tmp[9];

  if($pro_permit_update=="0000")$pro_permit_update="";
  if($pro_permit_version=="0000")$pro_permit_version="";
  if($program_version=="0000")$program_version="";
  if($updateEDI_date=="0000")$updateEDI_date="";
  if($newEDI=="0000")$newEDI="";
  if($DAS_insdate=="0000")$DAS_insdate="";
  if($DAS_ver=="0000")$DAS_ver="";
  if($DGL_insdate=="0000")$DGL_insdate="";
  if($DGL_ver=="0000")$DGL_ver="";
  if($D33_edit=="0000")$D33_edit="";

  $updateSQL = sprintf("insert into update_version (`c_id`, `pro_permit_update`, `pro_permit_version`, `program_version`, `updateEDI`, `updateEDI_date`, `newEDI`, `ocean`, `air`, `DES`, `DAS`, `DAS_insdate`, `DAS_ver`, `DGL_insdate`, `DGL_ver`, `D33_edit`, `place`) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['c_id'], "text"),
					   GetSQLValueString($pro_permit_update, "text"),
                       GetSQLValueString($pro_permit_version, "text"),
                       GetSQLValueString($program_version, "text"),
                       GetSQLValueString($_POST['updateEDI'], "text"),
					   GetSQLValueString($updateEDI_date, "text"),
					   GetSQLValueString($newEDI, "text"),
					   GetSQLValueString($_POST['ocean'], "text"),
					   GetSQLValueString($_POST['air'], "text"),
					   GetSQLValueString($_POST['DES'], "text"),
					   GetSQLValueString($_POST['DAS'], "text"),
					   GetSQLValueString($DAS_insdate, "text"),
					   GetSQLValueString($DAS_ver, "text"),
					   GetSQLValueString($DGL_insdate, "text"),
					   GetSQLValueString($DGL_ver, "text"),
					   GetSQLValueString($D33_edit, "text"),
					   GetSQLValueString($_POST['place'], "text"));
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
	if(document.getElementById('hardware_contract').checked){
		if(document.form1.yyy2.value==""){alert("請選擇硬約到期年份");document.form1.yyy.focus();return false;}
		if(document.form1.mm2.value==""){alert("請選擇硬約到期月份");document.form1.mm.focus();return false;}
		if(document.form1.dd2.value==""){alert("請選擇硬約到期日期");document.form1.dd.focus();return false;}
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
 <h3>新增客戶更新資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onSubmit="return productDataCheck()">
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司名稱</label>
                                         <div class="col-sm-10"><span id="sprytextfield1">
                 <select name="c_id" id="c_id" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"> 
										<?php  
											$sql_com="select auto_id,company_name,company_status from company_system order by auto_id";
											$rs_com=mysqli_query($connSQL,$sql_com);
											echo "<option>請選擇公司</option>";
											while($row_com=mysqli_fetch_array($rs_com)){
										?>
											<option value="<?php echo $row_com["auto_id"];  ?>"><?php echo $row_com["company_name"];  ?></option>
										<?php
											}
										?></select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">產證更新日期</label>
                                         <div class="col-sm-5"><span id="sprytextfield2"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy1" id="yyy1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm1" id="mm1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd1" id="dd1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<!--<div class="form-group">
                                         <label  class="col-sm-2 control-label">Memo</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="sea" type="checkbox" id="sea" value="sea">海運 &nbsp;&nbsp;&nbsp;<input name="air" type="checkbox" id="air" value="air">空運
                 </span><br>
										 </div>
                                    </div>-->
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">產證版本eTrade</label>
                                         <div class="col-sm-5"><span id="sprytextfield3"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy2" id="yyy2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm2" id="mm2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd2" id="dd2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">程式版本DES</label>
                                         <div class="col-sm-5"><span id="sprytextfield4"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy3" id="yyy3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm3" id="mm3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd3" id="dd3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">已更新EDI</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="updateEDI" type="checkbox" id="updateEDI" value="1"></span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">已更新EDI日期</label>
                                         <div class="col-sm-5"><span id="sprytextfield6"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy4" id="yyy4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm4" id="mm4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd4" id="dd4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">新EDI版本</label>
                                         <div class="col-sm-5"><span id="sprytextfield7"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy5" id="yyy5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm5" id="mm5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd5" id="dd5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">海運</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="ocean" type="checkbox" id="ocean" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">空運</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="air" type="checkbox" id="air" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">MySQL DES</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="DES" type="checkbox" id="DES" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">MySQL DAS</label>
                                         <div class="col-sm-10"><span id="sprytextfield11">
                 <input name="DAS" type="checkbox" id="DAS" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DAS安裝日期</label>
                                         <div class="col-sm-10"><span id="sprytextfield12"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="yyy6" id="yyy6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm6" id="mm6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd6" id="dd6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DAS版本</label>
                                         <div class="col-sm-10"><span id="sprytextfield13"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="yyy7" id="yyy7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm7" id="mm7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd7" id="dd7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DGL安裝日期</label>
                                         <div class="col-sm-10"><span id="sprytextfield14"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="yyy8" id="yyy8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm8" id="mm8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd8" id="dd8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DGL版本</label>
                                         <div class="col-sm-10"><span id="sprytextfield15"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="yyy9" id="yyy9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm9" id="mm9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd9" id="dd9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">D33FORM修改</label>
                                         <div class="col-sm-10"><span id="sprytextfield16"><?php $j=date("Y")-1911;$i=$j; ?>
                 <select name="yyy10" id="yyy10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							echo "<option value=$j>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm10" id="mm10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
				 <select name="dd10" id="dd10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">日期</option>
					<?php
						$m=1;
						while($m<=31){
							echo "<option value=$m>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">所在地</label>
                                         <div class="col-sm-10"><span id="sprytextfield17">
                 <select name="place" id="place" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">請選擇</option>
					<option value="k">高雄</option>
					<option value="n">台南</option>
				 </select>
                 </span><br>
										 </div>
                                    </div>
																	
       <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
	  
         <button type="submit" class="btn btn-default" name="Submit2">新增</button>
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

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
  $LoginRS__query = sprintf("SELECT * FROM update_nan WHERE no=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
for($i=1;$i<=13;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$pp_update=$tmp[0];
	$X301_update=$tmp[1];
	$trade_code=$tmp[2];
	$bug_update=$tmp[3];
	$X601=$tmp[4];
	$hardware_end=$tmp[5];
	$X101_ECFA=$tmp[6];
	$DAS_MYSQL=$tmp[7];
	$revision=$tmp[8];
	$X101_ECFA_5=$tmp[9];
	$luxury_tax_rev=$tmp[10];
	$sum_sub=$tmp[11];
	$X101_ECFA_PP_rev=$tmp[12];

  if($pp_update=="0000")$pp_update="";
  if($X301_update=="0000")$X301_update="";
  if($trade_code=="0000")$trade_code="";
  if($bug_update=="0000")$bug_update="";
  if($X101_ECFA_PP_rev=="0000")$X101_ECFA_PP_rev="";
  if($X601=="0000")$X601="";
  if($hardware_end=="0000")$hardware_end="";
  if($X101_ECFA=="0000")$X101_ECFA="";
  if($DAS_MYSQL=="0000")$DAS_MYSQL="";
  if($revision=="0000")$revision="";
  if($X101_ECFA_5=="0000")$X101_ECFA_5	="";
  if($luxury_tax_rev=="0000")$luxury_tax_rev="";
  if($sum_sub=="0000")$sum_sub="";
  
  $memo=$_POST['sea'].",".$_POST['air'];
  $version=implode($_POST['version'],",");
	
  $updateSQL = sprintf("update update_nan set `c_id`=%s, `version`=%s, `memo`=%s, `pp_update`=%s, `PP_X101_CCCODE`=%s, `X301_update`=%s, `trade_code`=%s, `bug_update`=%s, `bug_cost`=%s, `X601`=%s, `hardware_end`=%s, `X101_ECFA`=%s, `DAS_MYSQL`=%s, `revision`=%s, `X101_ECFA_5`=%s, `luxury_tax_rev`=%s, `sum_sub`=%s, `X101_ECFA_PP_rev`=%s, `remark`=%s where no=%s",
					   GetSQLValueString($_POST['c_id'], "text"),
					   GetSQLValueString($version, "text"),
                       GetSQLValueString($memo, "text"),
					   GetSQLValueString($pp_update, "text"),
					   GetSQLValueString($_POST['PP_X101_CCCODE'], "text"),
					   GetSQLValueString($X301_update, "text"),
					   GetSQLValueString($trade_code, "text"),
					   GetSQLValueString($bug_update, "text"),
					   GetSQLValueString($_POST['bug_cost'], "text"),
					   GetSQLValueString($X601, "text"),
					   GetSQLValueString($hardware_end, "text"),
					   GetSQLValueString($X101_ECFA, "text"),
					   GetSQLValueString($DAS_MYSQL, "text"),
					   GetSQLValueString($revision, "text"),
					   GetSQLValueString($X101_ECFA_5, "text"),
					   GetSQLValueString($luxury_tax_rev, "text"),
					   GetSQLValueString($sum_sub, "text"),
					   GetSQLValueString($X101_ECFA_PP_rev, "text"),
					   GetSQLValueString($_POST['remark'], "text"),
					   GetSQLValueString($_GET['nid'], "text"));
	//$updateSQL=htmlspecialchars($updateSQL, ENT_QUOTES);
	//echo  $updateSQL."<BR>";
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
function dataCheck(){
	if(document.form1.c_id.value==""){
		alert("請選擇公司");
		document.form1.c_id.focus();
		return false;
	}
	if(document.form1.yyy.value==""){alert("請選擇年份");document.form1.yyy.focus();return false;}
	if(document.form1.mm.value==""){alert("請選擇月份");document.form1.mm.focus();return false;}
	if(document.form1.dd.value==""){alert("請選擇日期");document.form1.dd.focus();return false;}
}
function show(obj, id)
{
  var o=document.getElementById(id);
  if( o.style.display == 'none' )
  {
    o.style.display='';
  }
  else
  {
    o.style.display='none';
  }
}

</script>
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
 <h3>修改高雄更新資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onSubmit="return productDataCheck()">
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司名稱</label>
                                         <div class="col-sm-10"><span id="sprytextfield1">
                 <select name="c_id" id="c_id" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit"> 
										<?php  
											$sql_com="select auto_id,company_name,company_status from company_system where company_status='1' or company_status='2' order by auto_id";
											$rs_com=mysqli_query($connSQL,$sql_com);
											echo "<option value=''>請選擇公司</option>";
											while($row_com=mysqli_fetch_array($rs_com)){
										?>
											<option value="<?php echo $row_com["auto_id"];  ?>" <?php if($row_com["auto_id"]==$result["c_id"]) echo "selected";?>><?php echo $row_com["company_name"];  ?></option>
										<?php
											}
										?></select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">版本</label>
                                         <div class="col-sm-10"><span id="sprytextfield2">
										 <?php
											$version=explode(",",$result["version"]);
											$i=0;
										 ?>
                 <select name="version[]" id="version" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit" MULTIPLE>
					<!--<option value="">請選擇版本</option>-->
					<option value="Paradox" <?php while($version[$i]=="Paradox"){echo "selected";$i++;} ?>>Paradox</option>
					<option value="MySQL" <?php while($version[$i]=="MySQL"){echo "selected";$i++;} ?>>MySQL</option>
				 </select>
                </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">Memo</label>
										 <?php
											$memo=explode(",",$result["memo"]);
										 ?>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="sea" type="checkbox" id="sea" value="sea" <?php if($memo[0]=="sea") echo "checked"; ?>>海運 &nbsp;&nbsp;&nbsp;<input name="air" type="checkbox" id="air" value="air" <?php if($memo[1]=="air") echo "checked"; ?>>空運
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">PORT更新日期</label>
										 <?php
											$yyy=substr($result["pp_update"],0,3);
											$mm=substr($result["pp_update"],3,2);
											$dd=substr($result["pp_update"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield4"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy1" id="yyy1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
                                         <label  class="col-sm-2 control-label">產證PP_X101_CCCODE</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="PP_X101_CCCODE" type="text" class="form-control" id="PP_X101_CCCODE" value="<?php echo $result["PP_X101_CCCODE"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">X301檢驗更新日期</label>
										 <?php
											$yyy=substr($result["X301_update"],0,3);
											$mm=substr($result["X301_update"],3,2);
											$dd=substr($result["X301_update"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield6"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy2" id="yyy2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
										 <label  class="col-sm-2 control-label">國貿局驗證碼</label>
										 <?php
											$yyy=substr($result["trade_code"],0,3);
											$mm=substr($result["trade_code"],3,2);
											$dd=substr($result["trade_code"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield7"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy3" id="yyy3" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">百年蟲更新日期</label>
										 <?php
											$yyy=substr($result["bug_update"],0,3);
											$mm=substr($result["bug_update"],3,2);
											$dd=substr($result["bug_update"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield8"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy4" id="yyy4" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">百年蟲收費<br>X有軟硬約</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="bug_cost" type="checkbox" id="bug_cost" value="x" <?php if($result["bug_cost"]=="x")echo "checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">X601食品檢驗</label>
										 <?php
											$yyy=substr($result["X601"],0,3);
											$mm=substr($result["X601"],3,2);
											$dd=substr($result["X601"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield10"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy5" id="yyy5" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">硬體到期日</label>
										 <?php
											$yyy=substr($result["hardware_end"],0,3);
											$mm=substr($result["hardware_end"],3,2);
											$dd=substr($result["hardware_end"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield11"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy6" id="yyy6" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
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
                 </span>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">X101_ECFA</label>
										 <?php
											$yyy=substr($result["X101_ECFA"],0,3);
											$mm=substr($result["X101_ECFA"],3,2);
											$dd=substr($result["X101_ECFA"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield12"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy7" id="yyy7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm7" id="mm7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd7" id="dd7" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">DAS MySQL</label>
										 <?php
											$yyy=substr($result["DAS_MYSQL"],0,3);
											$mm=substr($result["DAS_MYSQL"],3,2);
											$dd=substr($result["DAS_MYSQL"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield13"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy8" id="yyy8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm8" id="mm8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd8" id="dd8" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">DAS MySQl改版</label>
										 <?php
											$yyy=substr($result["revision"],0,3);
											$mm=substr($result["revision"],3,2);
											$dd=substr($result["revision"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield14"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy9" id="yyy9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm9" id="mm9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd9" id="dd9" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">X101_ECFA<BR>五都更新國貿局網址</label>
										 <?php
											$yyy=substr($result["X101_ECFA_5"],0,3);
											$mm=substr($result["X101_ECFA_5"],3,2);
											$dd=substr($result["X101_ECFA_5"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield15"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy10" id="yyy10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm10" id="mm10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd10" id="dd10" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">奢侈稅改版<BR>採人工申報</label>
										 <?php
											$yyy=substr($result["luxury_tax_rev"],0,3);
											$mm=substr($result["luxury_tax_rev"],3,2);
											$dd=substr($result["luxury_tax_rev"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield16"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy11" id="yyy11" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm11" id="mm11" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd11" id="dd11" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">應加減費用改為SHOW</label>
										 <?php
											$yyy=substr($result["sum_sub"],0,3);
											$mm=substr($result["sum_sub"],3,2);
											$dd=substr($result["sum_sub"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield17"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy12" id="yyy12" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm12" id="mm12" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd12" id="dd12" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
										 <label  class="col-sm-2 control-label">X101_ECFA產證改版</label>
										 <?php
											$yyy=substr($result["X101_ECFA_PP_rev"],0,3);
											$mm=substr($result["X101_ECFA_PP_rev"],3,2);
											$dd=substr($result["X101_ECFA_PP_rev"],5,2);
										 ?>
                                         <div class="col-sm-5"><span id="sprytextfield18"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy13" id="yyy13" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+10){
							if($yyy==$j)$selected="selected";else $selected="";
							echo "<option value=$j $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm13" id="mm13" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
				 <select name="dd13" id="dd13" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
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
                                         <label  class="col-sm-2 control-label">備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield19">
                 <input name="remark" type="text" class="form-control" id="remark" value=<?php echo $result["remark"]; ?>>
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
/*
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], minChars:4, maxChars:16});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "date", {format:"yyyy-mm-dd", validateOn:["blur"], useCharacterMasking:true});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "email", {validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "url", {validateOn:["blur"], isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "phone_number", {format:"phone_custom", pattern:"(00)00000000", validateOn:["blur"], isRequired:false, useCharacterMasking:true});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "phone_number", {format:"phone_custom", pattern:"0000-000000", isRequired:false, useCharacterMasking:true});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:5, maxChars:20, validateOn:["blur"], minAlphaChars:1, minNumbers:1});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "m_passwd", {validateOn:["blur"]});
*/
</script>
<link rel="stylesheet" href="css/bootstrap-select.min.css">
<script src="css/bootstrap-select.min.js"></script>
</body>

</html>

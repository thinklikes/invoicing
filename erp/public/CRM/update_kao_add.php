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
for($i=1;$i<=4;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$application=$tmp[0];
	$voucher_2_date=$tmp[1];
	$voucher_3_date=$tmp[2];
	$voucher_ok_date=$tmp[3];

  if($application=="0000")$application="";
  if($voucher_2_date=="0000")$voucher_2_date="";
  if($voucher_3_date=="0000")$voucher_3_date="";
  if($voucher_ok_date=="0000")$voucher_ok_date="";
  
  $memo=$_POST['sea'].",".$_POST['air'];
  $version=implode($_POST['version'],",");

  $updateSQL = sprintf("insert into update_kao (`c_id`, `version`, `version_remark`, `memo`, `ocean_out`, `ocean_in`, `air_out`, `air_in`, `transport`, `X101`, `X201`, `X301`, `X301_DN`, `X401`, `X501`, `X601`, `X603`, `car`, `application`, `voucher_2_date`, `voucher_3_date`, `voucher_ok_date`) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['c_id'], "text"),
					   GetSQLValueString($version, "text"),
                       GetSQLValueString($_POST['version_remark'], "text"),
                       GetSQLValueString($memo, "text"),
                       GetSQLValueString($_POST['ocean_out'], "text"),
                       GetSQLValueString($_POST['ocean_in'], "text"),
					   GetSQLValueString($_POST['air_out'], "text"),
					   GetSQLValueString($_POST['air_in'], "text"),
					   GetSQLValueString($_POST['transport'], "text"),
					   GetSQLValueString($_POST['X101'], "text"),
					   GetSQLValueString($_POST['X201'], "text"),
					   GetSQLValueString($_POST['X301'], "text"),
					   GetSQLValueString($_POST['X301_DN'], "text"),
					   GetSQLValueString($_POST['X401'], "text"),
					   GetSQLValueString($_POST['X501'], "text"),
					   GetSQLValueString($_POST['X601'], "text"),
					   GetSQLValueString($_POST['X603'], "text"),
					   GetSQLValueString($_POST['car'], "text"),
					   GetSQLValueString($application, "text"),
					   GetSQLValueString($voucher_2_date, "text"),
					   GetSQLValueString($voucher_3_date, "text"),
					   GetSQLValueString($voucher_ok_date, "text"));
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
                                         <label  class="col-sm-2 control-label">版本</label>
                                         <div class="col-sm-10"><span id="sprytextfield2">
                 <select name="version[]" id="version" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit" MULTIPLE>
					<!--<option value="">請選擇版本</option>-->
					<option value="Paradox">Paradox</option>
					<option value="MySQL">MySQL</option>
					<option value="MySQL-DAS">MySQL-DAS</option>
					<option value="MYSQL-DAGL">MYSQL-DAGL</option>
				 </select>
                 &nbsp;&nbsp;&nbsp;版本備註
                 <input name="version_remark" type="text" id="memo_remark" ></span>
                 <br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">Memo</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="sea" type="checkbox" id="sea" value="sea">海運 &nbsp;&nbsp;&nbsp;<input name="air" type="checkbox" id="air" value="air">空運
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">海運出口</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="ocean_out" type="checkbox" id="ocean_out" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">海運進口</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="ocean_in" type="checkbox" id="ocean_in" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">空運出口</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <input name="air_out" type="checkbox" id="air_out" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">空運進口</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <input name="air_in" type="checkbox" id="air_in" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">轉運</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="transport" type="checkbox" id="transport" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X101</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="X101" type="checkbox" id="X101" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X201</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="X201" type="checkbox" id="X201" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X301</label>
                                         <div class="col-sm-10"><span id="sprytextfield11">
                 <input name="X301" type="checkbox" id="X301" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X301_DN</label>
                                         <div class="col-sm-10"><span id="sprytextfield12">
                 <input name="X301_DN" type="checkbox" id="X301_DN" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X401</label>
                                         <div class="col-sm-10"><span id="sprytextfield13">
                 <input name="X401"type="checkbox" value="1" id="X401" >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X501</label>
                                         <div class="col-sm-10"><span id="sprytextfield14">
                 <input name="X501" type="checkbox"  id="X501" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X601</label>
                                         <div class="col-sm-10"><span id="sprytextfield15">
                 <input name="X601" type="checkbox" id="X601" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">X603</label>
                                         <div class="col-sm-10"><span id="sprytextfield16">
                 <input name="X603" type="checkbox" id="X603" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">車單</label>
                                         <div class="col-sm-10"><span id="sprytextfield16">
                 <input name="car" type="checkbox" id="car" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">通知申請簽審憑證</label>
                                         <div class="col-sm-5"><span id="sprytextfield17"><?php $j=date("Y")-1911;$i=$j; ?>
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
									
									<div class="form-group">
										 <label  class="col-sm-2 control-label">簽審憑證測試日期-雙向</label>
                                         <div class="col-sm-5"><span id="sprytextfield18"><?php $j=date("Y")-1911;$i=$j; ?>
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
										 <label  class="col-sm-2 control-label">簽審憑證測試日期-三向</label>
                                         <div class="col-sm-5"><span id="sprytextfield19"><?php $j=date("Y")-1911;$i=$j; ?>
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
										 <label  class="col-sm-2 control-label">簽審憑證核准日期</label>
                                         <div class="col-sm-5"><span id="sprytextfield19"><?php $j=date("Y")-1911;$i=$j; ?>
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

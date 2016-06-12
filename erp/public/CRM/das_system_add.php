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
  $LoginRS__query = sprintf("SELECT * FROM company_system WHERE auto_id=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	for($i=1;$i<=2;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$contract_period=$tmp[0];
	$contract_buy=$tmp[1];

  if($contract_period=="0000")$contract_period="";
  if($contract_buy=="0000")$contract_buy="";
	
  $updateSQL = sprintf("insert into das (`c_id`, `version`, `contract_period`, `contract_buy`, `up_money`, `up_remark`, `server_address`, `server_amount`, `remark`, `contract_YN`, `declaration_no`) values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['c_id'], "text"),
                       GetSQLValueString($_POST['version'], "text"),
					   GetSQLValueString($contract_period, "text"),
					   GetSQLValueString($contract_buy, "text"),
                       GetSQLValueString($_POST['up_money'], "text"),
                       GetSQLValueString($_POST['up_remark'], "text"),
					   GetSQLValueString($_POST['server_address'], "text"),
					   GetSQLValueString($_POST['server_amount'], "text"),
					   GetSQLValueString($_POST['remark'], "text"),
					   GetSQLValueString($_POST['contract_YN'], "text"),
					   GetSQLValueString($_POST['declaration_no'], "text"));
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
 <h3>新增DAS資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onSubmit="return dataCheck()">
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
                 <select name="version" id="version" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">請選擇版本</option>
					<option value="MySQL豪華版DAGL">MySQL豪華版DAGL</option>";
					<option value="PARADOX">PARADOX</option>";
					<option value="MYSQL簡易版">MYSQL簡易版</option>";
					<option value="MYSQL標準版">MYSQL標準版</option>";
				 </select>
                 </span><br>
										 </div>
                                    </div>
					  
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">合約期間</label>
                                         <div class="col-sm-10"><span id="sprytextfield3"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy1" id="yyy1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+5){
							if($j==date("Y")-1911)$selected="selected"; else $selected="";
							echo "<option value='$j' $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm1" id="mm1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m==date("m"))$selected="selected"; else $selected="";
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
							if($m==date("d"))$selected="selected"; else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">購買日期</label>
                                         <div class="col-sm-10"><span id="sprytextfield4"><?php $j=date("Y")-1911;$i=$j; ?>
				 <select name="yyy2" id="yyy2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+5){
							if($j==date("Y")-1911)$selected="selected"; else $selected="";
							echo "<option value='$j' $selected>$j</option>";
							$j++;
						}
					?>
				 </select>
				 <select name="mm2" id="mm2" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">月份</option>
					<?php
						$m=1;
						while($m<=12){
							if($m==date("m"))$selected="selected"; else $selected="";
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
							if($m==date("d"))$selected="selected"; else $selected="";
							echo "<option value=$m $selected>$m</option>";
							$m++;
						}
					?>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">百年蟲升級費費用</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="up_money" type="text" class="form-control" id="up_money" >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">升級備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <textarea name="up_remark" rows="3" cols="50" class="form-control" id="up_remark"></textarea>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DAS主機位置</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <input name="server_address" type="text" class="form-control" id="server_address" >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">DAS台數</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="server_amount" type="text" class="form-control" id="server_amount" >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">有無買賣合約</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="contract_YN" type="checkbox" id="contract_YN" value="1">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">付費修改報單號碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="declaration_no" type="text" class="form-control" id="declaration_no" >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">備註說明</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <textarea name="remark" rows="3" cols="50" class="form-control" id="remark"></textarea>
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
   <input type="hidden" name="in_time" id="in_time" value="<?php echo date("H:i:s"); ?>">
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

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
  $LoginRS__query = sprintf("SELECT * FROM approval_code WHERE no=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	for($i=1;$i<=1;$i++){
		$tmp[]=$_POST["yyy$i"].str_pad($_POST["mm$i"],2,'0',STR_PAD_LEFT).str_pad($_POST["dd$i"],2,'0',STR_PAD_LEFT);
	}
	$date=$tmp[0];

  if($date=="0000")$date="";
  $app_code=$_POST["codeh"]."-".$_POST["codeb"];  
  
  $cost_YN=$_POST['cost_YN'];
  $cost=$_POST['cost'];
  $soft_type=$_POST['soft_type'];
  $machine_code=$_POST['machine_code'];
  if($_POST['hardware_con']==1){
	  $cost_YN="";
	  $cost="";
	  $soft_type="";
	  $machine_code ="";
	  $app_code="";
  }
  $updateSQL = sprintf("update approval_code set `c_id`=%s, `date`=%s, `reason`=%s, `check_result`=%s, `operator`=%s, `cost_YN`=%s, `cost`=%s, `soft_type`=%s, `machine_code`=%s, `app_code`=%s, `hardware_con`=%s where no=%s",
                        GetSQLValueString($_POST['c_id'], "text"),
					   GetSQLValueString($date, "text"),
					   GetSQLValueString($_POST['reason'], "text"),
                       GetSQLValueString($_POST['check_result'], "text"),
                       GetSQLValueString($_SESSION['LoginName'], "text"),
					   GetSQLValueString($cost_YN, "text"),
					   GetSQLValueString($cost, "text"),
					   GetSQLValueString($soft_type, "text"),
					   GetSQLValueString($machine_code, "text"),
					   GetSQLValueString($app_code, "text"),
					   GetSQLValueString($_POST['hardware_con'], "text"),
					   GetSQLValueString($_GET["nid"], "text"));
	//$updateSQL=htmlspecialchars($updateSQL, ENT_QUOTES);
	//echo  $updateSQL."<BR>";
  $Result1 = mysqli_query($connSQL,$updateSQL) or die("修改資料錯誤".mysqli_error());
  echo "<script>alert('完成');window.opener.location=window.opener.location.href;window.close();</script>";
}	
?>
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
function show( id)
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
                <a class="navbar-brand" href="index.php"><?php echo $sys_name;?></a>
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
 <h3>修改授權碼資料</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1" id="form1" onSubmit="return dataCheck()">
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">日期</label>
                                         <div class="col-sm-10"><span id="sprytextfield3"><?php $j=date("Y")-1911;$i=$j; $j=$j-6;?>
										 <?php
											$yyy=substr($result["date"],0,3);
											$mm=substr($result["date"],3,2);
											$dd=substr($result["date"],5,2);
										 ?>
				 <select name="yyy1" id="yyy1" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">年份</option>
					<?php
						while($j<$i+5){
							if($yyy==$j)$selected="selected";else $selected="";
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
                 </span><br>
										 </div>
                                    </div>
					  
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
                                         <label  class="col-sm-2 control-label">限硬體合約客戶</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="hardware_con" type="checkbox" id="hardware_con" value="1" <?php if($result["hardware_con"]==1)echo "checked"; ?> onclick="show('hiddenbox1');show('hiddenbox2');show('hiddenbox3');show('hiddenbox4');show('hiddenbox5');">
                 </span><br>
										 </div>
                                    </div>
														  																		
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">重取授權碼之原因</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="reason" type="text" class="form-control" id="reason" value="<?php echo $result["reason"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">檢查結果</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="check_result" type="text" class="form-control" id="check_result" value="<?php echo $result["check_result"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group"  id="hiddenbox1" <?php if($result["hardware_con"]==1)echo "style=\"display:none;\""; ?>>
                                         <label  class="col-sm-2 control-label">是否收費</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="cost_YN" type="checkbox" id="cost_YN" value="1" <?php if($result["cost_YN"]==1)echo "checked"; ?>>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group"  id="hiddenbox2" <?php if($result["hardware_con"]==1)echo "style=\"display:none;\""; ?>>
                                         <label  class="col-sm-2 control-label">收費金額</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <input name="cost" type="text" class="form-control" id="cost" value="<?php echo $result["cost"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group" id="hiddenbox3" <?php if($result["hardware_con"]==1)echo "style=\"display:none;\""; ?>>
                                         <label  class="col-sm-2 control-label">軟體種類</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <select name="soft_type" id="soft_type" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
					<option value="">請選擇軟體種類</option>
					<option value="EDI" <?php if($result["soft_type"]=="EDI")echo "selected"; ?>>EDI</option>
					<option value="DAS" <?php if($result["soft_type"]=="DAS")echo "selected"; ?>>DAS</option>
					<option value="DCS" <?php if($result["soft_type"]=="DCS")echo "selected"; ?>>DCS</option>
					<option value="DCST" <?php if($result["soft_type"]=="DCST")echo "selected"; ?>>DCST</option>
				 </select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group" id="hiddenbox4" <?php if($result["hardware_con"]==1)echo "style=\"display:none;\""; ?>>
                                         <label  class="col-sm-2 control-label">機器碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="machine_code" type="text" class="form-control" id="machine_code" value="<?php echo $result["machine_code"]; ?>">
                 </span><br>
										 </div>
                                    </div>

									<div class="form-group" id="hiddenbox5" <?php if($result["hardware_con"]==1)echo "style=\"display:none;\""; ?>>
                                         <label  class="col-sm-2 control-label" >授權碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">

										  <div class="col-xs-3"><?php $app_code= explode("-",$result["app_code"]); ?>
											<input type="text" name="codeh"  id="codeh" class="form-control" placeholder="前4碼" maxlength="4" onkeyup="if(this.value.length==4)document.form1.codeb.focus();" value="<?php echo $app_code[0]; ?>">
										  </div>
										  <div class="col-xs-4">
											<input type="text" name="codeb" id="codeb"  class="form-control" placeholder="後8碼" maxlength="8" onkeyup="if(this.value.length==8)document.form1.Submit2.focus();" value="<?php echo $app_code[1]; ?>">
										  </div>
                 </span><br>
										 </div>
                                    </div>
       <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
	  
         <button type="submit" class="btn btn-default" name="Submit2" id="Submit2">更新</button>
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

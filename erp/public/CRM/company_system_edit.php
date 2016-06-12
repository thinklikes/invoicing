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
  $updateSQL = sprintf('update company_system set company_name=%s,company_status=%s, mailbox=%s, company_abb=%s, company_contact=%s, company_con_tel=%s, company_con_email=%s, company_con_fax=%s, company_tel=%s, company_fax=%s, company_add=%s, VTA_NO=%s,internet_phone=%s,company_remark=%s where auto_id=%s',
                       GetSQLValueString($_POST['company_name'], "text"),
					   GetSQLValueString($_POST['company_status'], "text"),
                       GetSQLValueString($_POST['mailbox'], "text"),
                       GetSQLValueString($_POST['company_abb'], "text"),
                       GetSQLValueString($_POST['company_contact'], "text"),
                       GetSQLValueString($_POST['company_con_tel'], "text"),
					   GetSQLValueString($_POST['company_con_email'], "text"),
					   GetSQLValueString($_POST['company_con_fax'], "text"),
					   GetSQLValueString($_POST['company_tel'], "text"),
					   GetSQLValueString($_POST['company_fax'], "text"),
					   GetSQLValueString($_POST['company_add'], "text"),
					   GetSQLValueString($_POST['VTA_NO'], "text"),
					   GetSQLValueString($_POST['internet_phone'], "text"),
					   GetSQLValueString($_POST['company_remark'], "text"),
                       GetSQLValueString($auto_id, "text"));
	//$updateSQL=htmlspecialchars($updateSQL, ENT_QUOTES);
	//echo  $updateSQL."<BR>";
  $Result1 = mysqli_query($connSQL,$updateSQL) or die("修改資料錯誤".mysqli_error());
  
  //把客戶狀態與客戶編號寫進cust_purchase
  
  $sql_up=sprintf("update cust_purchase set company_status=%s where c_id=%s",
					GetSQLValueString($_POST['company_status'], "text"),
					GetSQLValueString($auto_id, "text"));//echo $sql_up;
  $Result2 = mysqli_query($connSQL,$sql_up) or die("修改資料錯誤2".mysqli_error());
  echo "<script>alert('完成');window.opener.location=window.opener.location.href;window.close();</script>";
}	
?>
<script>
function productDataCheck(){
	if(document.form1.company_name.value==""){
		alert("公司名稱不得為空白");
		document.form1.company_name.focus();
		return false;
	}
	if(document.form1.mailbox.value==""){
		alert("郵箱稱不得為空白");
		document.form1.mailbox.focus();
		return false;
	}
	if(document.form1.company_abb.value==""){
		alert("公司簡增稱不得為空白");
		document.form1.company_abb.focus();
		return false;
	}
	if(document.form1.company_tel.value==""){
		alert("公司電話不得為空白");
		document.form1.company_tel.focus();
		return false;
	}
	if(document.form1.company_fax.value==""){
		alert("公司傳真不得為空白");
		document.form1.company_fax.focus();
		return false;
	}
	if(document.form1.company_add.value==""){
		alert("公司地址不得為空白");
		document.form1.company_add.focus();
		return false;
	}
	if(document.form1.VTA_NO.value==""){
		alert("統一編號不得為空白");
		document.form1.VTA_NO.focus();
		return false;
	}
	if(document.form1.company_contact.value==""){
		alert("聯絡人不得為空白");
		document.form1.company_contact.focus();
		return false;
	}
	if(document.form1.company_con_tel.value==""){
		alert("聯絡人電話不得為空白");
		document.form1.company_con_tel.focus();
		return false;
	}
	if(document.form1.company_con_email.value==""){
		alert("聯絡人信箱不得為空白");
		document.form1.company_con_email.focus();
		return false;
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
 <h3>修改廠商資料</h3>
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
                                         <div class="col-sm-10"><span id="sprytextfield2">
                 <input name="company_name" type="text" class="form-control" id="company_name" value="<?php  echo $result["company_name"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">郵箱</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="mailbox" type="text" class="form-control" id="mailbox" value="<?php  echo $result["mailbox"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司簡稱</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="company_abb" type="text" class="form-control" id="company_abb" value="<?php  echo $result["company_abb"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司電話</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="company_tel" type="text" class="form-control" id="company_tel" value="<?php  echo $result["company_tel"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司傳真</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <input name="company_fax" type="text" class="form-control" id="company_fax" value="<?php  echo $result["company_fax"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">網路電話號碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield14">
                 <input name="internet_phone" type="text" class="form-control" id="internet_phone" value="<?php  echo $result["internet_phone"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">公司地址</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <input name="company_add" type="text" class="form-control" id="company_add" value="<?php  echo $result["company_add"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">統一編號</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="VTA_NO" type="text" class="form-control" id="VTA_NO" value="<?php  echo $result["VTA_NO"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">聯絡人</label>
                                         <div class="col-sm-10"><span id="sprytextfield9">
                 <input name="company_contact" type="text" class="form-control" id="company_contact" value="<?php  echo $result["company_contact"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">聯絡人電話</label>
                                         <div class="col-sm-10"><span id="sprytextfield10">
                 <input name="company_con_tel" type="text" class="form-control" id="company_con_tel" value="<?php  echo $result["company_con_tel"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">聯絡人信箱</label>
                                         <div class="col-sm-10"><span id="sprytextfield11">
                 <input name="company_con_email" type="text" class="form-control" id="company_con_email" value="<?php  echo $result["company_con_email"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">聯絡人傳真</label>
                                         <div class="col-sm-10"><span id="sprytextfield12">
                 <input name="company_con_fax" type="text" class="form-control" id="company_con_fax" value="<?php  echo $result["company_con_fax"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">客戶狀態</label>
                                         <div class="col-sm-10"><span id="sprytextfield13">
				 <select name="company_status" id="company_status" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
				 <option value="1" <?php  if($result["company_status"]==1) echo "selected"; ?>>購買</option>
				 <option value="2" <?php  if($result["company_status"]==2) echo "selected"; ?>>租用</option>
				 <option value="3" <?php  if($result["company_status"]==3) echo "selected"; ?>>不使用</option></select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield14">
				<textarea name="company_remark" rows="4" cols="50" class="form-control" id="company_remark"><?php  echo $result["company_remark"]; ?></textarea>
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

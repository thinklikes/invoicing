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
  $LoginRS__query = sprintf("SELECT * FROM users WHERE id=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $created_at=$_POST["yyy1"]."-".str_pad($_POST["mm1"],2,'0',STR_PAD_LEFT)."-".str_pad($_POST["dd1"],2,'0',STR_PAD_LEFT);
 
  if($_POST['status']=="")
	  $str=",status='1',out_at= ''";
  else{
	  $year=date("Y")-1911;
	  $out_date=$year.date("-m-d");
	  $str=",status='0',out_at= '$out_date'";
  }
	
  $updateSQL = sprintf('update users set `name`=%s, `emp_name`=%s, `email`=%s, `created_at`=%s, `leavl`=%s,`remark`=%s '.$str.' where id=%s',
                       GetSQLValueString($_POST['name'], "text"),
					   GetSQLValueString($_POST['emp_name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($created_at, "text"),
                       GetSQLValueString($_POST['leavl'], "text"),
                       GetSQLValueString($_POST['remark'], "text"),
                       GetSQLValueString($auto_id, "text"));
	//$updateSQL=htmlspecialchars($updateSQL, ENT_QUOTES);
	//echo  $updateSQL."<BR>";
  $Result1 = mysqli_query($connSQL,$updateSQL) or die("修改資料錯誤".mysqli_error());
  echo "<script>alert('完成');window.opener.location=window.opener.location.href;window.close();</script>";
}	
?>
<script>
function productDataCheck(){
	if(document.form1.emp_name.value==""){
		alert("員工名稱不得為空白");
		document.form1.emp_name.focus();
		return false;
	}
	if(document.form1.name.value==""){
		alert("員工帳號不得為空白");
		document.form1.name.focus();
		return false;
	}
	if(document.form1.pswd.value==""){
		alert("員工密碼不得為空白");
		document.form1.pswd.focus();
		return false;
	}
	if(document.form1.email.value==""){
		alert("員工信箱不得為空白");
		document.form1.email.focus();
		return false;
	}
	if(document.form1.yyy1.value==""){
		alert("年份不得為空白");
		document.form1.emp_name.focus();
		return false;
	}
	if(document.form1.mm1.value==""){
		alert("月份不得為空白");
		document.form1.emp_name.focus();
		return false;
	}
	if(document.form1.dd1.value==""){
		alert("日期不得為空白");
		document.form1.emp_name.focus();
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
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">員工姓名</label>
                                         <div class="col-sm-10"><span id="sprytextfield2">
                 <input name="emp_name" type="text" class="form-control" id="emp_name" value="<?php echo $result["emp_name"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">員工帳號</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input name="name" type="text" class="form-control" id="name" value="<?php echo $result["name"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<!--<div class="form-group">
                                         <label  class="col-sm-2 control-label">員工密碼</label>
                                         <div class="col-sm-10"><span id="sprytextfield8">
                 <input name="pswd" type="password" class="form-control" id="psword" >
                 </span><br>
										 </div>
                                    </div>-->
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">Email</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="email" type="text" class="form-control" id="email" value="<?php echo $result["email"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">到職日</label>
                                         <div class="col-sm-10"><span id="sprytextfield5"><?php $j=date("Y")-1911;$i=$j; ?>
										 <?php
											$yyy=substr($result["created_at"],0,3);
											$mm=substr($result["created_at"],4,2);
											$dd=substr($result["created_at"],7,2);
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
                                         <label  class="col-sm-2 control-label">離職</label>
                                         <div class="col-sm-10"><span id="sprytextfield3">
                 <input type="checkbox" name="status" id="status"  <?php if($result["status"]==0) {echo "checked "; echo 'value="0"';} else{echo 'value="1"';}?> >
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">權限</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
				 <select name="leavl" id="leavl" class="selectpicker" data-show-subtext="true" data-live-search="true" data-width="fit">
				 <option value="0" <?php if($result["leavl"]==0)echo "selected"; ?>>一般使用者</option>
				 <option value="1" <?php if($result["leavl"]==1)echo "selected"; ?>>管理者</option></select>
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">備註</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
				<textarea name="remark" rows="4" cols="50" class="form-control" id="remark"><?php echo $result["remark"]; ?></textarea>
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

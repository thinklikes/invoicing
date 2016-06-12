<?php require_once('Connections/connSQL.php'); ?>
<?php require_once('checkuser.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if($_SESSION['MM_Username']!=""){
	
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($connSQL,$theValue) : mysqli_escape_string($connSQL,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
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
  $LoginRS__query = sprintf("SELECT * FROM pray WHERE auto_id=%s", GetSQLValueString($auto_id, "text"));
  $LoginRS=mysqli_query($connSQL,$LoginRS__query) or die(mysqli_error());
  $result=mysqli_fetch_array($LoginRS);
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
		$auto_id = $_POST["auto_id"];
		$auto_pray = $_POST["auto_pray"];
		
		$pray_nickname = $_POST["pray_nickname"];
		$pray_family = $_POST["pray_family"];
		$pray_name = $_POST["pray_name"];
		//$customer_time=date("Y-m-d G:i:s");
		$pray_gender = $_POST["pray_gender"];
		$pray_birthday = $_POST["pray_birthday"];
		$pray_phone = $_POST["pray_phone"];
		$pray_address = $_POST["pray_address"];
		$pray_relation = $_POST["pray_relation"];
		$pray_id=$_POST["pray_id"];
		
		
		$nickname_1 = $_POST["nickname_1"];
		$nickname_2 = $_POST["nickname_2"];
		$nickname_3 = $_POST["nickname_3"];
		$nickname_4 = $_POST["nickname_4"];
		$nickname_5 = $_POST["nickname_5"];
		
		$family_1 = $_POST["family_1"];		
		$family_2 = $_POST["family_2"];	
		$family_3 = $_POST["family_3"];	
		$family_4 = $_POST["family_4"];	
		$family_5 = $_POST["family_5"];	
	
	if($_POST["family_1"]!="")//第1位眷屬
	{	$sql = "INSERT INTO pray(auto_id,pray_id,pray_nickname,pray_family,pray_name,pray_phone,pray_address,pray_relation)
		VALUE('$auto_id','$pray_id','$nickname_1','$family_1','$pray_name','$pray_phone','$pray_address','$pray_relation')";
		$sql2 = "INSERT INTO  family_dependant(fd_auto_id,fd_number,fd_nickname,fd_family,fd_name) 
		VALUE('$auto_id','$pray_phone','$nickname_1','$family_1','$family_1')";
		$sql3 = "INSERT INTO  tang(tang_auto_id,tang_number,tang_name) 
		VALUE('$auto_id','$pray_phone','$family_1')";	
		$sql4 = "INSERT INTO  light(light_auto_id,light_number,light_name)
		VALUE('$auto_id','$pray_phone','$family_1')";
		//echo $sql."<br>".$sql2."<br>".$sql3."<br>".$sql4;exit;
		mysqli_query($connSQL,$sql);		
		mysqli_query($connSQL,$sql2);		
		mysqli_query($connSQL,$sql3);		
		mysqli_query($connSQL,$sql4);
	}	

		if($_POST["family_2"]!="")//第2位眷屬
	{	$sql = "INSERT INTO pray(auto_id,pray_id,pray_nickname,pray_family,pray_name,pray_phone,pray_address,pray_relation)
		VALUE('$auto_id','$pray_id','$nickname_2','$family_2','$pray_name','$pray_phone','$pray_address','$pray_relation')";
		$sql2 = "INSERT INTO  family_dependant(fd_auto_id,fd_number,fd_nickname,fd_family,fd_name) 
		VALUE('$auto_id','$pray_phone','$nickname_2','$family_2','$family_2')";
		$sql3 = "INSERT INTO  tang(tang_auto_id,tang_number,tang_name) 
		VALUE('$auto_id','$pray_phone','$family_2')";	
		$sql4 = "INSERT INTO  light(light_auto_id,light_number,light_name)
		VALUE('$auto_id','$pray_phone','$family_2')";
		mysqli_query($connSQL,$sql);		
		mysqli_query($connSQL,$sql2);		
		mysqli_query($connSQL,$sql3);		
		mysqli_query($connSQL,$sql4);
	}	

		if($_POST["family_3"]!="")//第3位眷屬
	{	$sql = "INSERT INTO pray(auto_id,pray_id,pray_nickname,pray_family,pray_name,pray_phone,pray_address,pray_relation)
		VALUE('$auto_id','$pray_id','$nickname_3','$family_3','$pray_name','$pray_phone','$pray_address','$pray_relation')";
		$sql2 = "INSERT INTO  family_dependant(fd_auto_id,fd_number,fd_nickname,fd_family,fd_name) 
		VALUE('$auto_id','$pray_phone','$nickname_3','$family_3','$family_3')";
		$sql3 = "INSERT INTO  tang(tang_auto_id,tang_number,tang_name) 
		VALUE('$auto_id','$pray_phone','$family_3')";	
		$sql4 = "INSERT INTO  light(light_auto_id,light_number,light_name)
		VALUE('$auto_id','$pray_phone','$family_3')";
		mysqli_query($connSQL,$sql);		
		mysqli_query($connSQL,$sql2);		
		mysqli_query($connSQL,$sql3);		
		mysqli_query($connSQL,$sql4);
	}	

		if($_POST["family_4"]!="")//第4位眷屬
	{	$sql = "INSERT INTO pray(auto_id,pray_id,pray_nickname,pray_family,pray_name,pray_phone,pray_address,pray_relation)
		VALUE('$auto_id','$pray_id','$nickname_4','$family_4','$pray_name','$pray_phone','$pray_address','$pray_relation')";
		$sql2 = "INSERT INTO  family_dependant(fd_auto_id,fd_number,fd_nickname,fd_family,fd_name) 
		VALUE('$auto_id','$pray_phone','$nickname_4','$family_4','$family_4')";
		$sql3 = "INSERT INTO  tang(tang_auto_id,tang_number,tang_name) 
		VALUE('$auto_id','$pray_phone','$family_4')";	
		$sql4 = "INSERT INTO  light(light_auto_id,light_number,light_name)
		VALUE('$auto_id','$pray_phone','$family_4')";
		mysqli_query($connSQL,$sql);		
		mysqli_query($connSQL,$sql2);		
		mysqli_query($connSQL,$sql3);		
		mysqli_query($connSQL,$sql4);
	}	

		if($_POST["family_5"]!="")//第5位眷屬
	{	$sql = "INSERT INTO pray(auto_id,pray_id,pray_nickname,pray_family,pray_name,pray_phone,pray_address,pray_relation)
		VALUE('$auto_id','$pray_id','$nickname_5','$family_5','$pray_name','$pray_phone','$pray_address','$pray_relation')";
		$sql2 = "INSERT INTO  family_dependant(fd_auto_id,fd_number,fd_nickname,fd_family,fd_name) 
		VALUE('$auto_id','$pray_phone','$nickname_5','$family_5','$family_5')";
		$sql3 = "INSERT INTO  tang(tang_auto_id,tang_number,tang_name) 
		VALUE('$auto_id','$pray_phone','$family_5')";	
		$sql4 = "INSERT INTO  light(light_auto_id,light_number,light_name)
		VALUE('$auto_id','$pray_phone','$family_5')";
		mysqli_query($connSQL,$sql);		
		mysqli_query($connSQL,$sql2);		
		mysqli_query($connSQL,$sql3);		
		mysqli_query($connSQL,$sql4);
	}	

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

    <title>廟宇管理系統</title>

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
                <a class="navbar-brand" href="">廟宇管理系統</a>
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
 <h3>新增眷屬</h3>
 </div>
          <div class="panel-body">

                      <form class="form-horizontal" role="form" action="<?php echo $editFormAction; ?>" METHOD="POST" >
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">編號</label>
                                         <div class="col-sm-10"><span id="sprytextfield1">
                 <input name="pray_id" type="text" class="form-control" id="pray_id" value="<?php  echo $result["pray_id"]; ?>">
				 <input name="pray_relation" type="hidden" value="<?echo $pray_relation;?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">姓名</label>
                                         <div class="col-sm-10"><span id="sprytextfield2">
                 <input name="pray_name" type="text" class="form-control" id="pray_name" value="<?php  echo $result["pray_name"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">出生年月日</label>
                                         <div class="col-sm-10"><span id="sprytextfield4">
                 <input name="pray_birthday" type="text" class="form-control" id="pray_birthday" value="<?php  echo $result["pray_birthday"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">電話</label>
                                         <div class="col-sm-10"><span id="sprytextfield5">
                 <input name="pray_phone" type="text" class="form-control" id="pray_phone" value="<?php  echo $result["pray_phone"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group">
                                         <label  class="col-sm-2 control-label">地址</label>
                                         <div class="col-sm-10"><span id="sprytextfield6">
                 <input name="pray_address" type="text" class="form-control" id="pray_address" value="<?php  echo $result["pray_address"]; ?>">
                 </span><br>
										 </div>
                                    </div>
									
									<div class="form-group" id="col1">
                                         <label  class="col-sm-2 control-label">眷屬</label>
                                         <div class="col-sm-10"><span id="sprytextfield7">
                 <input name="family_1" type="text" class="form-control" id="family_1" value="新增眷屬資料" onfocus="cleartext(this)" onblur="resettext(this)">
                 </span><br>
				 <a href="javascript:" onclick="addField()">新增眷屬欄位</a>
				 <a href="javascript:" onclick="delField()">刪除眷屬欄位</a>
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
 <?php
}
else{
	unset($_SESSION['MM_Username']);
    //setcookie("remuser", '', time()); //去除使用者名稱的 Cookie 值
    header("Location:login.php");
    exit;
}
mysqli_free_result($LoginRS);
?>                  

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
<?php
	for($i=1;$i<=5;$i++){
		echo"
			function resettext(family_$i){
				if(family_$i.value == ''){
					family_$i.value = family_$i.defaultValue;
					family_$i.className ='form-control';   
				}
			}
			function cleartext (family_$i){ 
				family_$i.value ='';
				d.className ='';   
			}";
	}
?>


var countMin = 1; 
var countMax = 5;
var commonName = "family_";
var count = countMin; 
function addField() { 
	if(count == countMax) 
		alert("最多"+countMax+"個眷屬欄位"); 
	else	 
		document.getElementById("sprytextfield7").innerHTML +=  '<input type="text"  class="form-control"  name="' + commonName + (++count) + '" value="新增眷屬資料" onfocus="cleartext(this)" onblur="resettext(this)">';	 
}
function delField() {
	if (count > countMin) {
		var fs = document.getElementById("sprytextfield7"); 
		fs.removeChild(fs.lastChild);
		count--;
	} else {
		alert("無新增眷屬欄位可以刪除");
	}	
}
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
</body>

</html>

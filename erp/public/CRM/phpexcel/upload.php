<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connSQL = "localhost";
$database_connSQL = "taiwan";
$username_connSQL = "taiwan";
$password_connSQL = "taiwan123";
$connSQL = mysqli_connect($hostname_connSQL, $username_connSQL, $password_connSQL,$database_connSQL) or trigger_error(mysqli_connect_error(),E_USER_ERROR);


require_once('Excel/reader.php');
	
   if($_POST){

if ($_FILES["file"]["error"] > 0){
　echo "Error: " . $_FILES["file"]["error"];
}else{
　echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
　echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
　echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
　echo "暫存名稱: " . $_FILES["file"]["tmp_name"];

　move_uploaded_file($_FILES["file"]["tmp_name"],"/".$_FILES["file"]["name"]);
}

		
		$uploadExcel = $_FILES['file']['tmp_name'];
		$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('UTF-8');
		$data->read($uploadExcel);
		
		$readData =array();

		//讀取檔案中的每一格，並把它存至陣列
		for ($i = 1; $i <= $data->sheets[0]['numRows']; $i  ) { 
			for ($j = 1; $j <= $data->sheets[0]['numCols']; $j  ) {
				$readData[$i][$j] = $data->sheets[0]['cells'][$i][$j];
			}
		}
		sava_data($readData);
   }
		
    function sava_data($readData){
		$count =0;
		foreach( $readData as $key => $tmp){
			/*-----開始匯入資料-----*/
			if( $key==1 ){
				$sql_ex = "INSERT INTO `test`($tmp[1],$tmp[2]) "; //資料庫的table欄位要記得更改.
				continue;
			}else
				$sql = $sql_ex . " VALUES('$tmp[1]','$tmp[2]')";
			$result = mysqli_query($sql) or die("無法送出" . mysqli_error( ));
			$count  ;
		} 
		echo "<script>alert('共加入".$count."筆資料');</script>";
    }
?>
<html>
<body>
<?php
/*
if ($_FILES["file"]["error"] > 0){
　echo "Error: " . $_FILES["file"]["error"];
}else{
echo "檔案名稱: " . $_FILES["file"]["name"]."<br/>";
echo "檔案類型: " . $_FILES["file"]["type"]."<br/>";
echo "檔案大小: " . ($_FILES["file"]["size"] / 1024)." Kb<br />";
echo "暫存名稱: " . $_FILES["file"]["tmp_name"];
}
*/
?>
<form enctype="multipart/form-data" method="POST" action="">
<label>選擇Excel資料表</label>
<input name="file" type="file" id="file" size="50" />
<input name="tt" type="hidden" value="2" />
<input type="submit" value="匯入資料"/> 
</form>
</body>
</html>
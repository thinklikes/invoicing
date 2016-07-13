
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
	<!--===============sweetalert===============-->
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="css/dist/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="css/dist/sweetalert.css">
	<!--===============sweetalert===============-->
	<script>
/*
$(this).attr('tt').onclick = function(){
	swal("Here's a message!");
};
*/
$(this).attr('lo').onclick = function(){
	swal({
		title: "確定是否要登出?",
		//text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: '確定',
		cancelButtonText: '取消',
		closeOnConfirm: false
	},
	function(){
		$(window.location).attr('href', '<?php echo $_SERVER["PHP_SELF"]."?doLogout=true";?>');
	});
};
<?php
for($j=1;$j<=$i;$j++){
?>
$(this).attr('del<?php echo $j; ?>').onclick = function(){
	swal({
		title: "是否要刪除?",
		//text: "You will not be able to recover this imaginary file!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: '確定',
		cancelButtonText: '取消',
		closeOnConfirm: false
	},
	function(){
		$(window.location).attr('href', '<?php echo $_SERVER["PHP_SELF"]."?deliid=$auto_id&pageNum_RecMember=".$_GET['pageNum_RecMember']."&totalRows_RecMember=".$_GET['totalRows_RecMember'];?>');
	});
};
<?php
}
?>
</script>
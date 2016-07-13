  <html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
  <title>SweetAlert</title>

  <link rel="stylesheet" href="example/example.css">
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

  <!-- This is what you need -->
  <script src="dist/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="dist/sweetalert.css">
  <!--.......................-->

  </head>
<body>
<ul class="examples">
<li class="message">
		<div class="ui">
			<p>A basic message</p>
			<a id="tt">Try me!</a>
		</div>
	</li>
	<li class="warning confirm">
		<div class="ui" >

			<button id="d1">Try me!</button>
		</div>

	</li>
</ul>

<script>
$(this).attr('tt').onclick = function(){
	swal("Here's a message!");
};
$(this).attr('d1').onclick = function(){
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
		$(window.location).attr('href', 'http://www.google.com.tw');
	});
};
</script>
</body>
</html>

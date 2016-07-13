  <link rel="stylesheet" href="example/example.css">
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

  <!-- This is what you need -->
  <script src="dist/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="dist/sweetalert.css">
  <!--.......................-->
<?php
$options = [
    'cost' => 10,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
];
$hash=password_hash("3700050", PASSWORD_DEFAULT);
echo $hash;
echo "<br/>".strlen($hash)."<BR>";

if (password_verify("3700050", $hash)) {
echo "密碼正確";
} else {
echo "密碼錯誤";
}
?>
<button>Show error message</button>

	<h5>Code:</h5>
	<pre><span class="attr">alert</span>(<span class="str">"Oops... Something went wrong!"</span>);

	</pre>
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
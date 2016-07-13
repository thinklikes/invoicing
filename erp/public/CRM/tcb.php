<?php
java_set_library_path("file:D:/Ming/java/phptest.jar");

$myj=new Java("phptest");

echo "測試結果(呼叫物件test方法):<B>".$myj->test("第一個JAVA與PHP!").$myj->foo="這是一個字串";
echo "你設定的字串為(foo):<B>".$myj->foo."</b><br>";
?>
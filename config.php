<?php
namespace spacet\wechat;

function autoload ($class)
{
	$class = explode('\\', $class);
	$file_name = end($class) . ".class.php";
	require $file_name;
}
spl_autoload_register(__NAMESPACE__ . '\autoload');
define(APPID, "wxd790c4c47f8c1eba");
define(APPSECRET, "6c869828b9e712eb2005f589ad81a056");
define(TOKEN, "nfZpV7hz6ZcWSnAB");
?>
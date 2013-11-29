<?php
namespace spacet\wechat;

function __autoload ($class)
{
	$file_name = "./" . $class . ".class.php";
	require $file_name;
}
const APPID = "wxd790c4c47f8c1eba";
const APPSECRET = "6c869828b9e712eb2005f589ad81a056";
const TOKEN = "nfZpV7hz6ZcWSnAB";
?>
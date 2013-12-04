<?php
namespace spacet\wechat;
require ("config.php");
$cmd = array();
$cmd['activity'] = array('type' => 'text', 
'callback' => array('func' => '\activity'), 'body' => 'activity');
$subcmd = array();
$subcmd[] = array('type' => 'text', 'pattern' => '[0-9]+', 
'callback' => array('function' => '\cmd1'));

$subcmd[] = array('type' => 'text', 'pattern' => '[0-9]+', 
'callback' => array('function' => '\cmd2'));

$cmd['activity']['sub'] = $subcmd;

$command = new Command();
$command->registerCmd($cmd);



?>
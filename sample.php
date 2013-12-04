<?php
namespace spacet\wechat;
require ("config.php");
require ("Callback.class.php");
$cmd = array();
$cmd['activity'] = array('type' => 'text', 
'callback' => array('func' => 'test\Callback::activity'), 'body' => 'activity');
$subcmd = array();
$subcmd[] = array('type' => 'text', 'pattern' => '/^[0-9]+$/', 
'callback' => array('func' => 'test\Callback::cmd1'));

$subcmd[] = array('type' => 'text', 'pattern' => '/^[0-9]+$/', 
'callback' => array('func' => 'test\Callback::cmd2'));

$cmd['activity']['sub'] = $subcmd;

$command = new Command();
$command->registerCmd($cmd);

$openId = 'oU9kbt87yRMYzW5nIdr9-JHs4i-M';
//$result = $command->parseUserInput(array('body' => 'activity', 'type' => 'text'), $openId);
$result = $command->parseUserInput(array('body' => '11', 'type' => 'text'), $openId);


var_dump($result);

?>

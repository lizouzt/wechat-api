<?php
namespace test;
class Callback {

public static function activity($openId, $input){

        return array('status' => 1, 'output' => 'activity, ok');
}

public static function cmd1($openId, $input){
	return array('status' => 1, 'output' => 'cmd1, ok');
}

public static function cmd2($openId, $input){
	return array('status' => 1, 'output' => 'cmd2, ok');
}
}
?>

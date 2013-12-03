<?php
namespace spacet\wechat;
class Command
{
	private $_cmd;
	private $_subcmd;

	public function __construct ()
	{
		$this->_cmd = array();
		$key = "activity";
		$cmd = array('type' => 'text', 
		'callback' => array('func' => 'test', 'params' => array()), 
		'body' => 'activity', 'sub' => array(''));
	}

	public function registerCmd ($cmd, $subcmd)
	{
		$this->_cmd[$cmd] = $subcmd;
	}

	public function parseUserInput ($cmd, $openId)
	{
		$last_input = $this->_getLastInputByUser($openId);
	}

	private function _getLastInputByUser ($openId)
	{
		$db = new MysqliDb("localhost", "root", "modernmedia", "wechat", 3306);
		$params = array($openId);
		$result = $db->rawQuery(
		"SELECT * FROM wechat_input_log WHERE log_openId = ? ORDER BY log_id DESC LIMIT 1", 
		$params);
		return $result;
	}

	public function addUserInput ($log_cmd, $log_subcmd, $log_openId, 
	$log_content)
	{
		$db = new MysqliDb("localhost", "root", "modernmedia", "wechat", 3306);
		$insertData = array('log_cmd' => $log_cmd, 'log_subcmd' => $log_subcmd, 
		'log_openId' => $log_openId, 'log_content' => $log_content);
		if ($db->insert('wechat_input_log', $insertData))
			echo 'success!';
	}
}
?>
<?php
namespace spacet\wechat;
require ("config.php");
require ("Utilities.class.php");
class WeChat
{
	private $_api;
	private $_errcode;
	private $_errmsg;
	public function __construct ()
	{}
	public function getAccessToken ()
	{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
		 APPID . "&secret=" . APPSECRET;
		return $this->_sendRequest($url);
	}
	private function _sendRequest ($url)
	{
		$result = file_get_contents($url);
		$_result = $this->_parseResult($result);
		return $_result;
	}
	private function _parseResult ($result)
	{
		$_result = json_decode($result);
		if (isset($_result->errcode)) {
			$this->_errcode = $_result->errcode;
			$this->_errmsg = $_result->errmsg;
		} else {
			return $_result;
		}
		return false;
	}
}
?>
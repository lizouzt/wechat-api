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
	
	public function getMsg($data){
	    $msg = $this->_parseMsg($data);
	    return $msg;
	}

	public function getTextMsg ()
	{}

	public function getImageMsg ()
	{}

	public function getVoiceMsg ()
	{}

	public function getVideoMsg ()
	{}

	public function getLocationMsg ()
	{}

	public function getUserInfo($openId){
	    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$msg['FromUserName'];
	    return $this->_sendRequest($url);
	}
	
	public function checkSignature ($signature, $timestamp, $nonce)
	{
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}

	private function _parseMsg ($data)
	{
		$_msg = array();
		$_data = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
		if (is_object($_data)) {
			foreach ($_data as $v) {
				$name = $v->getName();
				$value = $_data->$name;
				if ($name == "ToUserName") {
					$_msg['ToUserName'] = $value;
				} elseif ($name == "FromUserName") {
					$_msg['FromUserName'] = $value;
				} elseif ($name == "CreateTime") {
					$_msg['CreateTime'] = $value;
				} elseif ($name == "MsgType") {
					$_msg['MsgType'] = $value;
				} elseif ($name == "MsgId") {
					$_msg['MsgId'] = $value;
				} elseif ($name == "Content") {
					$_msg['Content'] = $value;
				} elseif ($name == "PicUrl") {
					$_msg['PicUrl'] = $value;
				} elseif ($name == "MediaId") {
					$_msg['MediaId'] = $value;
				} elseif ($name == "Format") {
					$_msg['Format'] = $value;
				} elseif ($name == "ThumbMediaId") {
					$_msg['ThumbMediaId'] = $value;
				} elseif ($name == "Location_X") {
					$_msg['Location_X'] = $value;
				} elseif ($name == "Location_Y") {
					$_msg['Location_Y'] = $value;
				} elseif ($name == "Scale") {
					$_msg['Scale'] = $value;
				} elseif ($name == "Label") {
					$_msg['Label'] = $value;
				}
			}
		}
		return (count($_msg) == 0) ? false : $_msg;
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

	public function getError ()
	{
		return array('errcode' => $this->_errcode, 'errmsg' => $this->_errmsg);
	}
}
?>
<?php
/**
 * 
 * wechat-api
 * @author tangjinwei
 * @version 0.1
 *
 */
namespace spacet\wechat;
require ("config.php");
class WeChat
{
	private $_api;
	private $_errcode;
	private $_errmsg;
	public $utilities;

	public function __construct ()
	{
		$this->utilities = new Utilities();
	}

	public function getAccessToken ()
	{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" .
		 APPID . "&secret=" . APPSECRET;
		return $this->_sendRequest($url);
	}

	public function getMsg ($data)
	{
		$msg = $this->_parseMsg($data);
//		if ($msg['MsgType'] == 'text') {
//			echo "";
//		} elseif ($msg['MsgType'] == 'image') {
//			echo "";
//		} elseif ($msg['MsgType'] == 'voice') {
//			echo "";
//		} elseif ($msg['MsgType'] == 'video') {
//			echo "";
//		} elseif ($msg['MsgType'] == 'location') {
//			echo "";
//		} elseif ($msg['MsgType'] == 'link') {
//			echo "";
//		}
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

	public function sendTextMsg ($toUserName, $fromUserName, $content)
	{
		$text = "<xml>
<ToUserName><![CDATA[" . $toUserName . "]]></ToUserName>
<FromUserName><![CDATA[" . $fromUserName . "]]></FromUserName>
<CreateTime>" . time() . "</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[" . $content . "]]></Content>
</xml>";
		return $text;
	}

	public function getUserInfo ($accessToken, $openId)
	{
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" .
		 $accessToken . "&openid=" . $openId;
		return $this->_sendRequest($url);
	}

	public function sendCustomMsg ($accessToken, $openId, $content)
	{
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" .
		 $accessToken;
		$data = "{
    \"touser\":\"" . $openId . "\",
    \"msgtype\":\"text\",
    \"text\":
    {
         \"content\":\"" . $content . "\"
    }
}";
		$result = $this->utilities->post($url, $data);
		return $result;
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
		$_data = simplexml_load_string($data, 'SimpleXMLElement', 
		LIBXML_NOCDATA);
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
				} elseif ($name == "Event") {
					$_msg['Event'] = $value;
				}
			}
		}
		return (count($_msg) == 0) ? false : $_msg;
	}

	private function _sendRequest ($url)
	{
		$result = $this->utilities->get($url);
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
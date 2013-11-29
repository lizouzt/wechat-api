<?php
namespace spacet\wechat;
class Utilities
{

	public function post ($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_exec($ch);
		curl_close($ch);
		if ($result) {
			return $result;
		}
		return false;
	}
}
?>
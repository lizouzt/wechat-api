<?php
namespace spacet\wechat;
require ("config.php");
require ("Utilities.class.php");
class WeChat
{
    
    private $_api;
    
    public function __construct ()
    {
        
    }
    
    public function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;
        $result = get_file_contents($url);
        var_dump($result);
    }
}
?>
<?php

function randomString($length){
	// 密码字符集，可任意添加你需要的字符
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$password = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		// 这里提供两种字符获取方式
		// 第一种是使用 substr 截取$chars中的任意一位字符；
		// 第二种是取字符数组 $chars 的任意元素
		// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
		$password.= $chars[ mt_rand(0, strlen($chars) - 1) ];
	}
	return $password;
}
$appKey='30ee71a80ef355fc13f6b35cb2f28e8b';
$Nonce=randomString(128);
$CurTime=time();
$CheckSum=sha1('8b0523945542'.$Nonce.$CurTime);
$headers = array(
		'AppKey:'.$appKey,
        'Nonce:'.$Nonce,
        'CurTime:'.$CurTime,
        'CheckSum:'.$CheckSum,
        'Accept:*/*'
);
$param=array(
		'accid'=>$_REQUEST['accid']
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, 'https://api.netease.im/nimserver/user/refreshToken.action' );//地址
curl_setopt(  $ch, CURLOPT_HTTPHEADER  , $headers);
curl_setopt ( $ch, CURLOPT_POST, 1 );//请求方式为post
curl_setopt ( $ch, CURLOPT_HEADER, 0 );//不打印header信息
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );//返回结果转成字符串
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );//post传输的数据。
$return = curl_exec ( $ch );
curl_close ( $ch );
// 指定允许其他域名访问  
header('Access-Control-Allow-Origin:*');  
echo $return;
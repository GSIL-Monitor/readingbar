<?php

function randomString($length){
	// �����ַ������������������Ҫ���ַ�
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$password = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		// �����ṩ�����ַ���ȡ��ʽ
		// ��һ����ʹ�� substr ��ȡ$chars�е�����һλ�ַ���
		// �ڶ�����ȡ�ַ����� $chars ������Ԫ��
		// $password .= substr($chars, mt_rand(0, strlen($chars) �C 1), 1);
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
curl_setopt ( $ch, CURLOPT_URL, 'https://api.netease.im/nimserver/user/refreshToken.action' );//��ַ
curl_setopt(  $ch, CURLOPT_HTTPHEADER  , $headers);
curl_setopt ( $ch, CURLOPT_POST, 1 );//����ʽΪpost
curl_setopt ( $ch, CURLOPT_HEADER, 0 );//����ӡheader��Ϣ
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );//���ؽ��ת���ַ���
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );//post��������ݡ�
$return = curl_exec ( $ch );
curl_close ( $ch );
// ָ������������������  
header('Access-Control-Allow-Origin:*');  
echo $return;
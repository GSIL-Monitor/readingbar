<?php

//微信公众号类

class public_number{

    private $AppID="wx2b04c13684009fc7";

    private $AppSecret="330f89ba001ede2e15c04f1776cebd4e";

    private $access_token=null;

    private $jsapi_ticket=null;

    public function __construct(){

        $this->get_access_token();

        $this->get_jsapi_ticket();
        
    }

    //对话服务-基础支持-获取access_token

    public function get_access_token(){

        if(!$this->access_token || $this->check_access_token_out_date()){

            $url="https://api.weixin.qq.com/cgi-bin/token";

            $url.="?grant_type=client_credential";

            $url.="&appid=".$this->AppID;

            $url.="&secret=".$this->AppSecret;

            $re=$this->curl_https_get($url);

            $this->access_token=json_decode($re,true);

            $this->access_token['get_time']=time();


        }

    }

    //校验access_token是否过期

    public function check_access_token_out_date(){

        $expires_in=$this->access_token['expires_in'];

        $get_time=$this->access_token['get_time'];

        if(time()-($get_time+$expires_in-200)>0){

            return true;

        }else{

            return false;

        }

    }

    //获取jsapi_ticket

    public function get_jsapi_ticket(){

        if(!$this->jsapi_ticket || $this->check_jsapi_ticket_out_date()){

            $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket";

            $url.="?access_token=".$this->access_token['access_token'];

            $url.="&type=jsapi";

            do{

                $re=$this->curl_https_get($url);

            }while($re!=0);

            $re=json_decode($re,true);

            $re['get_time']=time();

            $this->jsapi_ticket=$re;


        }

    }

    //校验jsapi_ticket是否过期

    public function check_jsapi_ticket_out_date(){

        $expires_in=$this->jsapi_ticket['expires_in'];

        $get_time=$this->jsapi_ticket['get_time'];

        if(time()-($get_time+$expires_in-200)>0){

            return true;

        }else{

            return false;

        }

    }

    //获取前端jssdk配置信息

    public function get_jssdk_config($url){

        $config=array(

            'jsapi_ticket'=>$this->jsapi_ticket['ticket'],

            'noncestr'=>$this->getRandChar(16),

            'timestamp'=>time(),

            'url'=>$url

        );

        $signature=null;

        foreach ($config as $key=>$value){

            if(!$signature){

                $signature=$key."=".$value;

            }else{

                $signature.="&".$key."=".$value;

            }

        }

        $config['signature']=sha1($signature);

        $config['appId']=$this->AppID;

        return $config;

    }

    //生成随机字符串

    function getRandChar($length){

        $str = null;

        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";

        $max = strlen($strPol)-1;

    

        for($i=0;$i<$length;$i++){

            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数

        }

    

        return $str;

    }

    //curl https get

    public function curl_https_get($url){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    // 要求结果为字符串且输出到屏幕上

        curl_setopt($ch, CURLOPT_HEADER, 0); // 不要http header 加快效率

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');

        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;

    }

}
$a =new public_number();
$config = $a->get_jssdk_config('http://xl.app/wx.php');
// 所有属性
var_dump($config);
// 单一获取某个值
echo $config['jsapi_ticket'];
?>
底下都是html代码
在html代码里调用
<?php echo $config['jsapi_ticket']; ?>

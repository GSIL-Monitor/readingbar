<?php
namespace Readingbar\Front\Controllers\Kdniao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Validator;
class KdniaoController extends Controller
{
	/**
	 *
	 * 快递鸟订阅推送2.0接口
	 *
	 * @技术QQ群: 340378554
	 * @see: http://kdniao.com/api-follow
	 * @copyright: 深圳市快金数据技术服务有限公司
	 *
	 * ID和Key请到官网申请：http://kdniao.com/reg
	 */
	
	//电商ID
	//defined('EBusinessID') or define('EBusinessID', '请到快递鸟官网申请http://kdniao.com/reg');
	//电商加密私钥，快递鸟提供，注意保管，不要泄漏
	//defined('AppKey') or define('AppKey', '请到快递鸟官网申请http://kdniao.com/reg');
	//测试请求url
	//defined('ReqURL') or define('ReqURL', 'http://testapi.kdniao.cc:8081/api/dist');
	//正式请求url
	//defined('ReqURL') or define('ReqURL', 'http://api.kdniao.cc/api/dist');
	
	//调用获取物流轨迹
	//-------------------------------------------------------------
	private $ReqURL;
	private $AppKey;
	private $EBusinessID;
	public function __construct(){
		$this->ReqURL='http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
		$this->AppKey='7ffa137b-b663-4d69-a910-7d15175a8aab';
		$this->EBusinessID="1289982";
	}
	public function getInfo(){
		$logisticResult = $this->getOrderTracesByJson($ShipperCode,$LogisticCode);
		var_dump(json_decode($logisticResult)->Traces);
	}
	//-------------------------------------------------------------
	
	/**
	 * Json方式 查询订单物流轨迹
	 */
	public function getOrderTracesByJson($ShipperCode,$LogisticCode){
		$requestData= "{'OrderCode':'','ShipperCode':'".$ShipperCode."','LogisticCode':'".$LogisticCode."'}";
		$datas = array(
	        'EBusinessID' => $this->EBusinessID,
	        'RequestType' => '1002',
	        'RequestData' => urlencode($requestData) ,
	        'DataType' => '2',
	    );
	    $datas['DataSign'] = $this->encrypt($requestData, $this->AppKey);
		$result=$this->sendPost($this->ReqURL, $datas);	
		
		//根据公司业务处理返回的信息......
		
		return $result;
	}
	 
	/**
	 *  post提交数据 
	 * @param  string $url 请求Url
	 * @param  array $datas 提交的数据 
	 * @return url响应返回的html
	 */
	public function sendPost($url, $datas) {
	    $temps = array();	
	    foreach ($datas as $key => $value) {
	        $temps[] = sprintf('%s=%s', $key, $value);		
	    }	
	    $post_data = implode('&', $temps);
	    $url_info = parse_url($url);
		if(empty($url_info['port']))
		{
			$url_info['port']=80;	
		}
	    $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
	    $httpheader.= "Host:" . $url_info['host'] . "\r\n";
	    $httpheader.= "charset:utf-8\r\n";
	    $httpheader.= "Content-Type:application/x-www-form-urlencoded; charset=utf-8\r\n";
	    $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
	    $httpheader.= "Connection:close\r\n\r\n";
	    $httpheader.= $post_data;
	    $fd = fsockopen($url_info['host'], $url_info['port']);
	    fwrite($fd, $httpheader);
	    $gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
	    while (!feof($fd)) {
			$gets.= fread($fd, 128);
	    }
	    fclose($fd);  
	    
	    return $gets;
	}
	
	/**
	 * 电商Sign签名生成
	 * @param data 内容   
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	public function encrypt($data, $appkey) {
	    return urlencode(base64_encode(md5($data.$appkey)));
	}
}
?>
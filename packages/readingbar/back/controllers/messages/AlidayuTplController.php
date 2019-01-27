<?php
namespace Readingbar\Back\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\AlidayuMessageTpl;
use Messages;
/**
 * 阿里大鱼模板管理
 * @author johnathan
 */
class AlidayuTplController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'alidayu_tpl.head_title','url'=>'admin/alidayuTpl/list','active'=>true),
	);
	/**
	 * 阿里大鱼 模板列表
	 */
	public function index(Request $request){
		if ($request->ajax()){
			$result=AlidayuMessageTpl::whereNull('deleted_at')->orderBy('created_at','desc')->paginate(10);
			return $result;
		}else{
			$data['head_title']=trans('alidayu_tpl.head_title');
			$data['breadcrumbs']=$this->breadcrumbs;
			return $this->view('messages.alidayuTplList', $data);
		}
	}
	/**
	 * 阿里大鱼 模板表单
	 */
	public function form(){
		$data['head_title']=trans('messagesBox.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('messages.alidayuTplForm', $data);
	}
	/**
	 * 阿里大鱼 模板保存
	 */
	public function store(Request $request){
		$check = validator($request->all(),[
				'name'=>'required|string|max:50',
				'sms'=>'required',
				'content'=>'required|string|max:500',
		],[],[
				'name'=>'标题',
				'sms'=>'sms code',
				'content'=>'内容',
		]);
		if($check->passes()){
			$create=AlidayuMessageTpl::create([
					'name'=>$request->input('name'),
					'sms'=>$request->input('sms'),
					'content'=>$request->input('content')
			]);
			$result = AlidayuMessageTpl::where(['id'=>$create->id])->first();
			return response(['message'=>'数据保存成功！','data'=>$result]);
		}else{
			return response(['errors'=>$check->errors()],400);
		}
	}
	/**
	 * 阿里大鱼 模板更新
	 */
	public function update(Request $request){
		$check = validator($request->all(),[
				'id'=>'required|exists:alidayu_message_tpl,id',
				'name'=>'required|string|max:50',
				'sms'=>'required',
				'content'=>'required|string|max:500',
		],[],[
				'name'=>'标题',
				'sms'=>'sms code',
				'content'=>'内容',
		]);
		if($check->passes()){
			AlidayuMessageTpl::where(['id'=>$request->input('id')])->update([
					'name'=>$request->input('name'),
					'sms'=>$request->input('sms'),
					'content'=>$request->input('content')
			]);
			$result = AlidayuMessageTpl::where(['id'=>$request->input('id')])->first();
			return response(['message'=>'数据保存成功！','data'=>$result]);
		}else{
			return response(['errors'=>$check->errors()],400);
		}
	}
	/**
	 * 阿里大鱼 模板删除
	 */
	public function destroy(Request $request){
		$check = validator($request->all(),[
				'id'=>'required|exists:alidayu_message_tpl,id'
		]);
		if($check->passes()){
			AlidayuMessageTpl::where(['id'=>$request->input('id')])->update(['deleted_at'=>DB::raw('Now()')]);
			return response(['message'=>'数据删除成功！']);
		}else{
			return response(['message'=>'数据不存在或已删除！',400]);
		}
	}
	/**
	 * 短信发送测试
	 */
	public function sendTest(Request $request){
		$check = validator($request->all(),[
			'id'=>'required|exists:alidayu_message_tpl,id',
			'tel'=>'required|min:11|max:11'
		],[],[
			'id'=>'记录',
			'tel'=>'手机'
		]);
		if($check->passes()){
			$result = AlidayuMessageTpl::where(['id'=>$request->input('id')])->first();
			Messages::sendMobile($request->input('tel'),[],$result->sms);
			return response(['message'=>'短信发送成功！']);
		}else{
			return response(['message'=>$check->errors()->first(),400]);
		}
	}
}
?>
<?php
namespace Readingbar\Back\Controllers\Messages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Readingbar\Back\Controllers\BackController;
use Readingbar\Back\Models\AlidayuMessageTpl;
use Messages;
use Readingbar\Back\Models\AlidayuMessageSetting;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\Services;
use phpDocumentor\Reflection\Types\String_;
/**
 * 阿里大鱼消息发送设置
 * @author johnathan
 */
class AlidayuSendSettingController  extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'alidayu_send_setting.head_title','url'=>'admin/alidayuSendSetting','active'=>true),
	);
	private $types=[
		1=>'服务到期前n天',
		2=>'服务开始后n天',
		3=>'服务到后n天',
		4=>'成功购买产品后',
		5=>'成功续费购买产品后',
		6=>'等待star账号分配通知',
		7=>'申请退押金后',
		8=>'退完押金后',
		9=>'上传star报告通知',
		10=>'上传阶段报告通知',
		11=>'发货通知（定制计划）',
		12=>'回收通知（定制计划）',
		13=>'还书到期日前n天（定制计划）',
		14=>'发货通知（借阅计划）',
		15=>'回收通知（借阅计划）',
		//16=>'还书到期日前n天（借阅计划）(待实现)'
		17=>'定制计划上传通知',
		18=>'借阅计划上传通知',
	];
	private $status=[
			'0'=>'停用',
			'1'=>'启用'
	];
	/**
	 * 阿里大鱼 设置列表
	 */
	public function index(Request $request){
		if ($request->ajax()){
			$result=AlidayuMessageSetting::whereNull('deleted_at')->where(function($where)use($request){
				if($request->input('type')){
					$where->where(['type'=>$request->input('type')]);
				}
				if($request->input('tpl_id')){
					$where->where(['tpl_id'=>$request->input('tpl_id')]);
				}
				if($request->input('service_id')){
					$where->where(['service_id'=>$request->input('service_id')]);
				}
				if($request->input('product_id')){
					$where->where(['product_id'=>$request->input('product_id')]);
				}
				if($request->input('status') && $request->input('status')!=='' && in_array($request->input('status'),[0,1])){
					$where->where(['status'=>$request->input('status')]);
				}
			})
			->orderBy('created_at','desc')
			->paginate(10);
			return $result;
		}else{
			$data['head_title']=trans('alidayu_send_setting.head_title');
			$data['breadcrumbs']=$this->breadcrumbs;
			$data['tpls']=AlidayuMessageTpl::whereNull('deleted_at')->get(['id','name','content'])->toJson();
			$data['products']=Products::get(['id','product_name as name'])->toJson();
			$data['services']=Services::get(['id','service_name as name'])->toJson();
			$data['types']=collect($this->types)->toJson();
			$data['status']=collect($this->status)->toJson();
			return $this->view('messages.alidayuSendSettingList', $data);
		}
	}
	/**
	 * 阿里大鱼 发送设置保存
	 */
	public function store(Request $request){
		$rules = $rules = $this->rulesSupplement($request->input('type'),[
				'name'=>'required|string|max:30',
				'tpl_id'=>'required|exists:alidayu_message_tpl,id',
				'type'=>'required|in:'.collect($this->types)->keys()->implode(','),
				'status'=>'required|in:0,1'
		]);
		$check = validator($request->all(),$rules,[],[
				'name'=>'标题',
				'tpl_id'=>'模板',
				'type'=>'类型',
				'product_id'=>'产品',
				'service_id'=>'服务',
				'days'=>'天数',
				'status'=>'状态',
		]);
		if($check->passes()){
			$create=AlidayuMessageSetting::create([
					'name'=>$request->input('name'),
					'tpl_id'=>$request->input('tpl_id'),
					'type'=>$request->input('type'),
					'product_id'=>$request->input('product_id')?$request->input('product_id'):null,
					'service_id'=>$request->input('service_id')?$request->input('service_id'):null,
					'days'=>$request->input('days')?$request->input('days'):null,
					'status'=>$request->input('status')
			]);
			$result = AlidayuMessageSetting::where(['id'=>$create->id])->first();
			$this->closeOtherSameSetting($result);
			return response(['message'=>'数据保存成功！','data'=>$result]);
		}else{
			return response(['errors'=>$check->errors()],400);
		}
	}
	/**
	 * 阿里大鱼 发送设置更新
	 */
	public function update(Request $request){
		$rules = $this->rulesSupplement($request->input('type'),[
				'id'=>'required|exists:alidayu_message_setting,id',
				'name'=>'required|string|max:30',
				'tpl_id'=>'required|exists:alidayu_message_tpl,id',
				'type'=>'required|in:'.collect($this->types)->keys()->implode(','),
				'status'=>'required|in:0,1'
		]);
		$check = validator($request->all(),$rules,[],[
				'name'=>'标题',
				'tpl_id'=>'模板',
				'type'=>'类型',
				'product_id'=>'产品',
				'service_id'=>'服务',
				'days'=>'天数',
				'status'=>'状态',
		]);
		if($check->passes()){
			AlidayuMessageSetting::where(['id'=>$request->input('id')])->update([
					'name'=>$request->input('name'),
					'tpl_id'=>$request->input('tpl_id'),
					'type'=>$request->input('type'),
					'product_id'=>$request->input('product_id')?$request->input('product_id'):null,
					'service_id'=>$request->input('service_id')?$request->input('service_id'):null,
					'days'=>$request->input('days')?$request->input('days'):null,
					'status'=>$request->input('status')
			]);
			$result = AlidayuMessageSetting::where(['id'=>$request->input('id')])->first();
			$this->closeOtherSameSetting($result);
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
				'id'=>'required|exists:alidayu_message_setting,id'
		]);
		if($check->passes()){
			AlidayuMessageSetting::where(['id'=>$request->input('id')])->update(['deleted_at'=>DB::raw('Now()')]);
			return response(['message'=>'数据删除成功！']);
		}else{
			return response(['message'=>'数据不存在或已删除！'],400);
		}
	}
	/**
	 *  校验规则补充
	 * @param String $type
	 * @param array $rules
	 * @return string
	 */
	public function rulesSupplement(String $type,Array $rules){
		if(in_array($type,[1,2,3])){
			$rules['service_id'] = 'required|exists:services,id';
			$rules['days'] = 'required|integer|min:0';
		}
		if(in_array($type,[13,16])){
			$rules['days'] = 'required|integer|min:0';
		}
		if(in_array($type,[4,5,7,8])){
			$rules['product_id'] = 'required|exists:products,id';
		}
		return $rules;
	}
	/**
	 * 根据消息类型  关闭同类设置 保证设置的唯一性
	 * 任一设置新增或修改启用时调用
	 */
	public function closeOtherSameSetting($setting){
		if($setting->status){
			switch($setting->type){
				case 1:;
				case 2:;
				case 3:
					AlidayuMessageSetting::where([
						'type'=>$setting->type,
						'service_id'=>$setting->service_id,
						'days'=>$setting->days
					])
					->where('id','<>',$setting->id)
					->update([
						'status'=>0
					]);
					break;
				case 13:;
				case 16:
					AlidayuMessageSetting::where([
						'type'=>$setting->type,
						'days'=>$setting->days
					])
					->where('id','<>',$setting->id)
					->update([
						'status'=>0
					]);
					break;
				case 4:;
				case 5:;
				case 7:;
				case 8:
					AlidayuMessageSetting::where([
							'type'=>$setting->type,
							'product_id'=>$setting->product_id
					])
					->where('id','<>',$setting->id)
					->update([
							'status'=>0
					]);
					break;
				default:
					AlidayuMessageSetting::where([
							'type'=>$setting->type
					])
					->where('id','<>',$setting->id)
					->update([
							'status'=>0
					]);
			}
		}
	}
}
?>
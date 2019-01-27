<?php
namespace Readingbar\Back\Controllers\Discount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Discount;
use DB;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\DiscountType;
use Messages;
use Symfony\Component\HttpFoundation\Session\Session;
use Log;
class DiscountGiveController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'DiscountGive.head_title','url'=>'admin/DiscountGive','active'=>true),
	);
	/**
	 * 赠送优惠券操作面板
	 */
	public function index(){
		//echo phpinfo();exit;
		$data['head_title']=trans('DiscountGive.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['search_types']=array('1'=>'注册并添加孩子信息但未付费的用户');
		$data['discount_types']=DiscountType::where(['del'=>0])->get(['id','name']);
		return $this->view('discount.DiscountGive', $data);
	}
	/**
	 * 检索符合条件的会员并给予优惠券
	 */
	public function giveDiscountToMembers(Request $request){
		$check=Validator::make($request->all(),[
				'search_type'=>'required|in:0,1,2,3,4,5,6',
				'discount_type'=>'required|exists:discount_type,id',
				'progress_id'=>'required'
		],
		trans('DiscountGive.messages'),
		trans('DiscountGive.attributes'));
		if($check->passes()){
			$members=$this->seachMembers($request);
			set_time_limit(count($members));
			$progress=0;
			session()->set('progress',0);
			session()->save();
			foreach ($members as $m){
				$progress=$progress+1;
				$this->giveDiscountToMember($request, $m);
				session()->set('dg_'.$request->input('progress_id'),$progress/count($members)*100);
				session()->save();
			}
			return array('status'=>true,'success'=>'优惠券已赠送！');
		}else{
			return array('status'=>false,'error'=>$check->errors()->first());
		}
	}
	/**
	 * 注册并添加孩子信息但未付费的用户
	 */
	public function seachMembers(Request $request){
		$mids=Members::leftjoin('students as s','s.parent_id','=','members.id')
					->leftjoin('service_status as ss','ss.student_id','=','s.id')
					->where('ss.expirated','>',DB::raw('NOW()'))
					->distinct()
					->select(['members.id'])
					->get()
					->pluck('id')
					->all();
		$members=Members::leftjoin('students as s','s.parent_id','=','members.id')
							->whereNotIn('members.id',$mids)
							->groupBy('members.id')
							->having(DB::raw('count(distinct(s.id))'),'>','0')
							->get(['members.*']);
		return $members;
	}
	/**
	 * 给固定会员赠送优惠券
	 */
	public function giveDiscountToMember(Request $request,$member){
		$dicountType=DiscountType::where('id','=',$request->input('discount_type'))->first();
		$expiration_time=date_create(date('Y-m-d H:i:s',time()));
		date_add($expiration_time,date_interval_create_from_date_string($dicountType['days']." days"));
		$create=array(
				'price'=>$dicountType['price'],
				'expiration_time'=>date_format($expiration_time,'Y-m-d H:i:s'),
				'status'=>0,
				'member_id'=>$member->id,
				'discount_type'=>$dicountType['id']
		);
		$discount=Discount::create($create);
		$this->informMember($member,$discount);
	}
	/**
	 * 消息通知用户优惠券已到帐
	 */
	public function informMember($member,$discount){
		$price=$discount->price;
		$expirated=$discount->expiration_time;
		if($member->email){
			Messages::sendEmail(
					'优惠券到帐通知',
					$member->email,
					'messages::giveDiscount',
					array('price'=>$price,'expirated'=>$expirated)
			);
		}
		if($member->cellphone){
			Messages::sendMobile(
					$member->cellphone,
					array('price'=>$price,'expirated'=>$expirated),
					'SMS_59115138'
			);
		}
		Messages::sendSiteMessage(
				'优惠券到帐通知',
				$price.'元优惠券已到帐,有效期至'.$expirated.',请点击个人中心优惠券查看,客服热线：400 625 9800！',
				$member->email?$member->email:$member->cellphone,
				'system',
				'all'
		);
	}
	/**
	 * 获取执行进度
	 */
	public function getProgress(Request $request){
		$progress=session('dg_'.$request->input('progress_id'));
		if($progress==100){
			session('dg_'.$request->input('progress_id'),null);
		}
		return array('status'=>true,'progress'=>$progress);
	}
}
?>
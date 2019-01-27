<?php

namespace Readingbar\Front\Controllers\Promotions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Api\Frontend\Models\Members;
use Readingbar\Back\Models\Promotions;
use Validator;
use DB;
use Readingbar\Back\Models\Discount;
use QrCode;
use Illuminate\Support\Facades\Storage;
class PromotionsController extends FrontController
{
	private $promoter=null;
	public function __construct(){
		$this->promoter=Members::leftjoin('promotions','promotions.member_id','=','members.id')
			->whereNotNull('promotions.pcode')
			->where(['promotions.member_id'=>auth('member')->getId()])
			->first(['promotions.*']);
	}
	/*推广员信息查询*/
	public function index(){
		$data['head_title']='推广员信息查询';
		if($this->promoter){
			return view('front::default.promotions.index3',$data);
		}else{
			return redirect('/');
		}
	}
	/*蕊丁使者*/
	public  function RDMessenger(){
		$data['head_title']='蕊丁使者';
		if($this->promoter){
			$data['member']=Members::where(['id'=>$this->promoter->member_id])->first()->toArray();
			$data['member']['promote_url']=url('register?pcode='.$this->promoter->pcode);
			if(!file_exists(public_path('files/qrcodes'))) mkdir(public_path('files/qrcodes'));
			$dir='files/qrcodes/qrcode_'.$this->promoter->pcode.'_200x200.png';
			if(!file_exists(public_path($dir))){
				QrCode::format('png')->size(200)->generate($data['member']['promote_url'],public_path($dir));
			}
			$data['member']['promote_qrcode']=url($dir);
			$data['member']['avatar']=$data['member']['avatar']?url($data['member']['avatar']):url('files/avatar/default_avatar.jpg');
			
			return $this->view('promotions.RDMessenger',$data);
		}else{
			return redirect('introduce/RDMessenger');
		}
	}
	/**
	 * 当前用户成为蕊丁使者
	 * @return boolean[]|string[]
	 */
	public function becomPromoter(){
		$inputs['member_id']=auth('member')->getId();
		$rules=[
				'member_id'=>'required|unique:promotions,member_id',
		];
		$check=Validator::make($inputs,$rules);
		if($check->passes()){
			$r=DB::select('select f_become_promoter('.auth('member')->getId().',5,3,"蕊丁使者") as result');
			if(isset($r)){
				if($r[0]->result==0){
					$p=Promotions::where(['member_id'=>auth('member')->getId()])->first();
					Discount::giveByRule($p->member_id, 'become_promoter',['promotions_type_id'=>$p->type]);
					return redirect('member/promotions/RDMessenger')->with(['alert'=>'欢迎加入蕊丁使者的行列！']);
				}else{
					return back()->with(['alert'=>'你已经是推广员了']);
				}
			}else{
				return back()->with(['alert'=>'函数执行失败！']);
			}
		}else{
				return redirect('member/promotions/RDMessenger');
		}
		
	}
	public function wapMenu(){
		$data['head_title']='蕊丁使者';
		return $this->view('promotions.wapMenu',$data);
	}
	public function downloadqrcode(){
		ob_clean();
		$dir='files/qrcodes/qrcode_'.$this->promoter->pcode.'_200x200.png';
		$filename='qrcode_'.$this->promoter->pcode.'_200x200.png';
		return response()->download(public_path($dir));
	}
}

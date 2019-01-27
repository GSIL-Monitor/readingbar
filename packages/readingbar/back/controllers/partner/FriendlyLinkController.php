<?php
namespace Readingbar\Back\Controllers\Partner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\FriendlyLinkProduct;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\PPC;
use Storage;
use Readingbar\Back\Models\FriendlyLink;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\FriendlyLinkLog;
use Readingbar\Back\Models\FriendlyLinkStatus;
use Readingbar\Back\Models\FriendlyLinkMonth;
use DB;
class FriendlyLinkController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'FriendlyLink.head_title','url'=>'admin/partner/friendlyLink','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('FriendlyLink.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('partner.FriendlyLinkList', $data);
	}
	/*表单*/
	public function viewForm(Request $request){
		$data['head_title']=trans('FriendlyLink.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']['get_rule_products']=unserialize($return['data']['get_rule_products']);
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/partner/friendlyLink/update');
		}else{
			$data['action']=url('admin/partner/friendlyLink/create');
			$data['editObj']=collect([
					'get_rule'=>'give_by_admin',
					'get_rule_products'=>array(),
					'status'=>0
			])->toJson();
		}
		if(old()){
			$old=old();
			if(!isset($old['get_rule_products'])){
				$old['get_rule_products']=array();
			}
			$data['editObj']=collect($old)->toJson();
		}
		$data['cancel']=url('admin/partner/friendlyLink');
		return $this->view('partner.FriendlyLinkForm', $data);
	}
	/*新增*/
	public function create(Request $request){
		$rules=[
				'partner'=>'required',
				'link'=>'required|URL',
				'status'  =>'required|in:0,1'
		];
		$messages=trans('FriendlyLink.messages');
		$attributes=trans('FriendlyLink.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'partner'=>$request->input('partner'),
					'link'=>$request->input('link'),
					'status'=>$request->input('status'),
			);
			FriendlyLink::create($create);
			return redirect('admin/partner/friendlyLink')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*删除*/
	public function delete(Request $request){
		if($request->input('selected')!=null){
			$selected=$request->input('selected');
			if(is_array($selected)){
				FriendlyLink::wherein('id',$selected)->update(['del'=>1]);
			}else{
				FriendlyLink::where(['id'=>$selected])->update(['del'=>1]);
			}
			return array('status'=>true,'success'=>'删除成功！');
		}else{
			return array('status'=>false,'error'=>'请选择要删除的数据！');
		}
	}
	/*更改*/
	public function update(Request $request){
		$rules=[
				'id'	=>'required|exists:friendly_link,id,del,0',
				'partner'=>'required',
				'link'=>'required|URL',
				'status'	=>'required|in:0,1'
		];
		$messages=trans('FriendlyLink.messages');
		$attributes=trans('FriendlyLink.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'partner'=>$request->input('partner'),
					'link'=>$request->input('link'),
					'status'=>$request->input('status')
			);
			FriendlyLink::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/partner/friendlyLink')->with(['OPmsg'=>array('status'=>true,'success'=>'数据已保存!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*查询*/
	public function getList(Request $request){
		$rs=FriendlyLink::where(function($where) use($request){
			$where->where('partner','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('friendly_link'))?$request->input('order'):'id',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc')
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/partner/friendlyLink/form?id='.$v->id);
			$rs[$k]['status_text']=trans('FriendlyLink.list.status.'.$v->status);
		}
		return $rs;
	}
	public function getById(Request $request){
		$ppc= FriendlyLink::where(['id'=>$request->input('id'),'del'=>0])->first();
		if($ppc){
			return array('status'=>true,'data'=>$ppc);
		}else{
			return '找不到数据！';
		}
	}
}
?>
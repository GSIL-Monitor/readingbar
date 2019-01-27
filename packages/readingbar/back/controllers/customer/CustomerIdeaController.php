<?php
namespace Readingbar\Back\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\CustomerIdeaProduct;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\PPC;
use Storage;
use Readingbar\Back\Models\CustomerIdea;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\CustomerIdeaLog;
use Readingbar\Back\Models\CustomerIdeaStatus;
use Readingbar\Back\Models\CustomerIdeaMonth;
use DB;
use Readingbar\Back\Models\Members;
class CustomerIdeaController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'CustomerIdea.head_title','url'=>'admin/customer/idea','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('CustomerIdea.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('customer.CustomerIdeaList', $data);
	}
	/*表单*/
	public function viewForm(Request $request){
		$data['head_title']=trans('CustomerIdea.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']['get_rule_products']=unserialize($return['data']['get_rule_products']);
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/customer/idea/update');
		}else{
			$data['action']=url('admin/customer/idea/create');
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
		$data['cancel']=url('admin/customer/idea');
		$data['members']=Members::get(['id','nickname']);
		return $this->view('customer.CustomerIdeaForm', $data);
	}
	/*新增*/
	public function create(Request $request){
		$rules=[
				'member_id'=>'required',
				'idea'=>'required',
				'reply'  =>'required',
				'show_status'  =>'required|in:0,1'
		];
		$messages=trans('CustomerIdea.messages');
		$attributes=trans('CustomerIdea.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'member_id'=>$request->input('member_id'),
					'idea'=>$request->input('idea'),
					'reply'=>$request->input('reply'),
					'show_status'=>$request->input('show_status'),
			);
			CustomerIdea::create($create);
			return redirect('admin/customer/idea')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*删除*/
	public function delete(Request $request){
		if($request->input('selected')!=null){
			$selected=$request->input('selected');
			if(is_array($selected)){
				CustomerIdea::wherein('id',$selected)->update(['del'=>1]);
			}else{
				CustomerIdea::where(['id'=>$selected])->update(['del'=>1]);
			}
			return array('status'=>true,'success'=>'删除成功！');
		}else{
			return array('status'=>false,'error'=>'请选择要删除的数据！');
		}
	}
	/*更改*/
	public function update(Request $request){
		$rules=[
				'id'	=>'required|exists:customer_idea,id,del,0',
				'member_id'=>'required',
				'idea'=>'required',
				'reply'  =>'required',
				'show_status'  =>'required|in:0,1'
		];
		$messages=trans('CustomerIdea.messages');
		$attributes=trans('CustomerIdea.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'member_id'=>$request->input('member_id'),
					'idea'=>$request->input('idea'),
					'reply'=>$request->input('reply'),
					'show_status'=>$request->input('show_status')
			);
			CustomerIdea::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/customer/idea')->with(['OPmsg'=>array('status'=>true,'success'=>'数据已保存!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*查询*/
	public function getList(Request $request){
		$rs=CustomerIdea::leftjoin('members as m','m.id','=','customer_idea.member_id')
		->where(function($where) use($request){
			$where->where('customer_idea.idea','like','%'.$request->input('keyword').'%');
			$where->orwhere('customer_idea.reply','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->select(['customer_idea.*',DB::raw('IF(customer_idea.member_id=0,"游客",m.nickname) as nickname')])
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('customer_idea'))?'customer_idea.'.$request->input('order'):'customer_idea.id',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc')
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/customer/idea/form?id='.$v->id);
			$rs[$k]['status_text']=trans('CustomerIdea.list.show_status.'.$v->show_status);
		}
		return $rs;
	}
	public function getById(Request $request){
		$ppc= CustomerIdea::where(['id'=>$request->input('id'),'del'=>0])->first();
		if($ppc){
			return array('status'=>true,'data'=>$ppc);
		}else{
			return '找不到数据！';
		}
	}
}
?>
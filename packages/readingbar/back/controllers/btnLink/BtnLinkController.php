<?php
namespace Readingbar\Back\Controllers\BtnLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\BtnLinkProduct;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\PPC;
use Storage;
use Readingbar\Back\Models\BtnLink;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\BtnLinkLog;
use Readingbar\Back\Models\BtnLinkStatus;
use Readingbar\Back\Models\BtnLinkMonth;
use DB;
class BtnLinkController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'BtnLink.head_title','url'=>'admin/btnLink','active'=>true),
	);
	/*管理首页*/
	public function viewList(){
		$data['head_title']=trans('BtnLink.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('BtnLink.BtnLinkList', $data);
	}
	/*表单*/
	public function viewForm(Request $request){
		$data['head_title']=trans('BtnLink.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']['get_rule_products']=unserialize($return['data']['get_rule_products']);
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/btnLink/update');
		}else{
			$data['action']=url('admin/btnLink/create');
			$data['editObj']=collect([
					'get_rule'=>'give_by_admin',
					'get_rule_products'=>array(),
					'status'=>0
			])->toJson();
		}
		if(old()){
			$old=old();
			$data['editObj']=collect($old)->toJson();
		}
		$data['positions']=collect(BtnLink::getPostions())->toJson();
		$data['styles']=collect(BtnLink::getStyles())->toJson();
		$data['cancel']=url('admin/btnLink');
		return $this->view('BtnLink.BtnLinkForm', $data);
	}
	/*新增*/
	public function create(Request $request){
		$rules=[
				'name'=>'required',
				'link'=>'required|URL',
				'position'=>'required|exists:btn_link_position,id',
				'style'=>'required|exists:btn_link_style,id',
				'display'=>'required|integer'
		];
		$messages=trans('BtnLink.messages');
		$attributes=trans('BtnLink.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$create=array(
					'name'=>$request->input('name'),
					'link'=>$request->input('link'),
					'position'=>$request->input('position'),
					'style'=>$request->input('style'),
					'display'=>$request->input('display'),
					'status'=>$request->input('status')
			);
			BtnLink::create($create);
			return redirect('admin/btnLink')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*删除*/
	public function delete(Request $request){
		if($request->input('selected')!=null){
			$selected=$request->input('selected');
			if(is_array($selected)){
				BtnLink::wherein('id',$selected)->update(['del'=>1]);
			}else{
				BtnLink::where(['id'=>$selected])->update(['del'=>1]);
			}
			return array('status'=>true,'success'=>'删除成功！');
		}else{
			return array('status'=>false,'error'=>'请选择要删除的数据！');
		}
	}
	/*更改*/
	public function update(Request $request){
		$rules=[
				'id'	=>'required|exists:btn_link,id,del,0',
				'name'=>'required',
				'link'=>'required|URL',
				'position'=>'required|exists:btn_link_position,id',
				'style'=>'required|exists:btn_link_style,id',
				'status'	=>'required|in:0,1',
				'display'=>'required|integer'
		];
		$messages=trans('BtnLink.messages');
		$attributes=trans('BtnLink.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'name'=>$request->input('name'),
					'link'=>$request->input('link'),
					'position'=>$request->input('position'),
					'style'=>$request->input('style'),
					'display'=>$request->input('display'),
					'status'=>$request->input('status')
			);
			BtnLink::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/btnLink')->with(['OPmsg'=>array('status'=>true,'success'=>'数据已保存!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/*查询*/
	public function getList(Request $request){
		$rs=BtnLink::leftjoin('btn_link_position','btn_link_position.id','=','btn_link.position')
		->where(function($where) use($request){
			$where->where('btn_link.name','like','%'.$request->input('keyword').'%');
			$where->orwhere('btn_link_position.name','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->orderBy(
				in_array($request->input('order'),Schema::getColumnListing('btn_link'))?'btn_link.'.$request->input('order'):'btn_link.id',
				in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc'
		)
		->select(['btn_link.*','btn_link_position.name as position'])
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/btnLink/form?id='.$v->id);
			$rs[$k]['status_text']=trans('BtnLink.list.status.'.$v->status);
		}
		return $rs;
	}
	public function getById(Request $request){
		$ppc= BtnLink::where(['id'=>$request->input('id'),'del'=>0])->first();
		if($ppc){
			return array('status'=>true,'data'=>$ppc);
		}else{
			return '找不到数据！';
		}
	}
	/*预览*/
	public function preview($id){
		
	}
}
?>
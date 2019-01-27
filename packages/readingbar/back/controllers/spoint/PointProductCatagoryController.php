<?php
namespace Readingbar\Back\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\PPC;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Storage;
class PointProductCatagoryController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'ppc.head_title','url'=>'admin/spoint/ppc','active'=>true),
	);
	/**
	 * 积分商品分类列表
	 */
	public function viewList(){
		$data['head_title']=trans('ppc.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('spoint.ppcList', $data);
	}
	/**
	 * 积分商品分类表单
	 */
	public function viewForm(Request $request){
		$data['head_title']=trans('ppc.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']['icon_pc']=url($return['data']['icon_pc']);
				$return['data']['icon_wap']=url($return['data']['icon_wap']);
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			
			$data['action']=url('admin/ppc/update');
		}else{
			$data['editObj']=collect(array('type'=>0,'type_v'=>''))->toJson();;
			$data['action']=url('admin/ppc/create');
		}
		if(old()){
			$data['editObj']=collect(old())->toJson();
		}
		$data['cancel']=url('admin/ppc');
		return $this->view('spoint.ppcForm', $data);
	}
	/**
	 * 积分商品分类信息
	 */
	public function getList(Request $request){
		$rs=PPC::where(function($where) use($request){
			$where->where('catagory_name','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('s_point_product_catagory'))?$request->input('order'):'id',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc')
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['edit']=url('admin/ppc/form?id='.$v->id);
		}
		return $rs;
	}
	public function getById(Request $request){
		$ppc= PPC::where(['id'=>$request->input('id')])->first();
		if($ppc){
			return array('status'=>true,'data'=>$ppc);
		}else{
			return '找不到数据！';
		}
		
	}
	/**
	 * 创建
	 */
	public function create(Request $request){
		$rules=[
    			'catagory_name'=>'required|unique:s_point_product_catagory,catagory_name',
				'icon_pc'=>'required|image|image_scale:1,1',
				'icon_wap'=>'required|image|image_scale:1,1',
    	];
		$messages=trans('ppc.messages');
		$attributes=trans('ppc.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
    	if($check->passes()){
    		$create=array(
    					'catagory_name'=>$request->input('catagory_name')
    		);
    		if($request->hasFile('icon_pc')){
    			$create['icon_pc']=$this->saveImage($request->file('icon_pc'));
    		}
    		if($request->hasFile('icon_wap')){
    			$create['icon_wap']=$this->saveImage($request->file('icon_wap'));
    		}
    		PPC::create($create);
    		return redirect('admin/ppc')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
    	}else{
    		return redirect()->back()->withErrors($check)->withInput();
    	}
	}
	/**
	 * 更新
	 */
	public function update(Request $request){
		$rules=[
				'id'					=>'required|exists:s_point_product_catagory,id',
				'catagory_name'=>'required|unique:s_point_product_catagory,catagory_name,'.$request->input('id').',id',
				'icon_pc'=>'image|image_scale:1,1',
				'icon_wap'=>'image|image_scale:1,1',
		];
		$messages=trans('ppc.messages');
		$attributes=trans('ppc.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'catagory_name'=>$request->input('catagory_name'),
			);
			if($request->hasFile('icon_pc')){
				$update['icon_pc']=$this->saveImage($request->file('icon_pc'));
			}
			if($request->hasFile('icon_wap')){
				$update['icon_wap']=$this->saveImage($request->file('icon_wap'));
			}
			PPC::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/ppc')->with(['OPmsg'=>array('status'=>true,'success'=>'更新成功!')])->withInput();
		}else{
			return redirect()->back()->withErrors($check)->withInput();
		}
	}
	/**
	 * 删除
	 */
	public function delete(Request $request){ 
    	if($request->input('selected')!=null){ 
    		$selected=$request->input('selected');
    		if(is_array($selected)){ 
    			PPC::wherein('id',$selected)->update(['del'=>1]);
    		}else{ 
    			PPC::where(['id'=>$selected])->update(['del'=>1]);
    		}
    		return array('status'=>true,'success'=>'删除成功！');
    	}else{ 
    		return array('status'=>false,'error'=>'请选择要删除的数据！');
    	}
    }
    /**
     * 保存图像
     */
    public function saveImage($file){
    	$dir='files/icons/ppc/'.uniqid().'.'.$file->extension();
    	Storage::put(
    			$dir,
    			file_get_contents($file->getRealPath())
    			);
    	return $dir;
    }
}
?>
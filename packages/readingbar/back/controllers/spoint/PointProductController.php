<?php
namespace Readingbar\Back\Controllers\Spoint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\PointProduct;
use Illuminate\Support\Facades\Schema;
use Readingbar\Back\Models\DiscountType;
use Readingbar\Back\Models\PPC;
use Storage;
class PointProductController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'PointProduct.head_title','url'=>'admin/PointProduct','active'=>true),
	);
	/**
	 * 积分商品列表
	 */
	public function viewList(){
		$data['head_title']=trans('PointProduct.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['OPmsg']=collect(session('OPmsg')?session('OPmsg'):array())->toJson();
		return $this->view('spoint.PointProductList', $data);
	}
	/**
	 * 积分商品表单
	 */
	public function viewForm(Request $request){
		$data['head_title']=trans('PointProduct.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		if($request->input('id')){
			$return=$this->getById($request);
			if($return['status']){
				$return['data']->image=$return['data']->image?url($return['data']->image):null;
				$data['editObj']=collect($return['data'])->toJson();
			}else{
				return redirect()->back()->with(['OPmsg'=>$return]);
			}
			$data['action']=url('admin/PointProduct/update');
		}else{
			$data['editObj']=collect(array('status'=>0,'catagory'=>''))->toJson();;
			$data['action']=url('admin/PointProduct/create');
		}
		if(old()){
			$data['editObj']=collect(old())->toJson();
		}
		$data['discounts']=DiscountType::where(['get_rule'=>'buy_discount_by_point','status'=>1,'del'=>0])->get(['id','name'])->toJson();
		$data['catagory']=PPC::where(['del'=>0])->get(['id','catagory_name'])->toJson();
		$data['cancel']=url('admin/PointProduct');
		return $this->view('spoint.PointProductForm', $data);
	}
	/**
	 * 积分商品信息
	 */
	public function getList(Request $request){
		$rs=PointProduct::where(function($where) use($request){
			$where->where('product_name','like','%'.$request->input('keyword').'%');
		})
		->where(['del'=>0])
		->orderBy(in_array($request->input('order'),Schema::getColumnListing('s_point_product'))?$request->input('order'):'id',in_array($request->input('sort'),['asc','desc'])?$request->input('sort'):'asc')
		->paginate($request->input('limit')?$request->input('limit'):10);
		
		foreach ($rs as $k=>$v){
			$rs[$k]['status']=trans('PointProduct.form.status.'.$v->status);
			$rs[$k]['type']=trans('PointProduct.form.type.'.$v->type);
			$rs[$k]['edit']=url('admin/PointProduct/form?id='.$v->id);
			$rs[$k]['image']=$v->image?url($v->image):null;
			$rs[$k]['catagory']=PPC::where(['id'=>$v->catagory])->first()->catagory_name;
		}
		return $rs;
	}
	public function getById(Request $request){
		$pp= PointProduct::where(['id'=>$request->input('id')])->first();
		if($pp){
			return array('status'=>true,'data'=>$pp);
		}else{
			return '找不到数据！';
		}
		
	}
	/**
	 * 创建
	 */
	public function create(Request $request){
		$rules=[
    			'product_name'=>'required|unique:s_point_product,product_name',
        		'image'=>'required|image|image_scale:1,1',
        		'point'=>'required|integer',
        		'desc'=>'required',
        		'quantity'=>'required|integer',
        		'catagory'=>'required|exists:s_point_product_catagory,id',
        		'status'=>'required|in:0,1',
				'type'=>'required|in:0,1',
    	];
		if($request->input('type')==1){
			$rules['type_v']='required|exists:discount_type,id';
		}
		$messages=trans('PointProduct.messages');
		$attributes=trans('PointProduct.attributes');
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
    	if($check->passes()){
    		$create=array(
    				'product_name'=>$request->input('product_name'),
    				'point'=>$request->input('point'),
    				'desc'=>$request->input('desc'),
    				'quantity'=>$request->input('quantity'),
    				'catagory'=>$request->input('catagory'),
    				'status'=>$request->input('status'),
    				'type'	=>$request->input('type'),
    				'type_v'=>$request->input('type_v'),
    		);
    		if($request->hasFile('image')){
    			$create['image']=$this->saveImage($request->file('image'));
    		}
    		PointProduct::create($create);
    		return redirect('admin/PointProduct')->with(['OPmsg'=>array('status'=>true,'success'=>'创建成功!')])->withInput();
    	}else{
    		return redirect()->back()->withErrors($check)->withInput();
    	}
	}
	/**
	 * 更新
	 */
	public function update(Request $request){
		$rules=[
				'id'					=>'required|exists:s_point_product,id',
				'product_name'=>'required|unique:s_point_product,product_name,'.$request->input('id').',id',
        		'point'=>'required|integer',
        		'desc'=>'required',
        		'quantity'=>'required|integer',
        		'catagory'=>'required|exists:s_point_product_catagory,id',
        		'status'=>'required|in:0,1',
				'type'=>'required|in:0,1',
		];
		if($request->input('type')==1){
			$rules['type_v']='required|exists:discount_type,id';
		}
		$messages=trans('PointProduct.messages');
		$attributes=trans('PointProduct.attributes');
		if($request->hasFile('image')){
			$rules['image']='required|image';
		}
		$check=Validator::make($request->all(),$rules,$messages,$attributes);
		if($check->passes()){
			$update=array(
					'product_name'=>$request->input('product_name'),
    				'point'=>$request->input('point'),
    				'desc'=>$request->input('desc'),
    				'quantity'=>$request->input('quantity'),
    				'catagory'=>$request->input('catagory'),
    				'status'=>$request->input('status'),
					'type'=>$request->input('type'),
					'type_v'=>$request->input('type_v'),
			);
			if($request->hasFile('image')){
				$update['image']=$this->saveImage($request->file('image'));
			}
			if($request->input('type')==1){
				$update['type_v']=$request->input('type_v');
			}
			PointProduct::where(['id'=>$request->input('id')])->update($update);
			return redirect('admin/PointProduct')->with(['OPmsg'=>array('status'=>true,'success'=>'更新成功!')])->withInput();
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
    			PointProduct::wherein('id',$selected)->update(['del'=>1]);
    		}else{ 
    			PointProduct::where(['id'=>$selected])->update(['del'=>1]);
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
    	$dir='files/point_product_images/'.uniqid().'.'.$file->extension();
    	Storage::put(
    			$dir,
    			file_get_contents($file->getRealPath())
    			);
    	return $dir;
    }
}
?>
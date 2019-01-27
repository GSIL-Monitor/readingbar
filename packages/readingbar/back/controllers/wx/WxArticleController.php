<?php
namespace Readingbar\Back\Controllers\Wx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Storage;
use Readingbar\Back\Models\WxArticle;
class WxArticleController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'wxArticle.head_title','url'=>'admin/wxArticle','active'=>true),
	);
	/**
	 * 微信文章列表
	 */
	public function wxArticleList(){
		$data['head_title']=trans('wxArticle.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('wx.wxArticleList', $data);
	}
	/**
	 * 微信文章表单
	 * @param Integer $id
	 */
	public function wxArticleForm($id=null){
		$data['head_title']=trans('wxArticle.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['wxArticle_id']=$id;
		return $this->view('wx.wxArticleForm', $data);
	}
	/**
	 * 获得所有微信文章信息
	 * @param Request $request
	 */
	public function getWxArticles(Request $request){
		if((int)$request->input('limit')){
			$limit=(int)$request->input('limit');
		}else{
			$limit=10;
		}
		if($request->input('sort') && in_array($request->input('sort'),['desc','asc'])){
			$sort=(int)$request->input('sort');
		}else{
			$sort='asc';
		}
		if($request->input('order') && in_array($request->input('order'),['id','created_at'])){
			$order=$request->input('order');
		}else{
			$order='id';
		}
		$ns=WxArticle::orderby($order,$sort)->paginate($limit);
		foreach ($ns as $k=>$v){
			$ns[$k]['edit']=url('admin/wxArticle/'.$v['id'].'/form');
			$ns[$k]['status']=$v['status']==1?'启用':'停用';
			$ns[$k]['title_image']=$v['title_image']?url($v['title_image']):'';
			$ns[$k]['lable']=explode(',',$v['lable']);
		}
		return $ns;
	}
	/**
	 * 根据id获取微信文章信息
	 * @param Request $request
	 */
	public function getWxArticle(Request $request){
		$r=WxArticle::where(['id'=>$request->input('wxArticle_id')])->first();
		$r['title_image']=$r['title_image']?url($r['title_image']):'';
		return $r;
	}
	/**
	 * 编辑微信文章信息
	 * @param Request $request
	 */
	public function editWxArticle(Request $request){
		$inputs=$request->all();
		$r=wxArticle::where(['id'=>$request->input('id')])->first();
		if($r){
			if($dir=$this->saveFile($request->file('title_image'))){
				$inputs['title_image']=$dir;
			}else{
				$inputs['title_image']=$r['title_image'];
			}
		}
		$check=Validator::make($inputs,[
			'id'			=>'required|exists:wx_article,id',
			'title'			=>'required',
			'title_image'	=>'required',
			'summary'		=>'required',
			'lable'			=>'required',
			'url'			=>'required',
			'status'		=>'required|in:0,1'
		]);
		if($check->passes()){
			$update=array(
					'title'			=>$inputs['title'],
					'title_image'	=>$inputs['title_image'],
					'summary'		=>$inputs['summary'],
					'lable'			=>$inputs['lable'],
					'url'			=>$inputs['url'],
					'status'		=>$inputs['status']
			);
			WxArticle::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
	/**
	 * 新增微信文章信息
	 * @param Request $request
	 */
	public function createWxArticle(Request $request){
		$inputs=$request->all();
		if($dir=$this->saveFile($request->file('title_image'))){
			$inputs['title_image']=$dir;
		}else{
			$inputs['title_image']='';
		}
		$check=Validator::make($inputs,[
				'title'		=>'required',
				'title_image'	=>'required',
				'summary'	=>'required',
				'lable'		=>'required',
				'url'		=>'required',
				'status'	=>'required|in:0,1'
		]);
		if($check->passes()){
			$create=array(
					'title'			=>$inputs['title'],
					'title_image'	=>$inputs['title_image'],
					'summary'		=>$inputs['summary'],
					'lable'			=>$inputs['lable'],
					'url'			=>$inputs['url'],
					'status'		=>$inputs['status']
			);
			WxArticle::create($create);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
		
	}
	/**
	 * 删除微信文章信息
	 * @param Request $request
	 */
	public function deleteWxArticle(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			WxArticle::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
	/**
	 * 文件保存
	 * @param Request $request
	 */
	public function saveFile($file){
		if($file && in_array($file->extension(),['png','jpg','jpeg'])){
			$filename=uniqid();
			$dir='files/wxArticle/'.$filename.'.'.$file->extension();
			Storage::put(
					$dir,
					file_get_contents($file->getRealPath())
					);
			return $dir;
		}else{
			return false;
		}
	}
	/**
	 * 文章置顶
	 */
	public function setTop(Request $request){
		WxArticle::where(['id'=>$request->input('id')])->update(['top'=>time()]);
		return array('status'=>true,'success'=>'文章置顶成功！');
	}
	/**
	 * 文章取消置顶
	 */
	public function cancelTop(Request $request){
		WxArticle::where(['id'=>$request->input('id')])->update(['top'=>'0']);
		return array('status'=>true,'success'=>'取消置顶成功！');
	}
}
?>
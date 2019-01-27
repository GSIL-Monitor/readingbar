<?php
namespace Readingbar\Back\Controllers\Notice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use Readingbar\Back\Controllers\BackController;
use Validator;
use Readingbar\Back\Models\Notice;
class NoticeController extends BackController
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'notice.head_title','url'=>'admin/notice','active'=>true),
	);
	/**
	 * 公告列表
	 */
	public function noticeList(){
		$data['head_title']=trans('notice.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		return $this->view('notice.noticeList', $data);
	}
	/**
	 * 公告表单
	 * @param Integer $id
	 */
	public function noticeForm($id=null){
		$data['head_title']=trans('notice.head_title');
		$data['breadcrumbs']=$this->breadcrumbs;
		$data['notice_id']=$id;
		return $this->view('notice.noticeForm', $data);
	}
	/**
	 * 获得所有公告信息
	 * @param Request $request
	 */
	public function getNotices(Request $request){
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
			$order=(int)$request->input('order');
		}else{
			$order='id';
		}
		$ns=Notice::paginate($limit);
		foreach ($ns as $k=>$v){
			$ns[$k]['edit']=url('admin/notice/'.$v['id'].'/form');
			$ns[$k]['status']=$v['status']==1?'启用':'停用';
		}
		return $ns;
	}
	/**
	 * 根据id获取公告信息
	 * @param Request $request
	 */
	public function getNotice(Request $request){
		return Notice::where(['id'=>$request->input('notice_id')])->first();
	}
	/**
	 * 编辑公告信息
	 * @param Request $request
	 */
	public function editNotice(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
			'id'		=>'required|exists:notice,id',
			'url'		=>'url',
			'notice'	=>'required',
			'status'	=>'required|in:0,1'
		]);
		if($check->passes()){
			$update=array(
					'url'		=>$request->input('url'),
					'notice'	=>$inputs['notice'],
					'status'	=>$inputs['status']
			);
			Notice::where(['id'=>$request->input('id')])->update($update);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
	}
	/**
	 * 新增公告信息
	 * @param Request $request
	 */
	public function createNotice(Request $request){
		$inputs=$request->all();
		$check=Validator::make($inputs,[
				'url'		=>'url',
				'notice'	=>'required',
				'status'	=>'required|in:0,1'
		]);
		if($check->passes()){
			$create=array(
					'url'		=>$request->input('url'),
					'notice'	=>$inputs['notice'],
					'status'	=>$inputs['status']
			);
			Notice::create($create);
			return array('status'=>true,'success'=>'数据保存成功！');
		}else{
			$errors=$check->messages()->toArray();
			return array('status'=>false,'errors'=>$errors);
		}
		
	}
	/**
	 * 删除公告信息
	 * @param Request $request
	 */
	public function deleteNotice(Request $request){
		if($request->input('selected') && is_array($request->input('selected'))){
			Notice::whereIn('id',$request->input('selected'))->delete();
			$json=array('status'=>true,'success'=>'数据已删除！');
		}else{
			$json=array('status'=>false,'error'=>'请选择要删除的数据！');
		}
		return $json;
	}
}
?>
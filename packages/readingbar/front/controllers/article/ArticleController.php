<?php

namespace Readingbar\Front\Controllers\Article;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Readingbar\Front\Controllers\FrontController;
use App\Http\Requests;
use Readingbar\Back\Models\WxArticle;
 
class ArticleController extends FrontController
{
	/*推广员信息查询*/
	public function index(){
		$data['head_title']='阅读分享';
		return $this->view('article.articleList', $data);
	}
	/*获取微信文章列表*/
	public function getListOfWx(Request $request){
		$r=WxArticle::where(['status'=>1])->where(function($where) use($request){
			if($request->input('keyWord')){
				$where->where('title','like','%'.$request->input('keyWord').'%')
					->orWhere('lable','like','%'.$request->input('keyWord').'%');
			}
		})->orderBy('top','desc')->orderBy('created_at','desc')->paginate($request->input('limit')?$request->input('limit'):10);

		foreach ($r as $k=>$v){
			$r[$k]['title_image']=$v['title_image']?url($v['title_image']):'';
			$r[$k]['lable']=explode(',',$r[$k]['lable']);
		}
		return $r;
	}
}

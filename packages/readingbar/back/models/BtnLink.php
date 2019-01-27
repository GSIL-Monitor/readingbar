<?php

namespace Readingbar\Back\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;
use DB;
class BtnLink extends Model
{
	public $table='btn_link';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name','link','style','position','display','status');
	static function getBtnLinks($position){
		 $return=self::leftjoin('btn_link_style','btn_link.style','=','btn_link_style.id')
			->where(['btn_link.status'=>1,'btn_link.position'=>$position,'del'=>0])
			->orderBy('btn_link.display','asc')
			->get(['btn_link.*','btn_link_style.blade','btn_link_style.class_name as class']);
		 
		foreach($return as $k=>$r){
			$return[$k]['html']=view($r->blade,$r);
		}
		 return $return;
	}
	static function getPostions(){
		return DB::table('btn_link_position')->get();
	}
	static function getStyles(){
		$return=DB::table('btn_link_style')->get();
		foreach($return as $k=>$r){
			$return[$k]->html=view()->exists($r->blade)?view($r->blade,['name'=>'replace_name','link'=>'replace_link','class'=>$r->class_name])->render():'视图不存在';
		}
		return $return;
	}
}

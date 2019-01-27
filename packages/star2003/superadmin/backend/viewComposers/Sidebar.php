<?php

namespace Superadmin\Backend\ViewComposers;

use Illuminate\Contracts\View\View;
use Auth;
use Superadmin\Backend\Models\Menu;
use Superadmin\Backend\Models\Role;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
class Sidebar
{
    /**
     * 用户仓库实现.
     *
     * @var UserRepository
     */
	protected $user;
    /**
     * 创建一个新的属性composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {
    	$this->user=Auth::user();
    }

    /**
     * 绑定数据到视图.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {	
    	$data['sidebar']=$this->getMenu();
    	$data['user']=$this->user;
    	$data['role']=Role::where("id","=",$this->user->role)->first()->name;
        $view->with($data);
    }
    public function getMenu(){
    	if($sidebar=Cache::get('menu_role_'.$this->user->role)){
    		$sidebar=unserialize($sidebar);
    	}else{
	    	$columns=array('id','pre_id','name','access','url','icon');
	    	$menus1=Menu::where('status','=',1)->where('rank','=',1)->orderBy('display','asc')->get($columns)->toArray();
	    	$menus2=Menu::where('status','=',1)->where('rank','=',2)->orderBy('display','asc')->get($columns)->toArray();
	    	$menus3=Menu::where('status','=',1)->where('rank','=',3)->orderBy('display','asc')->get($columns)->toArray();
	    	
	    	if($this->user->role!=1){  				//过滤无权限的菜单
	    		$accesses=Role::where('id','=',$this->user->role)->first()->accesses;
	    		if($accesses!=''){
	    			$accesses=unserialize($accesses);
	    			foreach ($menus1 as $key=>$m){
	    				if($m['access']!='' && !in_array($m['access'],$accesses)){
	    					unset($menus1[$key]);
	    				}
	    			}
	    			foreach ($menus2 as $key=>$m){
	    				if($m['access']!='' && !in_array($m['access'],$accesses)){
	    					unset($menus2[$key]);
	    				}
	    			}
	    			foreach ($menus3 as $key=>$m){
	    				if($m['access']!='' && !in_array($m['access'],$accesses)){
	    					unset($menus3[$key]);
	    				}
	    			}
	    		}
	    	}
	    	//生成菜单数组
	    	$sidebar=array();
	    	//1级菜单
	    	foreach ($menus1 as $m1){
	    		$m1['submenus']=array();
	    		//2级菜单
	    		foreach ($menus2 as $m2){
	    			if($m2['pre_id']==$m1['id']){
	    				$m2['submenus']=array();
	    				//3级菜单
	    				foreach ($menus3 as $m3){
	    					if($m3['pre_id']==$m2['id']){
	    						$m2['submenus'][]=$m3;
	    					}
	    				}
	    				//剔除无效菜单项
	    				if(count($m2['submenus']) || $m2['access']!=''){
	    					$m1['submenus'][]=$m2;
	    				}
	    			}
	    		}
	    		//剔除无效菜单项
	    		if(count($m1['submenus']) || $m1['access']!=''){
	    			$sidebar[]=$m1;
	    		}
	    	}
	    	Cache::store('file')->forever('menu_role_'.$this->user->role,serialize($sidebar));
    	}
    	return $sidebar;
    }
}
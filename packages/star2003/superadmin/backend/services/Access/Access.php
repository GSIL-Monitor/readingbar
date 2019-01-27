<?php

namespace Superadmin\Backend\Services\Access;
use Superadmin\Backend\Models\Role;
use Cache;
/**
 * Class Access
 * @package App\Services\Access
 */
class Access
{
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get the currently authenticated user or null.
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Get the currently authenticated user's id
     * @return mixed
     */
    public function id()
    {
        return auth()->id();
    }
    public function role()
    {
    	return auth()->user()->role;
    }
    /**
     * 检查用户角色权限
     * return bool
     * */
    public function allow($request){
    	$Action=$request->Route()->getAction();
    	$routeName=$Action['as'];
    	$d=explode('.',$routeName);
    	if($this->getRoleAccesses() && in_array($d[0].".".$d[1],$this->getRoleAccesses())){
    		return true;
    	}else{
    		return false;
    	}
    }
    /**
     * 获取角色权限
     * return array
     * */
    private function getRoleAccesses(){
    	 $role=$this->user()->role;
    	 
    	if($accesses=Cache::get('role_'.$role)){
    		$accesses=unserialize($accesses);
    		$accesses[]="admin.common";
    		return $accesses;
    	}else{
    		
    		$accesses=Role::where("id","=",$role)->first()->accesses;
    		Cache::store('file')->forever('role_'.$role,$accesses);
    		if($accesses==''){
    			return false;
    		}
    		$accesses=unserialize($accesses);
    		$accesses[]="admin.common";
    		return $accesses;
    	}
    }
    
}
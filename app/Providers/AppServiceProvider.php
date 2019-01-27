<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;
use View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    
    	View::addNamespace('back',base_path('packages/readingbar/back/views'));
        Validator::extend('image_scale', function($attribute, $value, $parameters) {
        	$image=getimagesize($value->getRealPath());
            return $parameters[0]/$parameters[1]==$image[0]/$image[1];
        });
        Validator::replacer('image_scale', function($message,$attribute, $value, $parameters) {
        		$message=str_replace(":width",$parameters[0],$message);
        		$message=str_replace(":height",$parameters[1],$message);
        		return $message;
        });
        //校验会员是否存在
        Validator::extend('exist_member', function($attribute, $value, $parameters) {
        	$r=DB::table('members')->where(['cellphone'=>$value])->orWhere(['email'=>$value])->count();
        	return $r?true:false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace Readingbar\Front\Composer;

use Illuminate\Contracts\View\View;
use Readingbar\Back\Models\Setting;
class SettingComposer
{
    /**
     * 用户仓库实现.
     *
     */
    protected $setting;

    /**
     * 创建一个新的属性composer.
     */
     
    public function __construct()
    {
       $rs=Setting::whereIn('key',['description','keywords'])->get(['key','value']);
       $this->setting=array();
       foreach ($rs as $v){
       		$this->setting[$v['key']]=$v['value'];
       }
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('setting',  $this->setting);
    }
}
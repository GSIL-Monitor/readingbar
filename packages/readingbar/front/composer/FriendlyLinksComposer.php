<?php

namespace Readingbar\Front\Composer;

use Illuminate\Contracts\View\View;
use Readingbar\Back\Models\FriendlyLink;
class FriendlyLinksComposer
{
    /**
     * 用户仓库实现.
     *
     */
    protected $friendly_links;

    /**
     * 创建一个新的属性composer.
     */
     
    public function __construct()
    {

      $this->friendly_links=FriendlyLink::where(['status'=>1,'del'=>0])->get();
    }

    /**
     * 绑定数据到视图.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('friendly_links',  $this->friendly_links);
    }
}
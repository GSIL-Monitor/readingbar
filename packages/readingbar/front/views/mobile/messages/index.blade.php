
<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section>
  <div data-am-widget="tabs" class="am-tabs astation-message">
    <ul class="am-tabs-nav station-message">
      <li class="am-active"><a href="[data-tab-panel-0]">查看消息</a></li>
      <li class=""><a href="[data-tab-panel-1]">留言</a></li>
    </ul>
    <!--/-->
    <div data-am-widget="list_news" class="am-tabs-bd am-list-news" >
        <div data-tab-panel-0 class="am-tab-panel am-active">
           @include('front::mobile.messages.messagesBox')
        </div>
        <!--/data-tab-panel-0  am-tab-panel-->
        <div data-tab-panel-1 class="am-tab-panel ">
           @include('front::mobile.messages.leaveMessage')
        </div>
        <!--/am-tab-panel-->
    </div>
  </div>
</section>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

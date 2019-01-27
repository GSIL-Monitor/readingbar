<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section>
    <div class="am-tabs astation-message" data-am-tabs="{noSwipe: 1}" id="doc-tab-demo-1">
		<ul class="am-tabs-nav my-orders-nav am-nav  ">
		    <li  class="am-active"><a href="javascript: void(0)">阅读评<br>测报告</a></li>
		    <li ><a href="javascript: void(0)">词汇<br>测试</a></li>
		    <li ><a href="javascript: void(0)">读写能力<br>分析报告</a></li>
		</ul>
		<!--/-->
        <div class="am-tabs-bd">
		    <div   class="am-tab-panel am-active  padding0 margintop10" >
		    	<iframe v-if="rpd.Ar_pdf_rar" width="100%" height="100%" :src="rpd.Ar_pdf_rar"></iframe>
		    	<div v-else style="text-align: center">数据暂无</div>
		    </div>
		    <!--/am-tab-panel-->
		    <div  class="am-tab-panel padding0 margintop10">
		    	<iframe v-if="rpd.Ar_pdf_vt" width="100%" height="100%" :src="rpd.Ar_pdf_vt"></iframe>
		    	<div v-else style="text-align: center">数据暂无</div>
		    </div>
		    <!--/am-tab-panel-->
		    <div  class="am-tab-panel padding0  margintop10 bgfff" >
		    	<iframe v-if="rpd.Ar_pdf_rwaar" width="100%" height="100%" :src="rpd.Ar_pdf_rwaar"></iframe>
		    	<div v-else style="text-align: center">数据暂无</div>
		     </div>
		    <!--/am-tab-panel-->
  		</div>
    </div>
</section>
<script type="text/javascript">
var rpd=new Vue({
	 el:"#doc-tab-demo-1",
	 data:{
		 rpd:{!! json_encode($rpd) !!}
	 }
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

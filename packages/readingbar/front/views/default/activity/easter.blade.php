<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/thanksgiving.css')}}">
<!-- 扩展内容-->
<div class="banner"><img src="{{url('home/pc/images/thanksgiving/fghj_02.jpg')}}" alt=""/></div>
<div class="container">
	<div class="row">
		<div class="col-md-6 hover-thtansgiving-01  hover-thtansgiving fl">
			<h4>价值<span>2988</span>现仅需<span>998</span>！<span>全国通用</span>！</h4>
			<p>图书借阅押金：<span>0</p>
			<p>适合人群：具有独立阅读能力<span>K-12</span>阶段的孩子</p>
			<p>服务内容：</p>
			<p>STAR & AR系统使用：<span>一年</span></p>
			<p>STAR测评分析报告：<span>3次</span></p>
			<p>阶段性成长报告：<span>半年一次</span></p>
			<p>*专属阅读定制服务：<span>0 </span></p><p>*专属阅读奖励计划：<span>0</span></p>
			<p>*阅读成长跟踪服务：<span>0</span></p>
			<p>*AR测试中文报告：<span></span>0</p>
			<p>*图书借阅: <span>自行购买</span></p>
		</div>
		<!-- //col-md-6-->
		<div class="col-md-6 hover-thtansgiving-02 hover-thtansgiving  fr">
			<h4>价值<span>9988</span>现仅需<span>5988</span>！<span>限北京用户</span>！</h4>
			<p>图书借阅押金：<span>500元</span></p>
			<p>适合人群：具有独立阅读能力<span>K-9</span>阶段的孩子</p>
			<p>服务内容： </p>
			<p>STAR & AR系统使用：<span>一年</span></p>
			<p>STAR测评分析报告：<span>3次</span></p>
			<p>阶段性成长报告：<span>半年一次</span></p><p>*专属阅读定制服务：<span>12次</span>  </p><p>*专属阅读奖励计划：<span>12次</span></p>
			<p>*阅读成长跟踪服务：<span>一年</span></p>
			<p>*AR测试中文报告：<span>80-100份</span></p>
			<p>*图书借阅: <span>50-100本</span></p>
		</div><!-- //col-md-6-->
	</div>
</div>
<div class="container" style="margin-bottom: 94px;"><img src="{{url('home/pc/images/thanksgiving/fghj_10.jpg')}}" alt="" class="marginout" /></div>



<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->

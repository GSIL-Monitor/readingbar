<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
	 <div class="banner">
       <img src="{{url('home/pc/images/banner/about_banner.png')}}">
    </div>
    <!--/banner-->
    <div class="content bgf5f5f5">
      <div class="container cont-about bgffff">
         <div class="bg01">
         	<div id="about-txt-01">
         		<p>基于美国大数据的英文分级阅读管理 更科学</p>
	            <p>致力于5-12岁孩子英语阅读习惯培养 更专业</p>
         	</div>
         	<div id="about-txt-02">
         		    <p>
         		    蕊丁吧是北京至诚天下网络科技有限公司旗下品牌，是国内第一家基于大数据应用的少儿英文分级阅读在线定制服务平台。
                   </p>
                   <br>
                   <p>
                   我们坚持让孩子进行纸质阅读，致力于培养中国本土7-12岁学生的英语阅读习惯。美国著名大数据在线教育软件公司Renaissance旗下明星产品STAR Test和AR Quiz，是美国最专业的英语分级阅读管理系统，蕊丁吧是其在中国的在线使用合作伙伴。我们有超过万册的原版英文书，通过STAR Test及AR Quiz两款美国最专业的英语分级阅读管理系统，经过专业老师的一对一定制服务，把适合孩子阅读的原版英文书送到家中。 
                   </p>
                   <br>
                   <p>
                   我们希望孩子可以在家轻松阅读、自主学习，不仅真正理解和掌握英语语言的本质，更能培养英语语言思维，提升国际化视野。
         	       </p>
         	</div>
         	<div id="about-txt-03">
         		<p>真正做到“孩子足不出户，阅读能力与<span>全美同步</span>;</p>
         		<p>海量的<span>原版进口英文图书</span>，满足5-12岁孩子的阅读需求，满足7-12岁孩子的阅读需求;</p>
         		<p><span>一对一</span>个性化定制服务，为学生定制科学的<span>阅读计划</span>全程跟进;</p>
         		<p>客观、专业的<span>大数据</span>分析，帮孩子选择符合他实际阅读水平的英文书;</p>
         		<p>个性化阅读奖励计划，鼓励学生完成各种<span>趣味阅读</span>任务，进而激发阅读兴趣;</p>
         		<p>配送服务，由专业物流提供配送，<span>顺丰</span>到付还书。</p>
         	</div>
         </div>
      </div>
    </div>
<!-- /content end -->
@endsection
<!-- //继承整体布局 -->

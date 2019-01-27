<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<article>

	<div class="container">
		 <img src="{{url('home/wap/images/about/banner.jpg')}}" class="am-img-responsive" alt=""/>
	</div>
	<div class="container pab15">
	        <div class="about-title">关于我们</div >
         	<div id="about-txt-01">
         		<p>基于美国大数据的英文分级阅读管理 更科学</p>
	            <p>致力于5-12岁孩子英语阅读习惯培养 更专业</p>
         	</div>
         	<div id="about-txt-02" class="about-txt-02">
         		    <p>
         		    蕊丁吧是北京至诚天下网络科技有限公司旗下品牌，是国内第一家基于大数据应用的少儿英文分级阅读在线定制服务平台。
                   </p>
                   <br>
                   <p>
                   我们坚持让孩子进行纸质阅读，致力于培养中国本土5-12岁学生的英语阅读习惯。美国著名大数据在线教育软件公司Renaissance旗下明星产品STAR Test和AR Quiz，是美国最专业的英语分级阅读管理系统，蕊丁吧是其在中国的在线使用合作伙伴。我们有超过万册的原版英文书，通过STAR Test及AR Quiz两款美国最专业的英语分级阅读管理系统，经过专业老师的一对一定制服务，把适合孩子阅读的原版英文书送到家中。 
                   </p>
                   <br>
                   <p>
                   我们希望孩子可以在家轻松阅读、自主学习，不仅真正理解和掌握英语语言的本质，更能培养英语语言思维，提升国际化视野。
         	       </p>
         	</div>
         	<div id="about-txt-03">
         		 <img src="{{url('home/wap/images/about/about_07_06.jpg')}}" class="am-img-responsive" alt=""/>
         	</div>
    </div>
</article>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

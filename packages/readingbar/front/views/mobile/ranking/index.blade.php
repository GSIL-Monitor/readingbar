@extends('front::mobile.common.main') @section('content')
<section>
	<div class="container">
		<img src="{{url('home/wap/images/ranking/cc_01.jpg')}}" class="am-img-responsive pad-t10" alt="">
		<img src="{{url('home/wap/images/ranking/cc_02.jpg')}}" class="am-img-responsive pabt10" alt="">
		<div class="readingbooks-ranking">
			<i></i>
			<span>{{ $date }}Reading Books 最高为 <b>{{ $max_books }}</b> 本书</span>
		</div>
		<ul class="readingbooks-ranking-list ">
			@foreach($books as $k=>$b)
			<li class="am-g">
				<div class="am-u-sm-2 fl">
					<img data-original="//cdn.avatar.qdfuns.com/000/01/14/11445_01b6397888c09d84f3dc89d807aa1004_small.jpg" src="{{ $b->avatar }}" >
					<em><img src="{{url('home/wap/images/ranking/o.png')}}"></em>
				</div>
				<div class="am-u-sm-8 fl">
					<p><span class="fl">{{ $b->nick_name }}</span><span class="fr">{{ $b->grade }}</span></p>
					<p><span>{{ $b->star_account }}</span></p>
				</div>
			</li>
			@endforeach
		</ul>
		<div class="reading-bj100"></div>
		<img src="{{url('home/wap/images/ranking/cc_04.jpg')}}" class="am-img-responsive pad-t20" alt="">
		<div class="readingbooks-ranking margintop10">
			<i></i>
			<span>{{ $date }}Reading Words 最高为<b>{{ $max_words }}</b> 单词</span>
		</div>
		<ul class="readingbooks-ranking-list ">
			@foreach($words as $k=>$b)
			<li class="am-g">
				<div class="am-u-sm-2 fl">
					<img data-original="//cdn.avatar.qdfuns.com/000/01/14/11445_01b6397888c09d84f3dc89d807aa1004_small.jpg" src="{{ $b->avatar }}" >
					<em><img src="{{url('home/wap/images/ranking/o.png')}}"></em>
				</div>
				<div class="am-u-sm-8 fl">
					<p><span class="fl">{{ $b->nick_name }}</span><span class="fr">{{ $b->grade }}</span></p>
					<p><span>{{ $b->star_account }}</span></p>
				</div>
			</li>
			@endforeach
			</ul>
			 <img src="{{url('home/wap/images/ranking/cc_06.jpg')}}" class="am-img-responsive pad-t20" alt="">
			 <ul class="readingbooks-ranking-not">
			 	<li>小达人排行不分先后，能上榜就是好样滴~</li>
				<li>蕊丁吧所有付费小会员均可冲击排行榜前十名</li>
				<li>所有上榜小达人均可获赠金币奖励</li>
				<li>金币可用来兑换相应奖品（功能即将上线）</li>
				<li>所有数据来自AR测试系统后台</li>
				<li>每月10日更新上月达人排行（如遇休息日顺延）</li>
				<li>对排行榜有疑问的爸爸妈妈，请拨打客服热线咨询</li> </li>
				<li>蕊丁吧全国统一客服热线：400 625 9800</li>
			 </ul>
		
	</div>	
</section>
@endsection


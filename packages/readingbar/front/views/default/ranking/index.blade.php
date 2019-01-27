<!-- 继承整体布局 -->
@extends('front::default.common.main')
@section('content')
<link rel="stylesheet" type="text/css" href="{{url('home/pc/css/ranking.css')}}">
<div class="container padt15"><img src="{{url('home/pc/images/ranking/ranking_07.png')}}" class="ranking-img01"></div>
<div class="container">
	<div class="ranking-main">
		<div class="ranking-main-01"><img src="{{url('home/pc/images/ranking/ranking_11.png')}}"></div>
		<div class="ranking-main-02"><img src="{{url('home/pc/images/ranking/ranking_17.png')}}" class="ranking-title1" ><span class="fr">{{ $date }}Reading Books 最高为 <b>{{ $max_books }}</b> 本书</span></div>
		<div class="ranking-main-03">
			<ul>
				@foreach($books as $k=>$b)
				<li class="ranking-book-{{ $k+1 }}">
					<div class="ranking-book-heard"><img src="{{ $b->avatar }}" style="width: 46px;height:46px"></div>
					<span class="ranking-book-name">{{ $b->nick_name }}</span>
					<span class="ranking-book-mc">{{ $b->star_account }}</span>
					<span class="ranking-book-grade">{{ $b->grade }}</span>
					<em class="ranking-book-bj"></em>
				</li>
				@endforeach
			</ul>
		</div>
		<div class="ranking-main-02"><img src="{{url('home/pc/images/ranking/ranking_18.png')}}" class="ranking-title2" ><span class="fr">{{ $date }}Reading Words 最高为 <b>{{ $max_words }}</b> 单词</span></div>
		<div class="reading-main">
			<ul>
			
				@foreach($words as $k=>$b)
				<li class="reading-book-{{ $k+1 }}">
					<div class="reading-book-heard">
						<img src="{{ $b->avatar }}" style="width: 46px;height:46px">
						<em class="reading-main-bj"></em>
					</div>
					<span class="ranking-book-name">{{ $b->nick_name }}</span>
					<span class="ranking-book-mc">{{ $b->star_account }}</span>
					<span class="ranking-book-grade">{{ $b->grade }}</span>
			    </li>
				@endforeach
			</ul>
		</div>
		<!--/-->
	</div>
	<div class="ranking-main2">
		<div class="ranking-main2-title"><img src="{{url('home/pc/images/ranking/ranking_21.png')}}"></div>
		<div class="ranking-news">
			<ul class="fl">
				<li>小达人排行不分先后，能上榜就是好样滴~</li>
				<li>蕊丁吧所有付费小会员均可冲击排行榜前十名</li>
				<li>所有上榜小达人均可获赠蕊丁币奖励</li>
				<li>蕊丁币可到商城兑换礼物</li>
			</ul>
			<ul class="fr">
				<li>所有数据来自AR测试系统后台</li>
				<li>每月10日更新上月达人排行（如遇休息日顺延）</li>
				<li>对排行榜有疑问的爸爸妈妈，请拨打客服热线咨询 </li>
				<li>蕊丁吧全国统一客服热线：400 625 9800</li>

			</ul>
		</div>
	</div> 
</div>





@endsection
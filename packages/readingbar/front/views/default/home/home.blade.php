<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<style>
body{background-color:#f5f5f5;}
</style>
<section>
	<div class="container " style="position: relative;">
			<div class="fl index-left">
				  <div id="myCarousel" class="carousel slide">
					  <!-- 轮播（Carousel）指标 -->
					  <ol class="carousel-indicators"> 
				    	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1" ></li>
						<li data-target="#myCarousel" data-slide-to="2" ></li>
					  </ol> 
					  <!-- 轮播（Carousel）项目 -->
					  <div class="carousel-inner">
					  		<div class="item active"><a href="{{ url('activity/PublicBenefitActivities') }}"><img src="{{url('home/pc/images/banner/20171120.png')}}"  class="am-img-responsive"></a></div>
					  		<div class="item"><a href="{{ url('activity/50FamousWriters') }}"><img src="{{url('home/pc/images/banner/2017-10-20.png')}}"  class="am-img-responsive"></a></div>
					  		<div class="item" ><a href="javascript:void(0)"><img src="{{url('home/pc/images/banner/2017-6-1.jpg')}}"  class="am-img-responsive"></a></div>
					  </div>
					  <!-- 轮播（Carousel）导航 -->
					</div>
			</div>
			<div class="fr index-right"  >
					<a href="{{ config('readingbar.starTestWebSite') }}" target="_blank" class="index-top-btn index-top-btn1">
					</a>
					<a href="{{ url('introduce/userGuide') }}" target="_blank" class="index-top-btn index-top-btn2">
					</a>
			</div>

		<div class="index-btn-rdsz">
			
			<a href="{{ url('introduce/RDMessenger') }}" class="btn-rdsz-02"><img src="{{ asset('home/pc/images/2017/rdsz-02.png')}}"></a>
		</div>

	</div>
	
	<script>
		$('#myCarousel').carousel({
			interval:4000
		});
		//
		
	</script>
	<div class="container" style="margin-top: 45px">
			<div class="fl index-left" id='Articles'>
				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-local1 font-16 color333333">
						  <li role="presentation" class="col-xs-3 active" id="0" v-on:click="selectCondition('0')"><span>最新</span></li>
						  <li role="presentation" class="col-xs-3" id="约→书" v-on:click="selectCondition('荐书')"><span>荐书</span></li>
						  <li role="presentation" class="col-xs-3" id="优荐" v-on:click="selectCondition('优荐')"><span>优荐</span></li>
						  <li role="presentation" class="col-xs-3" id="大咖秀" v-on:click="selectCondition('大咖秀')"><span>大咖秀</span></li>
						</ul>
					</div>
				</div>
				<div style="clear:both"></div>
				<div class="row">
					<div class="col-xs-12">
						<ul class="readi-sharing" v-if="articles">
				      		<li v-for="r in articles.data" >
				      			<div class="readi-sharing-img col-xs-3"><a :href="r.url"  target="_blank"  :style="'background:url('+r.title_image+') center no-repeat ;background-size:100% auto;display:block;width:100%;height:100%;'"> </a></div>
				      			
				      			<div class="readi-sharing-briefing col-xs-9">
				      				<h4><a :href="r.url" target="_blank">[[ r.title ]]</a></h4>
				      				<p>[[ r.summary]]</p>
				      				<p class="readi-sharing-bq" v-if="r.lable.length">
				      					<span v-for='l in r.lable' v-if="$index<5">[[ l ]]</span>
				      				</p>
				      				<p class="readi-sharing-data">[[ r.created_at]]</p>
				      			</div>
				      		</li>
				      	</ul>
					</div>
					<div class="col-xs-12 text-center" >
						<template v-if="loadStatus">
							
								<ul class='loading-local1'>
									<li class="node1"></li>
									<li class="node2"></li>
									<li class="node3"></li>
								</ul>
								<span class="color333333">数据加载中</span>
							
						</template>
						<template v-else>
								<span class="color333333" v-if="page>articles.last_page"><br>已经加载到底了</span>
								<span class="color333333" v-else><br>下拉加载数据</span>
						</template>
					</div>
				</div>
					
			</div>
			<script type="text/javascript">
				/*文章控件*/
				new Vue({
					el:"#Articles",
					data:{
						articles:null,
						keyword:"",
						page:1,
						loadStatus:false,
						limit:5
					},
					created:function(){
						this.getList();
						this.scrollLoad();
					},
					methods:{
						/*获取文章列表*/
						getList:function(){
							var _this=this;
							if(_this.loadStatus){
								return false;
							}else{
								_this.loadStatus=true;
							}
							$.ajax({
								url:"{{ url('article/getList')}}",
								data:{
									keyWord:_this.keyword,
									page:_this.page,
									limit:_this.limit
								},
								dataType:"json",
								success:function(json){
									if(_this.page>1){
										for(i in json.data){
											_this.articles.data.push(json.data[i]);
										}
									}else{
										_this.articles=json;		
									}
									_this.loadStatus=false;
								}
							});
						},
						/*选择显示条件*/
						selectCondition:function(c){
							this.keyword=c;
							this.page=1;
							this.articles=[],
							this.getList();
							$("#Articles li").removeClass('active');
							$("#Articles #"+c).addClass('active');
						},
						/*滚动至底部加载数据*/
						scrollLoad:function(){
							var _this=this;
							$(document).scroll(function(){  
								if((document.body.scrollHeight-(document.body.clientHeight+document.body.scrollTop))<2){
									if(!_this.loadStatus){
										_this.page++;
										_this.getList();
									}
								}
							});  
						}
					}
				});
			</script>
			<div class="fr index-right">
					<div class="row">
						<div class="col-xs-12"> 
							<div class="notice">
								<div class="notice-title">
									公告
								</div>
								<ul class="notice-list">
								   @foreach($notices as $n)
										<li><a href="{{ $n->url  }}" class="color4bd2bf">{{ $n->notice }}</a></li>
								   @endforeach
								</ul>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-xs-12">
							@foreach($btn_links_pc as $b)
								{!! $b->html !!}
							@endforeach
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-xs-12">
							<a href="{{ url('customer/idea')}}" class="index-right-btn-4" target="_blank">
									<img alt="icon" src="{{ asset('home/pc/images/index/index-btn4.png')}}">
							</a>
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-xs-12">
							<div class="right-company">
								<img alt="" src="{{ asset('home/pc/images/index/qrcode.png')}}">
								<br><br>
								<p class="right-company-title">
								 	<strong >
								 		合作伙伴
								 	</strong>
							 	</p>
							 	<br>
						 		<hr style="border:1px  dashed white;width:80%;margin:0 auto" />
						 		<br>
						 		@foreach($friendly_links as $v)
						 		<a href="{{ $v->link }}">
						 			<p>{{ $v->partner }}</p>
						 		</a>
						 		@endforeach
						 		<br>
						 		<hr style="border:1px  dashed white;width:80%;margin:0 auto" />
						 		<br>
						 		<p class="right-company-title">
								 	<strong >
								 		加入合作请联系
								 	</strong>
							 	</p>
							 	<br>
							 	<hr style="border:1px  dashed white;width:80%;margin:0 auto" />
							 	<br>
							 	<p>联系人:Mary</p>
							 	<p>电话:010-58643050</p>
							 	<p>邮箱:biz@readingbar.net</p>
							 	<br>
							 	<hr style="border:1px  dashed white;width:80%;margin:0 auto" />
							 	<br>
							 	<a href="{{ url('protocol/register') }}">
						 			<p>蕊丁吧用户协议</p>
						 		</a>
						 		<a href="{{ url('introduce/joinus') }}">
						 			<p>蕊丁吧招聘</p>
						 		</a>
						 		<br>
						 		<hr style="border:1px  dashed white;width:80%;margin:0 auto" />
						 		<br>
							 	<p>京ICP备16035931号</p>
							 	<p>北京至诚天下网络科技有限公司</p>
							 	<br><br>
							</div>
						</div>
					</div>
			</div>
			<a href="#" class="index-btn-backtop"></a>
	</div>
	<br>
	<br>
	<br>
	<br>
	<!--/-->
	
</section>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

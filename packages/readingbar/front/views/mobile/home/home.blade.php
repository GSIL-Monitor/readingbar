<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')

 <div data-am-widget="slider" class="am-slider am-slider-b1" data-am-slider='{&quot;controlNav&quot;:false}' >
  <ul class="am-slides">
  <!---->
  		
  		<li>
        	<a href="{{ url('activity/PublicBenefitActivities') }}">
	          <img src="{{url('home/wap/images/banner/20171120.png')}}" class="am-img-responsive" alt=""/>
	        </a>
	    </li>
        <li>
        	<a href="{{ url('activity/50FamousWriters') }}">
	          <img src="{{url('home/wap/images/banner/2017-10-20.png')}}" class="am-img-responsive" alt=""/>
	        </a>
	    </li>
	    <li>
	        <a href="javascript:void(0)">
	          <img src="{{url('home/wap/images/banner/2017-6-1.jpg')}}" class="am-img-responsive" alt=""/>
	        </a>
	    </li>
  </ul>
</div>
<div class="t-btn-index-wap-container-20171211">
	<div>
		<div>
			@foreach($btn_links_wap as $a)
			   			{!! $a->html !!}
			@endforeach
		</div>
	</div>
</div>
<div style="border-top: 1px solid black;border-bottom: 1px solid black;background:#f0f0f0;height:5px;"></div>
<!-- 公告轮播 -->
<style type="text/css">
.qimo8{ overflow:hidden; width:100%;}
.qimo8 .qimo {width:8000%; height:26px;}
.qimo8 .qimo div{ float:left;}
.qimo8 .qimo ul{float:left; height:26px; overflow:hidden; zoom:1; }
.qimo8 .qimo ul li{float:left; line-height:26px; list-style:none;}
.qimo8 li a{color: #49d2be;font-size: 1.4rem;padding-right: 25px;}
.am-control-nav{display: none;}
.am-thumbnail{ margin: 0}
.margin-top20{margin-top: 20px;}
</style>
<br>
@if(count($notices))
<div id="notice">
  <div  class="am-g notice">
       <div class="am-u-sm-4" id="notice-title"  style="width: 20%;padding-right: 0;"><h1><strong>公告:</strong></h1></div>
        <div class="am-u-sm-8" id="notice-list" style="width: 80%;padding-left: 0;">
          <div id="demo" class="qimo8">
            <div class="qimo">
              <div id="demo1">
                <ul>
                  @foreach($notices as $n)
                 <li><a href="{{ $n->url }}"  target="_blank"  >{{ $n->notice }}</a></li>
                 @endforeach   
                 </ul>
              </div>
              <div id="demo2"></div>
            </div>
          </div>
    </div>
  </div>
</div>
@endif
<br>
<script type="text/javascript">
  var demo = document.getElementById("demo");
  var demo1 = document.getElementById("demo1");
  var demo2 = document.getElementById("demo2");
  demo2.innerHTML=document.getElementById("demo1").innerHTML;
  function Marquee(){
  if(demo.scrollLeft-demo2.offsetWidth>=0){
   demo.scrollLeft-=demo1.offsetWidth;
  }
  else{
   demo.scrollLeft++;
  }
  }
  var myvar=setInterval(Marquee,30);
  demo.onmouseout=function (){myvar=setInterval(Marquee,30);}
  demo.onmouseover=function(){clearInterval(myvar);}
</script>
<!-- /公告轮播 -->
<!-- 扩展内容-->
<div id="Articles">
	<div data-am-widget="tabs"  class="am-tabs am-tabs-d2 tabs-local">
	      <ul class="am-tabs-nav am-cf">
	          <li class="am-active"><a href="[data-tab-panel-0]" id="0" v-on:click="selectCondition('0')">最新</a></li>
	          <li class=""><a href="[data-tab-panel-1]" id="约→书" v-on:click="selectCondition('荐书')">荐书</a></li>
	          <li class=""><a href="[data-tab-panel-2]" id="优荐" v-on:click="selectCondition('优荐')">优荐</a></li>
	          <li class=""><a href="[data-tab-panel-3]" id="大咖秀" v-on:click="selectCondition('大咖秀')">大咖秀</a></li>
	      </ul>
	</div>
	<div>
		<ul class="op-list" v-for="r in articles.data">
			<li>
				<h4>[[ r.title]]</h4>
				<p><b>[[ r.created_at]]</b></p>
				<p><span v-for='l in r.lable' v-if="$index<5">[[ l ]]</span>
				</p>
				<p><img :src="r.title_image"  alt=""/></p>
				<p>[[ r.summary]]</p>
				<p><a :href="r.url">详情<i class="am-icon-angle-right fr"></i></a></p>
			</li>
		</ul>
		<div calss="am-u-md-12" style="text-align: center ">
			<template v-if="loadStatus">
					<ul class='loading-local1'>
						<li class="node1"></li>
						<li class="node2"></li>
						<li class="node3"></li>
					</ul>
					<span class="color333333">数据加载中</span>
			</template>
			<template v-else>
					<span class="color333333" v-if="page>articles.last_page">已经加载到底了</span>
					<span class="color333333" v-else>下拉加载数据</span>
			</template>
		</div>
	</div>
</div>

<script type="text/javascript">
	/*文章控件*/
	new Vue({
		el:"#Articles",
		data:{
			articles:[],
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
				$("#Articles li").removeClass('am-active');
				$("#Articles #"+c).addClass('am-active');
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
</section>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

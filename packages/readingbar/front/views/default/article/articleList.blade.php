<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<article>
<!-- 扩展内容-->
	 @include('front::default.common.banner')
    <!--/banner-->
    <div class="container">
      	<ul class="readi-sharing">
      		<li v-for="r in articles.data">
      			<div class="readi-sharing-img col-md-3"><a :href="r.url" target="_blank"> <img :src="r.title_image" alt=""></a></div>
      			<div class="readi-sharing-briefing col-md-9">
      				<h4><a :href="r.url" target="_blank">[[ r.title ]]</a></h4>
      				<p>[[ r.summary]]</p>
      				<p class="readi-sharing-bq" v-if="r.lable.length">
      					<span v-for='l in r.lable' v-if="$index<5">[[ l ]]</span>
      				</p>
      				<p class="readi-sharing-data">[[ r.created_at]]</p>
      			</div>
      		</li>
      	</ul>
      	<ul class="pagination pull-right" v-if="articles.last_page > 1">
	    	<li v-if="articles.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
    		<template v-for="p in articles.last_page" v-if="Math.abs(articles.current_page-(p+1))<=3">
    			<li v-if="articles.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
    		</template>
	     	<li v-if="articles.current_page < articles.last_page" v-on:click="doChangePage(articles.last_page)"><a>»</a></li>
     	</ul>
    </div>
    	
 </article>
<!-- /content end -->

<script type="text/javascript">
var articles=new Vue({
	el:"article",
	data:{
		articles:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		}
	},
	created:function(){
		this.doGetArticles();
	},
	methods:{
		//获取文章列表
		doGetArticles:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return ;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('api/article/getWxArticlesList') }}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					_this.articles=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//翻页
		doChangePage:function(page){
			this.search.page=page;
			this.doGetArticles();
		}
	}
});
</script>
@endsection
<!-- //继承整体布局 -->

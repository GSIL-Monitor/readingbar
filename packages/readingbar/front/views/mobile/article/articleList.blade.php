<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<article>
	@include('front::mobile.common.banner')
	<div class="container pab15" data-am-widget="list_news" >
		<ul class="op-list" v-for="r in articles">
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
	    <div class="am-list-news-ft">
        	<a class="am-list-news-more am-btn am-btn-20 " href="javascript:void(0)" v-on:click="doLoadMore()">查看更多 &raquo;</a>
        </div>

	</div>
</article>
<script type="text/javascript">
var articles=new Vue({
	el:"article",
	data:{
		articles:null,
		search:{
			page:1,
			limit:5,
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
					if(_this.articles){
						for(i in json.data){
							_this.articles.push(json.data[i]);
						}
					}else{
						_this.articles=json.data;
					}
					_this.search.page++;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//加载更多
		doLoadMore:function(page){
			this.doGetArticles();
		}
	}
});
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

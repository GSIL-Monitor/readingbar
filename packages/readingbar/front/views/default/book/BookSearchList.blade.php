<!-- 继承整体布局 -->
@extends('front::default.common.main')
@section('content')
<div class="container" >
    <div class="row padt9">
	 	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	 	</div>
	  	<!--/ home-column-fl end-->
	    <div class="col-md-10 home-column-fr100 padding-0" id="main">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">书单检索</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content">
             	<div class="booksearch">
             		<form action="" class="form-horizontal row" role="form" onsubmit='return false'>
             			<div class="fl col-md-3" style="width: 241px;">
							<label for="" class="fl control-label int-name">级别范围：</label>
							<div class="col-sm-8 fl">
								<input type="text" class="form-control int-mon"  id="norms"  v-model='ready_search.BL' placeholder='例:1-5'>
							</div>
						</div>
						<!--/form-group-->
						<div class=" fl col-md-3" style="    width: 213px;">
							<label for="" class="fl control-label int-name">主题：</label>
							<div class="col-sm-8">
								<select class="form-control int-mon"  v-model='ready_search.topic'>
									<option value=''>请选择</option>
									<option v-for='tp in topics' :value='tp'>[[ tp ]]</option>
								</select>
							</div>
						</div>
						<!--/form-group-->
						<div class=" fl col-md-3" style="width: 241px;">
							<label for="" class="fl control-label int-name">兴趣年级：</label>
							<div class="col-sm-8">
								<select class="form-control int-mon"  v-model='ready_search.IL'>
									<option value=''>请选择</option>
									<option v-for='IL in ILS' :value='IL'>[[ IL ]]</option>
								</select>
							</div>
						</div>
						<div class=" fl col-md-3" style="    width: 209px;">
							<label for="" class="fl control-label int-name">体裁：</label>
							<div class="col-sm-8">
								<select class="form-control int-mon"  v-model='ready_search.type'>
									<option value=''>请选择</option>
									<option value='Fiction'>Fiction</option>
									<option value='Nonfiction'>Nonfiction</option>
								</select>
							</div>
						</div>
						<!--/form-group-->
						<div class=" fl col-md-12">
							<button class=" button-01 update_member_avatar"  v-on:click="doSearch()" style="    margin-right: 40px;
    margin-top: 20px; float: right;">搜索</button>
						</div>
						<!--/form-group--> 
             		</form>
             	</div>
             	<!--/booksearch-->
             	<div class="booksearch-result">
             		<p class="booksearch-related">为您找到相关结果[[ listdata.total ]]个</p>
             		<ul class="booksearch-list">
             			<li v-for='d in listdata.data'>
             				<div class="booksearch-mdular1 row">
             					<div class="fl col-md-2 booksearch-cover">
             						<img  :src="d.image" style="max-height: 105px;width:auto;margin:0 auto">
             					</div>
             					<div class="fl col-md-10">
             						<div class="booksearch-mdular2">
             							<h4>[[ d.book_name ]]<span>(AR Quiz No:[[ d.ARQuizNo ]] [[ d.language ]] [[ d.type ]])</span>  </h4>
             							<div id="booksearch-stars"  :style="'width:'+d.rating/5*70+'px'">
             								<img alt="rating" src="{{ asset('home/pc/images/star_rating.png') }}" style='max-height:15px'>
             							</div>
             						</div>
             						<div class="booksearch-mdular3">
             							<div class="fl">
             								<span>AR Quiz Types</span>
             								<p>[[ d.ARQuizType ]]</p>
             							</div>
             							<div class="fl">
	             							<span>BL</span>
	             							<p>[[ d.BL ]]</p>
             							</div>
             							<div class="fl">
	             							<span>IL</span>
	             							<p>[[ d.IL ]]</p>
             							</div>
             							<div class="fl">
	             							<span>AR Pts</span>
	             							<p>[[ d.ARPts ]]</p>
             							</div>
             							<div class="fl">
	             							<span>词汇量</span>
	             							<p>[[ d.WordCount ]]</p>
             							</div>
             							
             						</div>
             					</div>
             				</div>
             				<div class="booksearch-introduction row">
             					<p><span>作者：</span><b>[[ d.author ]]</b></p>
             					<p><span>简介：</span> [[ d.summary ]]([[ d.publisher ]]） </p>
             				</div>
             			</li>
             		</ul>
             		<!--/-->
					<ul class="pagination fr" v-if="listdata.last_page>1">
					    <li><a v-if="1!=listdata.current_page" v-on:click="doChangePage(1)">&laquo;</a></li>
					    <template  v-for="p in listdata.last_page" v-if="Math.abs(p+1-listdata.current_page)<4">
					    	<li v-if="listdata.current_page==p+1" class="active"><a href="javascript:void(0)" v-on:click="doChangePage(p+1)">[[ p+1 ]]</a></li>
					    	<li v-else><a href="javascript:void(0)" v-on:click="doChangePage(p+1)">[[ p+1 ]]</a></li>
					    </template>
					    <li><a v-if="listdata.last_page!=listdata.current_page" v-on:click="doChangePage(listdata.last_page)">&raquo;</a></li>
					</ul>
				<!--/-->
             	</div>
             	<!--/booksearch-list-->
            </div>
		    <!--/content-->
		</div>
	</div>
</div>
<script type="text/javascript">
var test=new Vue({
	el:'#main',
	data:{
		listdata:null,
		search:{
			page:1,
			limit:5,
			ajaxStatus:false,
		},
		ready_search:{
			grade:null,
			topic:'',
			BL:'',
			type:'',
			IL:''
		},
		ILS:['LG','MG','MG+','UG'],
		topics:['Adventure','Animals','Award Winners','Behavior','Biographies/Autobiographies','Careers','Character Traits','Clothing and Dress','Community Life',
				'Disasters','Emotions','Fairy Tales','Family Life','Fantasy/Imagination','Food','Health','History','Holidays','Interpersonal Relationships',
				'Legendary Characters','Mysteries','Natural Environments','People','Places','Poetry','Plants','School','Seasons/Weather','Social','Sports','Spy','Transportation','Wars']
	},
	created:function(){
		this.doSearchBooks();
	},
	methods:{
		doSearchBooks:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return false;
			}
			$.ajax({
				url:"{{ url('member/booksearch/doSearchBooks') }}",
				data:_this.search,
				dataType:"json",
				beforeSend:function(){
					_this.search.ajaxStatus=true;
				},
				success:function(json){
					_this.listdata=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		doChangePage:function(page){
				this.search.page=page;
				this.doSearchBooks();
		},
		doSearch:function(){
			for(i in this.ready_search){
				this.search[i]=this.ready_search[i];
			}
			this.doSearchBooks();
		}
	}
});

</script>
@endsection
<!-- //继承整体布局 -->

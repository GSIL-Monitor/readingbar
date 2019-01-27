
<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<!-- 扩展内容-->
<section id="main">

    <div class="am-tabs astation-message" data-am-tabs="{noSwipe: 1}" id="doc-tab-demo-1">
		<ul class="am-tabs-nav my-orders-nav am-nav">
		
		    <li class="am-active" style="width: 50%;"><a href="javascript: void(0)">级别范围</a></li>
		    <li style="width: 50%;"><a href="javascript: void(0)">主题</a></li>
		    <li style="width: 50%;  border-right: solid 1px #eeeeee;"><a href="javascript: void(0)">兴趣年级</a></li>
		    <li style="width: 50%;"><a href="javascript: void(0)">体裁</a></li>
		</ul>
		<!--/-->
        <div class="am-tabs-bd">
		    <div class="am-tab-panel am-active listbg-ebebeb">
		        <input type="text" class="am-form-field am-round" id="norms"  v-model='ready_search.BL' placeholder='例:1-5' v-on:change="doSearch()">
		    </div>
		    <!--/am-tab-panel-->
		    <div class="am-tab-panel listbg-ebebeb">
		     		<select id="doc-select-1" class="am-form-field am-round"  v-model='ready_search.topic' v-on:change="doSearch()">
					<option value=''>请选择</option>
					<option v-for='tp in topics' :value='tp'>[[ tp ]]</option>
				</select>
		    </div>
		    <!--/am-tab-panel-->
		    <div class="am-tab-panel listbg-ebebeb">
		     	<select id="doc-select-1" class="am-form-field am-round"  v-model='ready_search.IL' v-on:change="doSearch()">
					<option value=''>请选择</option>
					<option v-for='IL in ILS' :value='IL'>[[ IL ]]</option>
				</select>
		    </div>
		    <!--/am-tab-panel-->
		    <div class="am-tab-panel listbg-ebebeb">
		     	<select id="doc-select-1" class="am-form-field am-round"  v-model='ready_search.type' v-on:change="doSearch()">
					<option value=''>请选择</option>
					<option value='Fiction'>Fiction</option>
					<option value='Nonfiction'>Nonfiction</option>
				</select>
		    </div>
		    <!--/am-tab-panel-->
  		</div>
    </div>
    <!--/am-tabs-->
    <template v-for='d in listdata.data'>
	    <div class="booksearch-list" data-am-widget="list_news">
	    	<p>AR Quiz No:[[ d.ARQuizNo ]] [[ d.language ]] [[ d.type ]]</p>
	    	<h4>[[ d.book_name ]]</h4>
	    	<ul class="am-g">
	    		<li class="am-u-sm-4 text-center"><img class="item-pic" :src="d.image" style="max-height:60px;width:auto"></li>
	    		<li class="am-u-sm-4"><span>BL</span><b>[[ d.BL ]]</b></button></li>
	    		<li class="am-u-sm-4"><span>IL</span><b>[[ d.IL ]]</b></button></li>
	    	</ul>
	    	<span><b>作者：</b>[[ d.author ]]</span>
	    	<span><b>简介：</b>[[ d.summary ]]([[ d.publisher ]]）</span>
		</div>
		<div class="box-10"></div>
	</template>

  <!--更多在底部-->
      <div class="am-list-news-ft">
        <a class="am-list-news-more am-btn am-btn-default " href="javascript:void(0)"  v-on:click="doLoadMore()">查看更多 &raquo;</a>
      </div>

</section>
<script type="text/javascript">
new Vue({
	el:'#main',
	data:{
		listdata:null,
		search:{
			page:1,
			limit:10,
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
					if(_this.listdata){
						for(i in json.data){
							_this.listdata.data.push(json.data[i]);
						}
					}else{
						_this.listdata=json;
					}
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		doLoadMore:function(){
				this.search.page++;;
				this.doSearchBooks();
		},
		doSearch:function(){
			this.listdata=null;
			this.search.page=1;
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

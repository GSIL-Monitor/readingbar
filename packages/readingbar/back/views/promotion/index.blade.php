@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'List' }}</h2>
                    <ol class="breadcrumb">
                    	@foreach($breadcrumbs as $b)
                        <li>
                        	@if($b['active'])
                            	<strong class="active">{{ trans($b['name']) }}</strong>
                        	@else
                        		<a href="{{$b['url']!=''?url($b['url']):'javascript:void(0);'}}">{{ trans($b['name']) }}</a>
                        	@endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<div class="wrapper wrapper-content animated fadeInRight" id="promotionsList">
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	推广员
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	推广码
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	推广员类型
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	合作起始时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	推广人数
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	定制阅读会员数
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	自主阅读/综合系统服务会员数
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	定制阅读单次体验会员数
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	阅读能力测评会员数
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in promotions.data">
		                        <td class="footable-visible footable-first-column">[[r.id]]</td>
		                        <td class="footable-visible">[[r.nickname]]</td>
		                        <td class="footable-visible">[[r.pcode]]</td>
		                        <td class="footable-visible">[[r.type]]</td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                        <td class="footable-visible">[[r.members]]</td>
		                        <td class="footable-visible">[[r.product1]]</td>
		                        <td class="footable-visible">[[r.product3 + r.product18]]</td>
		                        <td class="footable-visible">[[r.product2+r.product6]]</td>
		                        <td class="footable-visible">[[r.product10]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" :href="r.promotionEdit">编辑</a>
		                        	<a class="btn btn-primary" :href="r.promotionInfo">推广详情</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="promotions && promotions.last_page>1">
		                    <tr>
		                        <td colspan="9" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="promotions.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in promotions.last_page" v-if="Math.abs(promotions.current_page-(p+1))<=3">
							    			<li v-if="promotions.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="promotions.current_page < promotions.last_page" v-on:click="doChangePage(promotions.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
var promotionsList=new Vue({
	el:"#promotionsList",
	data:{
		ajaxUrls:{
			getPromotionsUrl:"{{url('admin/api/promotion/getPromotions')}}"
		},
		search:{
			page:1,
			limit:10,
			order:'id',
			sort:'asc'
		},
		promotions:null
	},
	methods:{
		//获取相关阅读计划
		doGetPromotions:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxUrls.getPromotionsUrl,
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.promotions=json;
				}
			});
		},
		//翻页
		doChangePage:function(page){
			this.search.page=page;
			this.doGetPromotions();
		}
	}
});
promotionsList.doGetPromotions();
</script>
@endsection



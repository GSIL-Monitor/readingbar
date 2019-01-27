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
<div class="wrapper wrapper-content animated fadeInRight" id="ProductList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  产品列表 </h5>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	编号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	在线售卖
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody v-if="ajaxStatus">
		                    <tr class="footable-even" >
		                        <td colspan="12"  class="footable-visible text-center">数据加载中...</td>
		                    </tr>
		                </tbody>
		                <tbody v-else>
		                    <tr class="footable-even" style="display: table-row;" v-for="d in products.data">
		                        <td class="footable-visible">[[d.id]]</td>
		                        <td class="footable-visible">[[d.product_name]]</td>
		                        <td class="footable-visible">[[d.show==1?'是':'否']]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" v-on:click="setBuyCheck(d.id)">购买校验设置</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="products && products.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="products.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in products.last_page" v-if="Math.abs(products.current_page-(p+1))<=3">
							    			<li v-if="products.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="products.current_page < products.last_page" v-on:click="doChangePage(products.last_page)"><a>»</a></li>
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
new Vue({
	el:"#ProductList",
	data: {
		products: [],
		ajaxStatus: false,
		search: {
			page: 1
		}
	},
	created: function () {
		this.doGetList()
	},
	methods: {
		doGetList: function () {
			var _this = this;
			if (_this.ajaxStatus) {
				return;
			}
			_this.ajaxStatus = true;
			$.ajax({
				url: "{{ url('/admin/product/getList') }}",
				type: "get",
				dateType: 'json',
				data: this.search,
				success: function (json) {
					_this.products = json;
				},
				complete: function () {
					_this.ajaxStatus = false;
				}
			})
		},
		doChangePage (page) {
			this.search.page = page;
			this.doGetList();
		},
		// 购买校验
		setBuyCheck: function (id) {
			window.location.href = "{{ url('admin/productBuyCheck')}}/"+ id + '/list';
		}
	}
});
</script>
@endsection



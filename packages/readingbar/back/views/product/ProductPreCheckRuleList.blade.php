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
                        <h5><i class="fa fa-list-ul"></i>  规则列表 </h5>
                        <div class="ibox-tools">
                        	<a v-on:click="doCreate()" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a href="{{ url('admin/product/list') }}" class="btn btn-primary btn-xs" > 返回产品列表</a>
                        </div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-hide="phone" class="footable-visible footable-sortable">
		                        	产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	类型
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	错误提示
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in rules.data">
		                    
		                        <td class="footable-visible">[[ r.product_name ]]</td>
		                        <td class="footable-visible">[[ rulesOptions[r.type] ]]</td>
		                        <td class="footable-visible">[[ r.message ]]</td>
		                        <td class="footable-visible text-right">
		                            <a class="btn btn-primary" v-on:click="doEdit(r)">编辑</a>
		                        	<a class="btn btn-primary" v-on:click="doDelete(r)">删除</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="products && rules.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="rules.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in rules.last_page" v-if="Math.abs(rules.current_page-(p+1))<=3">
							    			<li v-if="rules.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="rules.current_page < rules.last_page" v-on:click="doChangePage(rules.last_page)"><a>»</a></li>
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
		rules: [],
		ajaxStatus: false,
		rulesOptions: {
			1:'必须拥有的前置服务',
			2:'不能拥有的前置服务',
			3:'做过测试报告',
			4:'没有未完成的借阅计划',
			5:'产品可购买',
			6:'GE值是否达标',
			7:'未曾购买过任意产品',
			8:'没有未完成的寒假悦读计划',
		},
		search: {
			product_id: {{ $product_id }},
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
				url: "{{ url('/admin/productBuyCheck/getList') }}",
				type: "get",
				dateType: 'json',
				data: this.search,
				success: function (json) {
					_this.rules = json;
				},
				error: function (e) {
					appAlert({
						msg: e.responseText
					})
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
		// 删除
		doDelete: function (d) {
			var _this = this;
			$.ajax({
				url: "{{ url('/admin/productBuyCheck/destroy') }}",
				type: "post",
				dateType: 'json',
				data:{id: d.id},
				success: function (json) {
					_this.doGetList();
				},
				error: function (e) {
					appAlert({
						msg: e.responseText
					})
				}
			})
		},
		doCreate: function () {
			window.location.href = "{{ url('admin/productBuyCheck/'.$product_id.'/create') }}";
		},
		doEdit: function (d) {
			window.location.href = "{{ url('admin/productBuyCheck') }}/"+d.id+'/edit';
		}
	}
});
</script>
@endsection



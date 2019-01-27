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
<section class="wrapper wrapper-content animated fadeInRight" id="main-content">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
                <form class="ibox" onsubmit="return false">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <div class="ibox-content form-inline">
                    	 <select class="form-control" v-model='product_id'>
                          	<option  value="">请选择产品</option>
                          	<option v-for="o in products" :value="o.value">[[ o.text ]]</option>
                          </select>
                    </div>
                </form>
            </div>
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  产品续费策略 </h5>
                        <div class="ibox-tools">
                        	<a v-on:click="doCreate()" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        </div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-hide="phone" class="footable-visible footable-sortable">
		                        	策略名称
		                        </th>
		                    	<th data-hide="phone" class="footable-visible footable-sortable">
		                        	策略类型
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	优惠价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	策略执行顺序
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody v-if="ajaxGetStatus">
		                    <tr class="footable-even">
		                        <td colspan="12" class="footable-visible text-center">数据加载中...</td>
		                    </tr>
		                </tbody>
		                <tbody v-else>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in strategies.data" >
		                        <td class="footable-visible">[[ r.name ]]</td>
		                        <td class="footable-visible">[[ types[r.type] ]]</td>
		                        <td class="footable-visible">[[ r.discount_price ]]</td>
		                        <td class="footable-visible">[[ r.display ]]</td>
		                        <td class="footable-visible text-right">
		                            <a class="btn btn-primary" v-on:click="doEdit(r)">编辑</a>
		                        	<a class="btn btn-primary" v-on:click="doDelete(r,index)" >删除</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="products && strategies.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="strategies.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in strategies.last_page" v-if="Math.abs(strategies.current_page-(p+1))<=3">
							    			<li v-if="strategies.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="strategies.current_page < strategies.last_page" v-on:click="doChangePage(strategies.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	[[ strategies.data[0].ajaxDeleteStatus ]]
</section>
<script type="text/javascript">
new Vue({
	el:"#main-content",
	data: {
		product_id:'',
		strategies: null,
		ajaxGetStatus: false,
		ajax: null,
		products: {!! $products->toJson() !!},
		msg:{},
		types: {
			1:'所有对应服务期内',
			2:'对应服务到期后N天内',
			3:'相应产品购买之日起N天之内'
		}
	},
	created () {
		if (this.products[0]) {
			this.product_id = this.products[0].value;
		}
	},
	watch: {
		product_id (val, oval) {
			if (this.ajax) {
				this.ajax.abort();
			}
			this.doGetList();
		}
	},
	methods: {
		doGetList () {
			var _this = this;
			if (_this.ajaxGetStatus) {
					return;
				}
			_this.ajaxGetStatus = true;
			_this.ajax=$.ajax({
				url: "{{ url('admin/productRenewDiscount') }}",
				type: 'get',
				dataType: 'json',
				data:{product_id:_this.product_id },
				success: function (json) {
					_this.strategies = json.data;
				},
				complete: function () {
					_this.ajaxGetStatus = false;
					_this.ajax = null;
				}
			});
		},
		doCreate () {
			window.location.href = "{{ url('admin/productRenewDiscount/create') }}";
		},
		doEdit (d) {
			window.location.href = "{{ url('admin/productRenewDiscount') }}/"+d.id+'/edit';
		},
		doDelete(r,index) {
			var _this = this;
			$.ajax({
				url: "{{ url('admin/productRenewDiscount') }}/"+ r.id+'/delete',
				type: 'post',
				dataType: 'json',
				data:{product_id:_this.product_id },
				success: function (json) {
					_this.doGetList();
				}
			});
		}
	}
});
</script>
<script type="text/javascript">
 @if (session('alert')) 
	appAlert({
		msg: "{{session('alert')}}"
	});
	 @endif
</script>
@endsection



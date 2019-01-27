@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper bRefund-bottom white-bg page-heading">
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
<div class="wrapper wrapper-content animated fadeInRight" id="RefundsList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>退款订单列表(<strong style="color: #4bd2bf;">对应订单号：[[ order.order_id]]</strong>)</h5>
                        <div class="ibox-tools">
                        	<a class="btn btn-primary btn-xs" :href="order.refundApply"><i class="fa fa-paper-plane"></i>退款</a>
                        	<a class="btn btn-primary btn-xs" href="{{ url('admin/orders') }}"><i class="fa fa-backward"></i>返回</a>
                        </div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	退款订单号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	退款金额
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	备注
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	修改日期
		                        </th>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in Refunds.data">
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.serial]]</td>
		                        <td class="footable-visible">[[ n.total ]]</td>
		                        <td class="footable-visible">[[n.memo]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.updated_at]]</td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="Refunds && Refunds.last_page>1">
		                    <tr>
		                        <td colspan="6" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="Refunds.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in Refunds.last_page" v-if="Math.abs(Refunds.current_page-(p+1))<=3">
							    			<li v-if="Refunds.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="Refunds.current_page < Refunds.last_page" v-on:click="doChangePage(Refunds.last_page)"><a>»</a></li>
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
var RefundsList=new Vue({
	el:"#RefundsList",
	data:{
		Refunds:null,
		order:null,
		products:null,
		search:{
			order_id:"{{ $order_id }}",
			page:1,
			limit:10,
			ajaxStatus:false
		},
		alert:null
	},
	created:function(){
		this.doGetRefunds();
		this.doGetOrder();
	},
	methods:{
		//获取退款订单数据
		doGetRefunds:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/orders/getRefunds') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.Refunds=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//获取订单
		doGetOrder:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/orders/getOrder') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.order=json;
				},
				error:function(){
				}
			});
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetRefunds();
		},
		//提示信息
		doAlert:function(type,msg){
			switch(type){
				case 'success':
					this.alert={
							msg:msg,
							classes:'alert alert-success'
						}
					break;
				case 'error':
					this.alert={
						msg:msg,
						classes:'alert alert-danger'
					}
	 				break;
			}
		},
		doSearch:function(){
			this.search.page=1;
			this.doGetRefunds();
		}
	}
});
</script>
@endsection



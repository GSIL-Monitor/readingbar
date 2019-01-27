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
<div class="wrapper wrapper-content animated fadeInRight" id="ordersList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<!-- 搜索 -->
	 <div class="row">
             <div class="col-lg-12">
                <form class="ibox" onsubmit="return false">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <div class="ibox-content form-inline">
                    	  <input class="form-control" v-model="search.order_id"  placeholder="订单号"> 
                    	  <input class="form-control" v-model="search.trade_no"  placeholder="交易号"> 
                          <select v-model="search.status" class="form-control" >
                          	<option selected value=''>请选择申请状态</option>
                          	<option selected value='0'>待处理</option>
                          	<option selected value='1'>已处理</option>
                          </select>
                          <button class="btn btn-white" v-on:click="doSearch()" >搜索</button>
                    </div>
                </form>
            </div>
    </div>
	<!-- /搜索 -->
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>退押金申请列表 </h5>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	订单号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	交易号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	star账号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	支付方式
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	退款状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	申请时间
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                	<tr v-if="orders==null">
		                		<td colspan="13" class="text-center">正在加载数据</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in orders.data" v-else>
		                        <td class="footable-visible">[[n.order_number]]</td>
		                        <td class="footable-visible">[[n.trade_no]]</td>
		                        <td class="footable-visible">[[n.star_account]]</td>
		                        <td class="footable-visible">[[ showPayType(n.pay_type) ]]</td>
		                         <td class="footable-visible">[[n.status?'已处理':'待处理']]</td>
		                          <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" 	v-if="n.status == 1" :href="n.refundList">查看退款情况</a>
		                        	<a class="btn btn-primary" 	v-if="n.status == 0" :href="n.refundDetail">前往退款</a>
		                        	<a class="btn btn-primary" 	v-if="n.status == 0 && !n.ajaxStatus" v-on:click="doComplete(n)" >已处理</a>
		                        	<a class="btn btn-primary"  v-if='n.status == 0 && n.ajaxStatus' >
										<i class='fa fa-spin fa-refresh'></i>
									</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="orders && orders.last_page>1">
		                    <tr>
		                        <td colspan="15" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="orders.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in orders.last_page" v-if="Math.abs(orders.current_page-(p+1))<=3">
							    			<li v-if="orders.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="orders.current_page < orders.last_page" v-on:click="doChangePage(orders.last_page)"><a>»</a></li>
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
var ordersList=new Vue({
	el:"#ordersList",
	data:{
		orders:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		}
	},
	created:function(){
		this.doGetList();
	},
	methods:{
		//获取公告数据
		doGetList:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			_this.orders=null;
			$.ajax({
				url:"{{ url('admin/refundDepositApply') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					for (var i in json.data){
						json.data[i].ajaxStatus = false;
					}
					_this.orders=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//获取公告数据
		doComplete:function(a){
			var _this=this;
			if(a.ajaxStatus){
				return;
			}else{
				a.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/refundDepositApply') }}?id=" + a.id,
				dataType:"json",
				type: 'post',
				success:function(json){
					a.status = json.status
					a.ajaxStatus=false;
				},
				error:function(e){
					appAlert({
						msg: e.responseJSON.message
					})
					a.ajaxStatus=false;
				}
			});
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetList();
		},
		doSearch : function () {
			this.search.page = 1;
			this.doGetList();
		},
		// 支付方式显示
		showPayType(type) {
			switch (type) {
			     case 'card': return '礼品卡';
			     case 'alipay': return '支付宝支付';
			     case 'wxpay': return '微信支付';
				default: return '其他'
			}
		}
	}
});

</script>
@endsection



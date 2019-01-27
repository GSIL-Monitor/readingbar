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
                          <input class="form-control" v-model="search.email"  placeholder="邮箱">  
                          <input class="form-control" v-model="search.cellphone"  placeholder="手机"> 
                          <select v-model="search.product_id" class="form-control" v-on:change="doSearch()">
                          	<option selected value=''>请选择产品</option>
                          	<option v-for="p in products" :value="p.id">[[ p.product_name ]]</option>
                          </select>
                          <select v-model="search.pcode" class="form-control" v-on:change="doSearch()">
                          	<option selected value=''>请选择推广员</option>
                          	<option v-for="p in promoters" :value="p.pcode">[[ p.nickname ]]</option>
                          </select>
                    </div>
                    <div class="ibox-content form-inline">
                    	 <div class="input-daterange input-group" id="datepicker">
                               <input type="text"  class="input-sm form-control" name="fromDate">
                               <span class="input-group-addon">至</span>
                               <input type="text"  class="input-sm form-control" name="toDate">
                         </div>
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
                        <h5><i class="fa fa-list-ul"></i>订单列表 </h5>
                        <div class="ibox-tools">
                        	<a class="btn btn-primary btn-xs" v-on:click="exportOrders()" href="javascript:void(0)"><i class="fa fa-download"></i>导出</a>
                        </div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	订单号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	交易号
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	支付金额
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	押金
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	额外价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	支付日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	支付方式
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                	<tr v-if="orders==null">
		                		<td colspan="13" class="text-center">正在加载数据</td>
		                	</tr>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in orders.data" v-else>
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.order_id]]</td>
		                        <td class="footable-visible">[[n.serial]]</td>
		                        <td class="footable-visible">[[n.product_name]]</td>
		                        <td class="footable-visible">[[n.total]]</td>
		                        <td class="footable-visible">[[n.price]]</td>
		                        <td class="footable-visible">[[n.deposit]]</td>
		                        <td class="footable-visible">[[n.extra_price]]</td>
		                        <td class="footable-visible">[[n.completed_at]]</td>
		                        <td class="footable-visible">[[n.pay_type]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" v-if="n.refund" :href="n.refundList">查询退款</a>
		                        	<a class="btn btn-primary" v-else :href="n.refundApply">退款</a>
		                        	<a class="btn btn-primary"  :href="n.expressCost">往返快递费</a>
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
		products:null,
		promoters:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		a:{
			create:"{{url('admin/orders/form')}}"
		},
		selected:[],
		kdw:{
			order: {}
		},
		alert:null
	},
	created:function(){
		var _this=this;
		_this.doGetorders();
		_this.doGetProducts();
		_this.doGetPromoters();
		$('.input-daterange').datepicker({
			format:"yyyy-mm-dd",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
		}).on('changeDate', function(ev){
			_this.doSearch();
		});
	},
	methods:{
		//获取公告数据
		doGetorders:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			_this.orders=null;
			$.ajax({
				url:"{{ url('admin/api/orders/getOrders') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.orders=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//获取产品
		doGetProducts:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/orders/getProducts') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.products=json;
				},
				error:function(){
				}
			});
		},
		//获取推广人员信息
		doGetPromoters:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/orders/getPromoters') }}",
				dataType:"json",
				success:function(json){
					_this.promoters=json;
				},
				error:function(){
				}
			});
		},
		//导出
		exportOrders:function(){
			window.location.href="{{ url('admin/api/orders/exportOrders')}}?"+$.param(this.search);
		},
		//选择所有复选框
		selectedAll:function(){
			if(this.selected.length==this.orders.data.length){
				this.selected=[];
			}else{
				s=[];
				for(i in this.orders.data){
					s[i]=this.orders.data[i].id;
				}
				this.selected=s;
			}
		},
		//删除按钮
		doDelete:function(){
			if(confirm('是否确认删除！')){
				var _this=this;
				$.ajax({
					url:"{{ url('admin/api/orders/deleteOrder') }}",
					data:{selected:_this.selected},
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doAlert('success',json.success);
							_this.doGetorders();
						}else{
							_this.doAlert('error',json.error);
						}
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						console.log(XMLHttpRequest.status);
						console.log(XMLHttpRequest.readyState);
						console.log(textStatus);
					}
				});
			}
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetorders();
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
			this.search.fromDate=$('input[name=fromDate]').val();
 			this.search.toDate=$('input[name=toDate]').val();
			this.search.page=1;
			this.doGetorders();
		}
	}
});

</script>
@endsection



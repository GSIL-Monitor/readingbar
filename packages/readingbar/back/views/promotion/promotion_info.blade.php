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
<div class="wrapper wrapper-content animated fadeInRight" id="promotionDetail">
	<div class="row">
        <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>信息饼图</h5>
                        </div>
                        <div class="ibox-content">
	                        <div class="row">
	                        	<div class="col-md-6">
	                        		<div class="form-group form-inline">
	                        			<label>推广链接:</label>
	                        			<input type="text" :value="dashboard.url" class="form-control"/>
	                        			<button class="btn btn-default" v-on:click="downloadExcel()" style="margin-top: 6px">下载关联会员excel</button>
	                        		</div>
	                        		<div>
	                        			<button class="btn btn-default" v-on:click="setSearchDate(1)">今天</button>
	                        			<button class="btn btn-default" v-on:click="setSearchDate(2)">昨天</button>
	                        			<button class="btn btn-default" v-on:click="setSearchDate(3)">7天</button>
	                        			<button class="btn btn-default" v-on:click="setSearchDate(4)">30天</button>
	                        		</div>
	                        		<div>
	                        			<div class="input-daterange input-group" id="datepicker">
				                               <input type="text" v-on:change="doSearch()" class="input-sm form-control" name="fromDate">
				                               <span class="input-group-addon">至</span>
				                               <input type="text" v-on:change="doSearch()" class="input-sm form-control" name="toDate">
				                         </div>
	                        		</div>
	                        	</div>
	                            <div class="col-md-3">
	                                <div id="members"></div>
	                            </div>
	                            <div class="col-md-3">
	                                <div id="orders"></div>
	                            </div>
	                        </div>
                        </div>
                    </div>
                </div>
                @include('back::promotion.members_list')
                @include('back::promotion.orders_list')
    </div>
    
</div>
	<script src="{{ asset('assets/js/plugins/d3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/c3/c3.min.js') }}"></script>
    <script>
	var PD=new Vue({
		el:"#promotionDetail",
		data:{
			pcode:"{{ $pcode }}",
			dashboard:{!! $dashboard !!},
			list:null,
			search:{
				page:1,
				limit:10,
				type:null,
				pcode:"{{ $pcode }}",
				ajaxStatus:false
			},
			listType:null,
			dataList:null,
			dateRange:null		
		},
		created:function(){
			var _this=this;
			_this.setPieOfMembers();
			_this.setPieOfOrders();
			_this.dateRange=$('.input-daterange').datepicker({
				format:"yyyy-mm-dd",
			    keyboardNavigation: false,
			    forceParse: false,
			    autoclose: true
			}).on('changeDate', function(ev){
				_this.doSearch();
			});
		},
		methods:{
			//获取列表数据
			doGetData:function(){
				var _this=this;
				if(_this.search.ajaxStatus){
					return;
				}else{
					_this.search.ajaxStatus=true;
				}
				switch(_this.listType){
					case 'members': url="{{ url('admin/api/promotion/getMembers') }}";break;
					case 'orders' : url="{{ url('admin/api/promotion/getMOrders') }}";break;
					default:_this.search.ajaxStatus=false;return;
				}
				$.ajax({
					url:url,
					dataType:"json",
					data:_this.search,
					success:function(json){
						_this.dataList=json;
						_this.search.ajaxStatus=false;
					},
					error:function(){
						_this.search.ajaxStatus=false;
					}
				});
			},
			//设置会员饼图
			setPieOfMembers:function(){
				var _this=this;
				c3.generate({
	                bindto: '#members',
	                data:{
	                    columns: [
	                        ['总人数', _this.dashboard.members.total],
	                        ['已添加孩子', _this.dashboard.members.hc_total],
	                        ['未添加孩子',_this.dashboard.members.nc_total]
	                    ],
	                    colors:{
	                    	'总人数': '#8dd16e',
	                    	'已添加孩子': '#61d9c8',
	                    	'未添加孩子': '#aef8ed'
	                    },
	                    hide: ['总人数'],
	                    type : 'pie'
	                },
	                legend: {
	                	  item: {
	                	    	onclick: function (id) {
	                	    		_this.dataList=null;
	                	    		_this.listType='members';
	                	    		_this.search.page=1;
	                	    		switch(id){
		                	    		case '已添加孩子': _this.search.type='hc';break;
		                	    		case '未添加孩子': _this.search.type='nc';break;
		                	    		default:_this.search.type=null;break;
	                	    		}
	                	    		_this.doGetData();
	                	    	}
	                	  },
	                	  position: 'right'
	                },
	                pie: {
	                    label: {
	                        format: function (value, ratio, id) {
	                            return value;
	                        }
	                    }
	                },
	                size: {
	                	  width: 250,
	                	  height:200
	                }
				});
			},
			//设置订单饼图
			setPieOfOrders:function(){
				var _this=this;
				c3.generate({
	                bindto: '#orders',
	                data:{
	                    columns: [
	                        ['总订单数', _this.dashboard.orders.total],
	                        ['已付款订单数', _this.dashboard.orders.hp_total],
	                        ['未付款订单数',_this.dashboard.orders.unp_total]
	                    ],
	                    colors:{
	                    	'总订单数': '#8dd16e',
	                    	'已付款订单数': '#61d9c8',
	                    	'未付款订单数': '#aef8ed'
	                    },
	                    hide: ['总订单数'],
	                    type : 'pie'
	                },
	                legend: {
	                	  item: {
	                	    	onclick: function (id) {
	                	    		_this.dataList=null;
	                	    		_this.listType='orders';
	                	    		_this.search.page=1;
	                	    		switch(id){
		                	    		case '已付款订单数': _this.search.type='hp';break;
		                	    		case '未付款订单数': _this.search.type='unp';break;
		                	    		default:_this.search.type=null;break;
	                	    		}
	                	    		_this.doGetData();
	                	    	}
	                	  },
	                	  position: 'right'
	                },
	                pie: {
	                    label: {
	                        format: function (value, ratio, id) {
	                            return value;
	                        }
	                    }
	                },
	                size: {
	                	 width: 250,
	                	 height:200
	                }
	            });
			},
			//翻页
			doChangePage:function(page){
				this.search.page=page;
				this.doGetData();
			},
			//条件检索
			doSearch:function(){
				this.search.fromDate=$('input[name=fromDate]').val();
	 			this.search.toDate=$('input[name=toDate]').val();
				this.search.page=1;
				this.doGetData();
			},
			//条件按钮
			setSearchDate:function(t){
				var myDate = new Date();
				var today=myDate.getFullYear()+'-'+(myDate.getMonth()+1)+'-'+myDate.getDate();
				switch(t){
					case 1:
						$('input[name=fromDate]').datepicker('setDate',today);
						$('input[name=toDate]').datepicker('setDate',today);
						break;
					case 2:
						var lastday=this.getDateFromCurrentDate(today,-1);
						$('input[name=fromDate]').datepicker('setDate',lastday);
						$('input[name=toDate]').datepicker('setDate',lastday);
						;break;
					case 3:
						var star=this.getDateFromCurrentDate(today,-7);
						$('input[name=fromDate]').datepicker('setDate',star);
						$('input[name=toDate]').datepicker('setDate',today);
					break;
					case 4:
						var star=this.getDateFromCurrentDate(today,-30);
						$('input[name=fromDate]').datepicker('setDate',star);
						$('input[name=toDate]').datepicker('setDate',today);
						break;
				}
				this.doSearch();
			},
			//函数-获取指定日期前后几天的日期
			getDateFromCurrentDate:function(fromDate,dayInterval){
				var curDate = new Date(Date.parse(fromDate.replace(/-/g,"/")));
				curDate.setDate(curDate.getDate()+dayInterval);
				var year = curDate.getFullYear();
				var month = (curDate.getMonth()+1)<10?"0"+(curDate.getMonth()+1):(curDate.getMonth()+1);
				var day = curDate.getDate()<10?"0"+curDate.getDate():curDate.getDate();
				return year+"-"+month+"-"+day;
			},
			downloadExcel: function () {
				window.location.href = "{{ url('admin/promotion') }}/"+this.pcode +'/download';
			}
		}
	});
    </script>
@endsection



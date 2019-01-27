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
<div class="wrapper wrapper-content animated fadeInRight" id="main">
	<div class="row">
		<div class="col-xs-12">
			<div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i> 快递单列表</h5>
                        <div class="ibox-tools">
                        	<a class="btn btn-primary btn-xs" v-on:click="showModal()"><i class="fa fa-plus-square-o"></i>   新增</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="table table-hover">
		                <tbody><tr>
		                  <th>订单号</th>
		                  <th>发件人</th>
		                  <th>收件人</th>
		                  <th>类型</th>
		                  <th>快递公司</th>
		                  <th>快递单号</th>
		                  <th>快递费</th>
		                  <th>备注</th>
		                  <th></th>
		                </tr>
		                <tr  v-for="d in data">
		                  <td>[[ order.order_id ]]</td>
		                  <td>[[ d.sender ]]</td>
		                  <td>[[ d.receiver ]]</td>
		                  <td>[[ types[d.type] ]]</td>
		                  <td>[[ getCompany(d.shipper_code) ]]</td>
		                  <td>[[ d.logistic_code ]]</td>
		                  <td>[[ d.cost ]]</td>
		                  <td>[[ d.memo ]]</td>
		                  <td>
		                  		<button  class="btn btn-primary btn-xs" 	v-if="d.deletedStatus" >
			                  		<i class="fa fa-refresh fa-spin"></i>
			                  	</button>
			                  	<button  class="btn btn-primary btn-xs" v-on:click="doDelete(d)" v-else>
			                  		删除
			                  	</button>
		                  </td>
		                </tr>
		              </tbody></table>
		            
		        </div>
		    </div>
        </div>
		
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 class="modal-title" id="myModalLabel">快递表单</h4>
	            </div>
	            <div class="modal-body">
		            <form class="form-horizontal">
		              
				            <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">发件人</label>
			                  <div class="col-sm-10">
			                    <input type="text" class="form-control" id="inputEmail3" placeholder="发件人" v-model="form.sender">
			                  </div>
			                </div>
			                 <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">收件人</label>
			                  <div class="col-sm-10">
			                    <input type="text" class="form-control" id="inputEmail3" placeholder="收件人" v-model="form.receiver">
			                  </div>
			                </div>
			                <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">快递类型</label>
			                  <div class="col-sm-10">
			                    <select class="form-control" v-model="form.type">
			                    	<option v-for='(key, d) in types'  :value="key">[[ d ]]</option>
			                    </select>
			                  </div>
			                </div>
			                 <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">快递公司</label>
			                  <div class="col-sm-10">
			                    <select class="form-control" v-model="form.shipper_code">
			                    	<option v-for='d in companies'  :value="d.express_code">[[ d.express_name ]]</option>
			                    </select>
			                  </div>
			                </div>
			                 <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">快递单号</label>
			                  <div class="col-sm-10">
			                    <input type="text" class="form-control" id="inputEmail3" placeholder="快递单号" v-model="form.logistic_code">
			                  </div>
			                </div>
			                 <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">快递金额</label>
			                  <div class="col-sm-10">
			                    <input type="text" class="form-control" id="inputEmail3" placeholder="快递金额" v-model="form.cost">
			                  </div>
			                </div>
			                 <div class="form-group">
			                  <label for="inputEmail3" class="col-sm-2 control-label">备注</label>
			                  <div class="col-sm-10">
			                    <input type="text" class="form-control" id="inputEmail3" placeholder="备注" v-model="form.memo">
			                  </div>
			                </div>
			
			
		            </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                
	                <button type="button" class="btn btn-primary" v-if="ajaxStatus.store"><i class="fa fa-refresh fa-spin"></i></button>
	                <button type="button" class="btn btn-primary" v-on:click="doStore()"  v-else>保存</button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal -->
	</div>
</div>
<script type="text/javascript">
new Vue({
	el:"#main",
	data: {
		order: {!! $order->toJson() !!},
		companies: {!! $express_companies->toJson() !!},
		types: {
			1: '寄出',
			2: '寄回'
		},
		form: {
			order_id: {{ $order->id }},
			type: '',
			sender:'',
    		receiver:'',
    		logistic_code:'',
    		shipper_code:'',
    		cost:'',
    		memo:'',
		},
		data: {!! $data?$data->toJson():'[]' !!},
		errors: {},
		ajaxStatus: {
			store: false
		}
	},
	methods: {
		getData: function () {
			var _this = this
			$.ajax({
				url: "{{ url('admin/express/order/'.$order->id) }}",
				type: 'get',
				dataType: 'json',
				success:function (json) {
					if (json.status) {
						_this.data.splice(0, _this.data.length);
						for(var i in json.data) {
							_this.data.push(json.data[i]);
						}
					}else{
						appAlert({
							msg: json.message
						});
					}
				}
			});
		},
		getCompany:function (code) {
			for (var i in this.companies) {
              if (this.companies[i].express_code == code) {
					return this.companies[i].express_name;
              }
			}
		},
		showModal: function () {
			$("#myModal").modal({backdrop: 'static', keyboard: false});
		},
		doStore: function () {
			var _this = this;
			_this.ajaxStatus.store = true;
			$.ajax({
				url: "{{ url('admin/express/order/store') }}",
				type: 'post',
				dataType: 'json',
				data: _this.form,
				success:function (json) {
					if (json.status) {
						_this.getData();
						$("#myModal").modal('hide');
					}else{
						$("#myModal").modal('hide');
						appAlert({
							msg: json.error,
							ok: {
								callback: function () {
									$("#myModal").modal({backdrop: 'static', keyboard: false});
								}
							}
						});
					}
				},
				complete: function () {
					_this.ajaxStatus.store = false;
				}
			});
		},
		doDelete: function (d) {
			var _this = this;
			d.deletedStatus = true
			$.ajax({
				url: "{{ url('admin/express/order/delete') }}",
				type: 'delete',
				dataType: 'json',
				data: {
					id: d.id,
					order_id: {{ $order->id }}
				},
				success:function (json) {
					if (json.status) {
						_this.getData();
					}else{
						appAlert({
							msg: json.error
						});
					}
				},
				complete: function () {
					d.deletedStatus = false;
				}
			});
		}
	}
})
</script>
@endsection



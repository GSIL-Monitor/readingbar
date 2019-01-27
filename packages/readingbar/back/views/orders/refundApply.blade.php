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
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>退款申请</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal">
                                <div class="form-group"><label class="col-sm-2 control-label">订单#ID</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.id" readonly="readonly" type="text" class="form-control">
                                    	<label v-if="errors.id" class="error">[[ errors.id[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">退款单号 </label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.refund_no" type="text" class="form-control">
                                    	<label v-if="errors.refund_no" class="error">[[ errors.refund_no[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">退款金额</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.refund_total" type="text" class="form-control">
                                    	<label v-if="deposit>0">[[ deposit ]](押金)-[[ express_cost ]](运费)=[[ deposit-express_cost ]](应退押金)</label>
                                    	<label v-if="errors.refund_total" class="error">[[ errors.refund_total[0] ]]</label>
                                    </div>
                                </div>
                               	<div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">退款操作</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.order_type"  class="form-control">
                                    		<option value='1'>退押金/退款</option>
                                    		<option value='2'>退款并且当前订单作废</option>
                                    		<option value='3'>退还部分款项，当前订单作废，转综合服务(仅适用于【定制服务】)</option>
                                    	</select>
                                    	<label v-if="errors.order_type" class="error">[[ errors.order_type[0] ]]</label>
                                    </div>
                                </div>
                               	<div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">备注 </label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.memo" type="text" class="form-control">
                                    	<label v-if="errors.memo" class="error">[[ errors.memo[0] ]]</label>
                                    </div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="javascript:history.back()">取消</a>
                                        <a class="btn btn-primary"  v-on:click="submitForm()">保存</a>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">退款操作解释 </label>
                                    <div class="col-sm-10">
                                    	<label>退押金/退款</label>
                                    	<p>该退款选项，有且仅仅是在系统内记录这个订单做过退款及退款的金额信息，对其他信息不做任何影响。</p>
                                    	<label>退款并且当前订单作废</label>
                                    	<p>
                                    		该退款选项，除了记录退款的信息，还对当前订单作废处理。例如：<br/>
                                    		2018.01.01用户购买了产品a,订单号为001,产生的服务期为2018.01.01-2019.01.01若对该订单执行该退款选项操作，那么001的订单无效化，所产生的服务期将取消。相当与用户从未购买过该产品。
                                    	</p>
                                    	<label>退还部分款项，当前订单作废，转综合服务(仅适用于【定制服务】)</label>
                                    	<p>
                                    		该退款选项，除了记录退款的信息，对当前订单作废处理，还会给客户产生一个综合服务的新订单。<br/>
                                    		新订单：假设综合服务产品有效期为1年。后台于2018.01.20做了该退款操作，那么当前用户会拥有综合服务2018.01.20-2019.01.20服务期。原来的定制服务无效。
                                    	</p>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">服务期的计算 </label>
                                    <div class="col-sm-10">
                                    	用户 2018.01.01 购买了 a服务产品，订单号001，产品有效期1年 那么服务期2018.01.01-2019.01.01。<br/>
                                    	若用户2018.02.01服务期内 又买了 a服务产品，订单号002，那么2个订单产生的服务期累加 2018.01.01-2020.01.01。<br/>
                                    	若只对订单001进行订单作废操作。那么该用户的服务期是2018.02.01-2019.02.01。<br/>
                                    	若只对订单002进行订单作废操作。那么该用户的服务期是2018.01.01-2019.01.01。<br/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       
</div>
<script type="text/javascript">
var ordersList=new Vue({
	el:"#ordersList",
	data:{
		order_id:"{{ $order_id }}",
		deposit:"{{ $deposit }}",
		express_cost:"{{ $express_cost }}",
		form:{
			id: {{ $order_id }},
			ajaxStatus:false
		},
		products:null,
		errors:null
	},
	created: function () {
		if (this.deposit>0) {
			this.form.refund_total = this.deposit - this.express_cost;
		}
	},
	methods:{
		//提交表单
		submitForm:function(){
			var _this=this;
			if(_this.form.ajaxStatus){
				return;
			}else{
				_this.form.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/orders/createRefund') }}",
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					appAlert({
							msg:json.message,
							ok: {
								title: '确定',
								callback: function () {
									window.location.href="{{ url('admin/orders/'.$order_id.'/refundList') }}";
								}
							}
					});
				},
				error:function(XMLHttpRequest, textStatus, errorThrown){
					if (XMLHttpRequest.status == 400) {
						if (XMLHttpRequest.responseJSON.data) {
							_this.errors=XMLHttpRequest.responseJSON.data;
						}else{
							appAlert({
								msg:XMLHttpRequest.responseJSON.message
							});
						}
					}
				},
				complete: function () {
					_this.form.ajaxStatus=false;
				}
			});
		}
	}
});
</script>
<script>
//日期控件
$('.datepicker-date').datepicker({format: 'yyyy-mm-dd'});
</script>
@endsection



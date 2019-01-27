<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

<div class="container" id="childrenList">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr100" >
	       <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">{{$head_title}}</a></li>
				<a href="{{url('member/children/create')}}" class="baby-add">添加</a >
			</ul>
			<div style="clear:both"></div>
			<div  v-if="loadData==0" style="background:url('{{asset('assets/css/plugins/slick/ajax-loader.gif')}}') center center no-repeat;width:100%;height:50px;">
			
		 </div>
			<div class="paddlt36"  v-if="loadData==1">
				<!--<div class="row" v-for="c in listdata.data">-->
				<div class="row baby-list" v-for="c in listdata.data">
					<!--
					<div class="baby-Head col-md-2">
						<img :src="c.avatar">
					</div>
					-->
					<div class="col-md-2 user-tx2 fl">
						<a href="{{url('member/children/baseinfo')}}/[[c.id]]"><img :src="c.avatar"></a>
						<em class="user-tx-hover2"></em>
					</div>
					<!--/-->
					<div class="baby-info col-md-6">
						<a href="{{url('member/children/baseinfo')}}/[[c.id]]"><h4>姓名：[[c.name]]</h4></a>
					    <p>昵称：[[c.nick_name]]</p>
					     <template v-if="c.services.length">
					    	<p v-for=' se in c.services'>
					    		[[se.name]]-过期日期：[[se.expirated]] 
					    		<a href="javascript:void(0)" v-on:click="showDiscountModal(c,se.service_id)">[续费]</a>	
					    	</p>
					    </template>
						<!--<p>性别：[[c.sex]]</p>-->
					</div>
					<div class="col-md-2 baby-ann">
						<button v-if="!c.services" class="click-gift" v-on:click="showCardModal(c);" >
							礼品卡充值
						</button>
						<button class="click-goStarReport" v-on:click="goStarReport(c)">我的报告</button><br>
						<button class="click-reading" v-on:click="goReadPlan(c);">阅读计划</button>
					</div>
					<div class="baby-operation col-md-2">
						
						<button class="click-delete" v-on:click="doDeleteChild(c.id);">删除</button>
						<a href="{{url('member/children/edit')}}/[[c.id]]" class="click-bj">编辑</a>
					</div>
				</div>
				<ul class="pagination pull-right" v-if="listdata.total_pages">
			    	<li v-if="listdata.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in listdata.total_pages" v-if="Math.abs(listdata.current_page-(p+1))<=3">
		    			<li v-if="listdata.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="listdata.current_page < listdata.total_pages" v-on:click="doChangePage(listdata.total_pages)"><a>»</a></li>
		     	</ul>
			</div>
			<!--/ paddlt36-->
			<div  v-if="loadData==2" style="text-align:center;width:100%;height:50px;">
				<span>加载失败!<a v-on:click="getChildren">重新加载</a></span>
			</div>
		</div>
		<!--/ col-md-3 end-->
		<!-- 礼品卡激活表单 -->
		<div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		    	 <div class="modal-content" v-if="activeCardStatus">
		        	<div class="row">
		        		<div class="col-md-12  text-center" style="margin:15px;">
		        			<img alt="" src="{{asset('assets/css/plugins/slick/ajax-loader.gif')}}">  激活中
		        		</div>
		        	</div>
		        </div>
		        <div class="modal-content" v-else>
			        <div class="modal-header">
			        	<h3 class="col-md-12" style="color:#4bd2bf">礼品卡充值</h3>
			        </div>
			        <div class="modal-body">
			           <div class="form-group">
			           		<label class="col-lg-3 control-label"><span color="red">*</span>卡号</label>
							<div class="col-lg-9">
								<input v-model="activeCard.card" placeholder="卡号" class="form-control" type="text">
	                   		</div>
	                   </div>
	                   <div class="form-group">
			           		<label class="col-lg-3 control-label"><span color="red">*</span>密码</label>
							<div class="col-lg-9">
								<input v-model="activeCard.card_pwd" placeholder="密码" class="form-control" type="password">
	                   		</div>
	                   </div>
	                   <div class="form-group">
			           		<label class="col-lg-3 control-label">联系人</label>
							<div class="col-lg-9">
								<input v-model="activeCard.name" placeholder="联系人" class="form-control" type="text">
	                   		</div>
	                   </div>
	                   <div class="form-group">
			           		<label class="col-lg-3 control-label">联系电话</label>
							<div class="col-lg-9">
								<input v-model="activeCard.tel" placeholder="联系电话" class="form-control" type="text">
	                   		</div>
	                   </div>
	                   <div class="form-group">
			           		<label class="col-lg-3 control-label">礼品寄送地址</label>
							<div class="col-lg-9">
								<input v-model="activeCard.address" placeholder="礼品寄送地址" class="form-control" type="text">
	                   		</div>
	                   </div>
			        </div>
			        <div class="modal-footer">
			        	<div class="row">
			            	<div class="col-md-12">
				            	 <a href="javascript:void(0)" v-on:click="doActiveCard()" class="fr button-01 margft10">确认激活</a>
								 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消激活</a>
							</div>
			            </div>
			        </div>
		        </div>
		       
		        <!-- /.modal-content -->
		    </div><!-- /.modal -->
		</div>
		<!-- //礼品卡激活表单 -->
		<!--支付表单-->
			<form id="payForm" style="display:none" action="{{url('api/member/order/renew')}}">
				<input value="{{ csrf_token() }}" name="_token">
				<input :value="renew.student_id" name="student_id">
				<input type="checkbox" v-for="d in renew.discounts" :value="renew.discounts[$index]" checked name="discounts[]">
				<input :value="renew.pay_type" name="pay_type">
				<input :value="renew.service_id" name="service_id">
		    </form>
		<!--/支付表单-->
		
		<!-- 支付方式选择弹出层 -->
		<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
		        <div class="modal-content">
		        <div class="modal-body">
		            <div class="row">
		            	<h3 class="col-md-12" style="color:#4bd2bf">选择支付方式:</h3>
		            </div>
		            <br><br>
		            <div class="row">
		            	<div class="col-md-6">
		            		<input type="radio" v-model="renew.pay_type" value="wxpay"  name="pay_type"><img alt="微信" src="{{url('home/pc/images/pay/wxpay.png')}}" style="height:50px;margin-left:20px">
		            	</div>
		            	<div  class="col-md-6">
		            		<input type="radio" v-model="renew.pay_type" value="alipay" name="pay_type"><img alt="支付宝" src="{{url('home/pc/images/pay/alipay.png')}}" style="height:50px;margin-left:20px">
		            	</div>
		            </div>
		            <br><br>
		            <div class="row">
		            	<div class="col-md-12">
			            	 <a href="javascript:void(0)" v-on:click="doPayOrder()" class="fr button-01 margft10">确认支付</a>
							 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消支付</a>
						</div>
		            </div>
		        </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal -->
		</div>
		<!-- //支付方式选择弹出层 -->
		<!-- 微信支付二维码弹出层 -->
		<div class="modal fade" id="CodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-body">
			        	<div class="row">
			            	<h3 class="col-md-12" style="color:#4bd2bf">微信支付二维码:</h3>
			            </div>
				        <div class="row">
				        	<div class="col-md-12 text-center">
				        		<img alt="微信支付二维码" :src="wxQRCode.url" width="50%">
				        	</div>
				        </div>
			        </div>
		        </div>
		    </div><!-- /.modal -->
		</div>
		<!-- //微信支付二维码弹出层 -->	
		
		<!-- 选择使用折扣券弹出层 -->
		<div class="modal fade" id="DiscountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		    <div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-body">
			        	<div class="row">
			            	<h3 class="col-md-12" style="color:#4bd2bf">选择使用优惠券:</h3>
			            </div>
			            <br>
				        <div class="row">
				        	<div class="col-md-12" v-for="d in discounts">
				        		<input type="checkbox" v-model="renew.discounts" :value="d.id" class="col-md-1">
				        		<lable class="form-lable col-md-11 text-left">
					        		<h3 class="col-md-3" style="color:#4bd2bf;">￥[[ d.price ]]</h3>
					        		<h5 class="col-md-9">[[ d.name ]]</h5>
					        	</lable>
					        	<br><br>
				        	</div>
				        </div>
				        <br>
				        <div class="row">
				        	<div class="col-md-12">
				            	 <a href="javascript:void(0)" v-on:click="showPTS()" class="fr button-01 margft10">确认</a>
								 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消支付</a>
							</div>
						</div>
			        </div>
		        </div>   
		    </div><!-- /.modal -->
		</div>
		<!-- //选择使用折扣券弹出层  -->
	</div>
	<!--/ row end-->
				<script type="text/javascript">
				var childrenList=new Vue({
						el:"#childrenList",
						data:{
							listdata:null,
							search:{
								page:1,
								limit:4
							},
							loadData:0,
							renew:{
								student_id:null,
								discounts:[],
								pay_type:'wxpay'
							},
							wxQRCode:null,
							activeCard:{
								student_id:null,
								card:null,
								card_pwd:null,
								address:null,
								name:"{{ auth('member')->member->nickname }}",
								tel:"{{ auth('member')->member->cellphone }}"
							},
							activeCardStatus:false,
							discounts:null
						},
						created:function(){
							this.doGetDiscounts();
						},
						methods:{
							getChildren:function(){
								var _this=this;
								_this.loadData=0;
								$.ajax({
										url:"{{url('api/member/children/all')}}",
										dataType:"json",
										data:_this.search,
										success:function(json){
											if(json.status){
												_this.listdata=json.data;
											}else{
												alert(json.error);
											}
											_this.loadData=1;
										},
										error:function(){
											_this.loadData=2;
										}
								});
							},
							doDeleteChild:function(cid){
								if(!confirm('是否确认删除！')){
									return ;
								}
								var _this=this;
								$.ajax({
										url:"{{url('api/member/children/deleteChild')}}",
										dataType:"json",
										type:"POST",
										data:{id:cid},
										success:function(json){
											if(json.status){
												alert(json.success);
												_this.getChildren();
											}else{
												alert(json.error);
											}
										}
								});
							},
							starEvaluate:function(c){
								if(c.survey_status){
									if(c.star_account==null){
										if(confirm('是否申请star评测？')){
											$.ajax({
												url:"{{url('api/member/children/star/apply')}}",
												dataType:"json",
												type:"POST",
												data:{student_id:c.id},
												success:function(json){
													if(json.status){
														alert(json.success);
													}else{
														alert(json.error);
													}
												}
											});
										}
									}else{
										alert("账号:"+c.star_account+"\n密码:"+c.star_password);
									}
								}else{
									window.open("{{url('member/children/survey')}}/"+c.id);
								}
							},
							goReadPlan:function(c){
								url="{{url('member/children/readplan')}}/"+c.id;
								window.location.href=url;
							},
							doChangePage:function(page){
								this.search.page=page;
								this.getChildren();
							},
							//显示支付选择弹出层
							showPTS:function(){
								$("#DiscountModal").modal('hide');
								$("#payModal").modal({backdrop: 'static', keyboard: false});
							},
							//确认支付
							doPayOrder:function(){
								var _this=this;
								switch(_this.renew.pay_type){
									case 'alipay':$('#payForm').submit();break;
									case 'wxpay':
										$.ajax({
											url:"{{url('api/member/order/renew')}}",
											data:_this.renew,
											dataType:"json",
											success:function(json){
												if(json.status){
													if(json.redirect){
														alert(json.success);
														window.location.href=json.redirect;
														return;
													}
													_this.wxQRCode=json;
													$("#payModal").modal('hide');
													_this.showQRCode();
												}else{
													alert(json.error);
												}
											},
											error:function(){
												alert('链接失败！');
											}
										});
									break;
								}
							},
							//微信支付二维码显示
							showQRCode:function(){
								$("#CodeModal").modal('show');
								this.requestOrderStatus();
							},
							//微信支付定时请求支付状态
							requestOrderStatus:function(){
								 var _this=this;
								 if(_this.setInterval){
									 clearInterval(_this.setInterval);
								 }
								 _this.setInterval=setInterval(function(){
									 var _setInterval=this;
									 $.ajax({
											url:"{{url('api/member/order/getStatusByOID')}}",
											data:{order_id:_this.wxQRCode.order_id},
											dataType:"json",
											success:function(json){
												if(json.status){
													alert('支付成功！');
													window.location.reload();
												}
											}
									 });
								 },3000);
							},
							//礼品卡激活表单显示
							showCardModal:function(c){
								this.activeCard.student_id=c.id;
								this.activeCard.address=c.province+c.city+c.area+c.address;
								$("#cardModal").modal({backdrop: 'static', keyboard: false});
							},
							//激活礼品卡
							doActiveCard:function(){
								var _this=this;
								if(_this.activeCardStatus){
									return;
								}else{
									_this.activeCardStatus=true;
								}
								$.ajax({
									url:"{{url('api/member/giftCard/activeCard')}}",
									data:_this.activeCard,
									type:"POST",
									dataType:"json",
									success:function(json){
										if(json.status){
											_this.getChildren();
											$("#cardModal").modal('hide');
											alert(json.success);
										}else{
											alert(json.error);
										}
										_this.activeCardStatus=false;
									},
									error:function(){
										alert('链接失败！');
										_this.activeCardStatus=false;
									}
								});
							},
							//获取用户折扣券
							doGetDiscounts:function(){
								var _this=this;
								$.ajax({
									url:"{{url('api/member/discount/getDiscounts')}}",
									dataType:"json",
									success:function(json){
										_this.discounts=json;
									},
									errors:function(){
										
									}
							 	});
							},
							//显示折扣券使用弹出层
							showDiscountModal:function(c,service_id){
								this.renew.student_id=c.id;
								this.renew.service_id=service_id;
								if(this.discounts && this.discounts.length){
									$("#DiscountModal").modal({backdrop: 'static', keyboard: false});
								}else{
									this.showPTS();
								}
							}
						}
						
						});
				childrenList.getChildren();
				</script>
				<!--/row end-->
			</div>

@endsection


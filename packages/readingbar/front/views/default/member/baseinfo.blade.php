<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->
<style type="text/css">
	body{ background: #fafafa;}
</style>
<div class="container">
	<div class="row padt9">
	  	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	    </div>
	    <!--/ home-column-fl end-->
	    <div class="col-md-10 home-column-fr100">
	      
			<div style="clear:both"></div>
			<div class="mgl-40 pos-rela" id="baseinfo">
				
        		
        		<!--/star-test-banner-->
        		
        		<div class="user-grxx row" style="padding-top: 34px;">
        			<div class="col-md-3">
        				<div class="user-tx">
        					<img class="img-preview" src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/default_avatar.jpg') }}">
                        	<em class="user-tx-hover"></em>
                        </div>
                        <button class="user-tx-upload button-01-1 update_member_avatar">上传头像</button>
                    </div>
        			<div class="col-md-6 padding-0">
        				<div class="form-tip2 margintop59">
							*请填写您真实的资料，以方便接收AR测试系统账号及其他资料
						</div>
        				<div class="row marginbt10">
							<div class="input-column col-md-4 color4bd2bf">昵称：</div>
							<div class="input-value2 col-md-8">
								[[member.nickname]]
							</div>
						</div>
						<!-- 手机 -->
						<div class="row marginbt10" v-if="form!='phone'">
							<div class="input-column col-md-4 color4bd2bf">手机号码：</div>
							<div class="input-value2 col-md-8">
								[[member.cellphone]]
								<a v-on:click="showForm('phone')" href="javascript:void(0)">修改</a>
							</div>					
						</div>
						<template v-else>
							<div class="row marginbt15">
								<div class="input-column col-md-4 color4bd2bf">手机号码：</div>
								<div class="input-value col-md-8">
									<input v-model="phone.cellphone" type="text" class="wit150 form-control2">
								</div>
							</div>
							<div class="row marginbt15">
								<div class="input-column col-md-4 color4bd2bf">验证码：</div>
								<div class="input-value col-md-8 inline">
									<input v-model="phone.code" type="text" class="wit150 form-control2 fl">
									<a v-on:click="doSendCode()" class="btn-default2 fz-14 fl">发送验证码</a>
								</div>
							</div>
							<div class="row margin15">
								<div class="input-column col-md-4"></div>
								<div class="col-md-8">
									<button v-on:click="submit()" onclick="return false;" class="button-01-1 fl">保存</button>
								    <button v-on:click="cancel()" class="button-02-1 fl margft20">取消</button>
								</div>
							</div>
						</template>
						<!-- 邮箱 -->
						<div class="row" v-if="form!='email'">
							<div class="input-column col-md-4 color4bd2bf">邮箱：</div>
							<div class="input-value2 col-md-8">
								[[member.email]]
								<a v-on:click="showForm('email')" href="javascript:void(0)">修改</a>
							</div>
						</div>
                        <template v-else>
							<div class="row marginbt15">
								<div class="input-column col-md-4 color4bd2bf">邮箱：</div>
								<div class="input-value col-md-8">
									<input v-model="email.email" type="text" class="wit150 form-control2">
								</div>
							</div>
							<div class="row marginbt15">
								<div class="input-column col-md-4 color4bd2bf">验证码：</div>
								<div class="input-value col-md-8 inline">
									<input v-model="email.code" type="text" class="wit150 form-control2 fl">
									<a v-on:click="doSendCode()"  class="btn-default2 fz-14 fl">发送验证码</a>
								</div>
							</div>
							<div class="row margin15">
								<div class="input-column col-md-4"></div>
								<div class="col-md-8">
									<button v-on:click="submit()" onclick="return false;" class="button-01-1  fl">保存</button>
									<button v-on:click="cancel()" class="button-02-1  fl margft20">取消</button>
								</div>
							</div>
						</template>
						
							<div class="row margin15">
								<div class="col-md-12 text-center">
									<a href="{{url('/member/children/create')}}" class="baby-add" style="display: inline;float:none">添加孩子+</a >
								</div>
							</div>
						<!-- //邮箱 -->

                	</div>
                	<div class="col-md-3">
                		@if(isset($promote_qrcode))
							<div class="gr-gg">
								<a href="#"><img src="{{ $promote_qrcode }}"></a>
								<script src="https://cdn.bootcss.com/clipboard.js/1.6.1/clipboard.js"></script>
								<script type="text/javascript">
									var clipboard = new Clipboard('.Clipboard', {
										    text: function(trigger) {
										        return "{{ $promote_url }}";
										    }
										});
										clipboard.on('success', function(e) {
										    alert('链接已复制！');
										});
										clipboard.on('error', function(e) {
										    alert('您的浏览器版本过低，不支持该功能！');
										});
								</script>
								<span class='Clipboard' ><a href="javascript:void(0)">复制推广链接</a></span>
								<span>【蕊丁使者推广链接】</span>
							</div>
						@else
							<div class="gr-gg2"><a href="{{ url('introduce/RDMessenger') }}"><img src="{{url('home/pc/images/Recommend/xbanner_03.jpg')}}"></a></div>
						@endif
                	</div>
        		</div>
        		<!--/star-test-banner-->
			</div>
			<!--/content-->
            <!--/-->
            <div class="col-md-12 home-column-fr" id="childrenList">
         
		       <ul class="nav nav-tabs" style="margin-top:0;margin-left:21px;width: 100%;">
					   <!-- <a href="{{url('/member/children/create')}}" class="baby-add">添加孩子+</a >	-->
				</ul> 
		
				<div style="clear:both"></div>
				<div  v-if="loadData==0" style="background:url('{{asset('assets/css/plugins/slick/ajax-loader.gif')}}') center center no-repeat;width:100%;height:50px;">
				
			 </div>
			<div v-if="loadData==1" style="margin-left:0;width: 100%;margin-left:21px;">
				<!--<div class="row" v-for="c in listdata.data">-->
				<div class="row baby-list" v-for="c in listdata.data" >
					<!--
					<div class="baby-Head col-md-2">
						<img :src="c.avatar">
					</div>
					-->
					<div class="col-md-2  fl">
						<div class="user-tx2">
							<a href="{{url('member/children/baseinfo')}}/[[c.id]]"><img :src="c.avatar"></a>
							<em class="user-tx-hover2"></em>
						</div>
						<div class="rdmony">
							<span><img src="{{url('home/pc/images/ioc-rdm.png')}}"></span>
							<b>[[ c.point ]]</b>
							<a href="#" data-placement="right" title="
蕊丁币的获得方式：
*会员每天登陆官网，就可获得10个蕊丁币。（和登录次数无关，对所有注册会员有效）
*凡进入每月更新的小达人排行榜，都可以获得100个蕊丁币。
*定制会员，每完成阅读计划中的任务目标，就可以获得100个蕊丁币。
*所有蕊丁使者，成功推广一名注册会员，即可获得20蕊丁币。
*购买蕊丁吧产品，即可获得相同数量的蕊丁币。
*参与蕊丁吧“Reading Camp”，完成任务可获得奖励蕊丁币。
" style="font-size: 14px;
    line-height: 20px;
    margin-left: 5px;
    color: #4bd2bf;
    font-weight: bold;margin-top: -4px;"><img src="{{url('home/pc/images/wh.png')}}"></a>
						
						</div>
					</div>
					<!--/-->
					<div class="baby-info col-md-6">
						<a href="{{url('member/children/baseinfo')}}/[[c.id]]"><h4>[[c.nick_name]]</h4></a>
					    <template v-if="c.services.length">
					    	<p v-for='se in c.services' v-if="checkDate(se.expirated)">
					    		[[se.name]]-过期日期：[[se.expirated]] 
					    		<a href="{{ url('member/pay/renewConfirm') }}?student_id=[[ c.id ]]&service_id=[[ se.service_id ]]">[续费]</a>	
					    	</p>
					    </template>
						
					</div>
				
					<div class="baby-operation col-md-2">
						
						<button class="click-delete" v-on:click="doDeleteChild(c.id);">删除</button>
						<a href="{{url('member/children/edit')}}/[[c.id]]" class="click-bj">编辑</a>
					</div>
				</div>
				<ul class="pagination pull-right" v-if="listdata.last_page">
			    	<li v-if="listdata.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in listdata.last_page" v-if="Math.abs(listdata.current_page-(p+1))<=3">
		    			<li v-if="listdata.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="listdata.current_page < listdata.last_page" v-on:click="doChangePage(listdata.last_page)"><a>»</a></li>
		     	</ul>
			</div>
			<!--/ paddlt36-->
			<script type="text/javascript">
				function show_alert(){  
				    alert('功能正在完善，敬请期待!');  
				}
				$(function () { $("[data-toggle='tooltip']").tooltip(); });
			</script>
							<div  v-if="loadData==2" style="text-align:center;width:100%;height:50px;">
				<span>加载失败!<a v-on:click="getChildren">重新加载</a></span>
			</div>
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
					           		<label class="col-lg-3 control-label"><span style="color:red">*</span>卡号</label>
									<div class="col-lg-9">
										<input v-model="activeCard.card" placeholder="卡号" class="form-control" type="text">
			                   		</div>
			                   </div>
			                   <div class="form-group">
					           		<label class="col-lg-3 control-label"><span style="color:red">*</span>密码</label>
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
		<!--/ col-md-3 end-->
			



			<!--end-->
		</div>
		<!--/col-md-10-->	
	</div>
	<!--/row end-->
</div>
<!-- /扩展内容 -->

@include('front::default.member.memberAvatarForm')

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
								pay_type:'wxpay',
								service_id:null
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
											_this.listdata=json;
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
							goStarReport:function(c){
								url="{{url('member/children/starReport')}}/"+c.id;
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
							},
							//校验日期是否过期
							checkDate: function(expirated){
								var now = Date.parse(new Date());
								expirated =  Date.parse(new Date(expirated));
								return expirated > now;
							}
						}
						
						});
				childrenList.getChildren();
				</script>
				<!--/row end-->


<!--/-->
<script type="text/javascript">
var baseinfo=new Vue({
	el:"#baseinfo",
	data:{
		ajaxUrls:{
			submitEmailUrl:"{{ url('api/member/modify/email') }}",
			sendEmailCode:"{{ url('api/message/sendEmailCode') }}",
			submitMobileUrl:"{{ url('api/member/modify/mobile') }}",
			sendMobileCode:"{{ url('api/message/sendMobileCode') }}",
		},
		form:null,
		member:{!! json_encode($member) !!},
		email:{
			email:null,
			code:null
		},
		phone:{
			cellphone:null,
			code:null
		},
		freeStar:{{session('freeStar')?'true':'false'}}
	},
	methods:{
		showForm:function(form){
			switch(form){
				case 'null':this.form=null;break;
				default:this.form=form;
			}
		},
		//发送验证消息
		doSendCode:function(){ 
			var _this=this;
			switch(_this.form){
				case 'email':
					url=_this.ajaxUrls.sendEmailCode;
					info=_this.email;
				break;
				case 'phone':
					url=_this.ajaxUrls.sendMobileCode;
					info=_this.phone;
				break;
				default:return false;
			}
			$.ajax({
					url:url,
					data:info,
					type:"GET",
					dataType:"json",
					success:function(json){ 
						if(json.status){ 
							alert(json.success);
						}else{
							alert(json.error);
						}				
					}
			});
		},
		//提交修改
		submit:function(){ 
			var _this=this;
			switch(_this.form){
				case 'email':
					url=_this.ajaxUrls.submitEmailUrl;
					info=_this.email;
				break;
				case 'phone':
					url=_this.ajaxUrls.submitMobileUrl;
					info=_this.phone;
				break;
				default:return false;
			}
			$.ajax({
					url:url,
					data:info,
					type:"POST",
					dataType:"json",
					success:function(json){ 
						if(json.status){ 
							switch(_this.form){
								case 'email':_this.member.email=info.email;break;
								case 'phone':_this.member.cellphone=info.cellphone;break;
								default:alert(json.success);
							}
							_this.form=null;
							_this.goFreeStar();
						}else{
							alert(json.error);
						}				
					}
			});
		},
		cancel:function(){
			this.form=null;
		},
		//判断是否是免费评测流程
		goFreeStar:function(){
			if(this.freeStar){
				if(this.member.email!='' && this.member.cellphone!=''){
					window.location.href="{{url('member/freeStar')}}";
				}
			}
		}
	}
});
@if(isset($message))
	alert('{{ $message }}');
@endif
</script>

@endsection
<!-- //继承整体布局 -->

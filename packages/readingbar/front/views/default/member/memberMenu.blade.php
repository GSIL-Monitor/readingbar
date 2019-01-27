
<div id="leftmenu">
		<!--<div class="userinfo" style="background: #4bd2bf;">
		<div>
			<img
				src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/guest.png') }}">
			<p class="nickname">{{auth('member')->member->nickname}}</p>
		</div>
	</div>
	/-->
	<div class="userinfo">我的账户</div>
	<div class="list">
		<ul class="yiji left-nav">
			<li><a class="inactive ICO-01" id="left-menu-baseinfo" href="{{ url('member/children/starReport') }}">测试报告 </a></li>
			<li><a class="inactive ICO-02" id="left-menu-baseinfo" href="{{ url('borrowService/myBooks/plans') }}">借阅书单</a></li>
			<li><a class="inactive ICO-02" id="left-menu-baseinfo" href="{{ url('member/children/readplan') }}">阅读计划</a></li>
           	<li><a class="inactive ICO-03" id="left-menu-baseinfo" href="{{ url('member/children/pointLog') }}">我的蕊丁币 </a></li>
           	<li><a class="inactive ICO-04" id="left-menu-baseinfo" href="{{ url('member/accountCenter/orders') }}">我的订单 </a></li>
			<li><a class="inactive ICO-05" id="left-menu-baseinfo" href="javascript:void(0) " v-on:click="showModel()">礼品卡充值</a></li>
           	<li><a class="inactive ICO-06" id="left-menu-baseinfo" href="{{ url('member/discount') }}">优惠券</a></li>
           	<li>
           		@if(auth('member')->checkPromoter())
					@if(auth('member')->checkRDMessenger())
						<li>
							<a  class="inactive ICO-07"  id="left-menu-accounts" href="javascript:void(0)"> 蕊丁使者</a>
							<ul style="display: none">
								<li><a id="/member/promotions/RDMessenger"  href="{{url('member/promotions/RDMessenger')}}">推广链接</a></li>
								<li><a id="/member/promotions" href="{{url('member/promotions')}}">推广查询</a></li>
								<li><a id="/introduce/RDMessenger" href="{{url('introduce/RDMessenger')}}">奖励计划</a></li>
							</ul>
						</li>
					@else
						<a class="inactive ICO-07"  href="{{url('member/promotions')}}" id="left-menu-messages" href="javascript:void(0);"> 推广查询</a>
 					@endif
 				@endif
           	</li>
		</ul>
	</div>
	

<!-- 礼品卡激活表单 -->
			<div class="modal" id="mCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				    	 <div class="modal-content" v-if="activeCardStatus">
				        	<div class="row">
				        		<div class="col-md-12  text-center" style="margin:15px;">
				        			<img alt="" src="{{asset('assets/css/plugins/slick/ajax-loader.gif')}}">  激活中
				        		</div>
				        	</div>
				        </div>
				        <div class="modal-content box" v-else>
					        <div class="modal-header">
					        	<h3 class="col-md-12" style="color:#4bd2bf">礼品卡充值</h3>
					        </div>
					        <div class="modal-body">
					           <div class="form-group">
					           		<label class="col-lg-3 control-label"><span style="color:red">*</span>孩子</label>
									<div class="col-lg-9">
										<template v-if="students==null">数据加载中</template>
										<select v-model="rechargeGiftCard.student_id" v-on:change="selectChild()" class="form-control"  v-else>
											<option value=''>请选择孩子</option>
											<option v-for="s in students"  :value='s.id'>[[ s.name ]]</option>
										</select>
			                   		</div>
			                   </div>
					           <div class="form-group">
					           		<label class="col-lg-3 control-label"><span style="color:red">*</span>卡号</label>
									<div class="col-lg-9">
										<input v-model="rechargeGiftCard.card" placeholder="卡号" class="form-control" type="text">
			                   		</div>
			                   </div>
			                   <div class="form-group">
					           		<label class="col-lg-3 control-label"><span style="color:red">*</span>密码</label>
									<div class="col-lg-9">
										<input v-model="rechargeGiftCard.card_pwd" placeholder="密码" class="form-control" type="password">
			                   		</div>
			                   </div>
			                   <div class="form-group">
					           		<label class="col-lg-3 control-label">联系人</label>
									<div class="col-lg-9">
										<input v-model="rechargeGiftCard.name" placeholder="联系人" class="form-control" type="text">
			                   		</div>
			                   </div>
			                   <div class="form-group">
					           		<label class="col-lg-3 control-label">联系电话</label>
									<div class="col-lg-9">
										<input v-model="rechargeGiftCard.tel" placeholder="联系电话" class="form-control" type="text">
			                   		</div>
			                   </div>
			                   <div class="form-group">
					           		<label class="col-lg-3 control-label">礼品寄送地址</label>
									<div class="col-lg-9">
										<input v-model="rechargeGiftCard.address" placeholder="礼品寄送地址" class="form-control" type="text">
			                   		</div>
			                   </div>
					        </div>
					        <div class="modal-footer">
					        	<div class="row">
					            	<div class="col-md-12">
						            	 <a href="javascript:void(0)" v-on:click="doRecharge()" class="fr button-01 margft10">确认激活</a>
										 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消激活</a>
									</div>
					            </div>
					        </div>
				        </div>
				       
				        <!-- /.modal-content -->
				    </div><!-- /.modal -->
				</div>
<!-- //礼品卡激活表单 -->

</div>
<script type="text/javascript">

//根据当前url改变菜单状态

$(window).ready(function(){
	$("#leftmenu .left-nav a").each(function(){
		if($(this).attr('id')=="{{ Request::getRequestUri() }}"){
			$(this).parent().addClass("active");
			$(this).parent().parent().show();
		}
	});
});

$(document).ready(function() {
	var currentm=null;
	$('#leftmenu').on('click','.inactive',function(){
		if(currentm==$(this).index('.inactive')){   //关闭当前菜单
			currentm=null;
		}else{
			currentm=$(this).index('.inactive');
		}
	    //打开菜单
        $(this).parent('li').siblings('li').removeClass('inactives');
        $(this).addClass('inactives');
        $(this).siblings('ul').slideDown(100).children('li');

        //关闭所有菜单
    	$(".inactive").each(function(){
	    	if(currentm==$(this).index('.inactive')){  //当前菜单不关闭
				return;
		    }
    		$(this).removeClass('inactives');
   	      
 	        $(this).siblings('ul').slideUp(100);
 	       
 	        $(this).siblings('ul').children('li').children('ul').parent('li').children('a').addClass('inactives');
 	       
 	        $(this).siblings('ul').children('li').children('ul').slideUp(100);
 	      
 	        $(this).siblings('ul').children('li').children('a').removeClass('inactives');
	    });
	})
});

var mmenu=new Vue({
 	el:"#leftmenu",
 	data:{
		students:null,
		rechargeGiftCard:{
			student_id:'',
			card:null,
			card_pwd:null,
			address:null,
			name:"{{ auth('member')->member->nickname }}",
			tel:"{{ auth('member')->member->cellphone }}"
		},
		activeCardStatus: false
 	},
 	created:function(){
 	 	this.getChildren();
 	 },
 	methods:{
 	 	//获取所有孩子的信息
 	 	getChildren:function(){
 	 		var _this=this;
 	 		$.ajax({
				url:"{{url('api/member/children/all')}}",
				type:"GET",
				data:{limit:1000},
				dataType:"json",
				success:function(json){
					_this.students=json.data;
				}
 	 		});
 	 	 },
 	 	//显示礼品卡充值界面
		showModel:function(){
			$("#mCardModal").modal({backdrop: 'static', keyboard: false});
		},
		//选择充值的孩子
		selectChild:function(){
			for(var i in this.students){
				if(this.students[i].id==this.rechargeGiftCard.student_id){
					this.rechargeGiftCard.address=this.students[i].province+this.students[i].city+this.students[i].area+this.students[i].address;
				}
			}
		},
		//充值
		doRecharge:function(){
			var _this=this;
			if(!_this.activeCardStatus && _this.checkRecharge()){
				_this.activeCardStatus = true;
				$.ajax({
					url:"{{url('api/member/giftCard/activeCard')}}",
					data:_this.rechargeGiftCard,
					type:"POST",
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.getChildren();
							$("#mCardModal").modal('hide');
							appAlert({
								'title':'提示',
								'msg':json.success
							});
						}else{
							$("#mCardModal").modal('hide');
							appAlert({
								'title':'错误提示',
								'msg':json.error,
								ok:{
									callback:function(){
										$("#mCardModal").modal({backdrop: 'static', keyboard: false});
									}
								},
								no:{
									callback:function(){
										$("#mCardModal").modal({backdrop: 'static', keyboard: false});
									}
								}
							});
						}
					},
					error:function(){
						alert('链接失败！');
					},
					complete: function () {
						_this.activeCardStatus = false;
					}
				});		
			}
		},
		//校验充值参数
		checkRecharge:function(){
			var error='';
			if(this.rechargeGiftCard.student_id==''){
				error='请选择孩子！';
			}else if(!this.rechargeGiftCard.card){
				error='请输入卡号！';
			}else if(!this.rechargeGiftCard.card_pwd){
				error='请输入卡密！';
			}
			if(error==''){
				return true;
			}else{
				$("#mCardModal").modal('hide');
				appAlert({
					title:"错误提示",
					msg:error,
					ok:{
						callback:function(){
							$("#mCardModal").modal({backdrop: 'static', keyboard: false});
						}
					},
					no:{
						callback:function(){
							$("#mCardModal").modal({backdrop: 'static', keyboard: false});
						}
					}
				});
				return false;
			}
		}
 	}
})
</script>
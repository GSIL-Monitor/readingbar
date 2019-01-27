<!-- 继承整体布局 -->
@extends('front::mobile.common.mainUC')

@section('content')
<!-- 扩展内容-->


<div class="container" id="mobileMenu">
	<ul class="member-zj100">
		<li class="am-g">
			<a href="{{ url('member/children/') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_10.png')}}" alt=""/></em>
			 	<span class="fl">孩子信息</span>
			 	<i class="am-icon-angle-right"></i>
			</a>
		</li>
		<li class="am-g">
			<a href="{{ url('member/children/starReport') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_01.png')}}" alt=""/></em>
			 	<span class="fl">测试报告</span>
			 <i class="am-icon-angle-right"></i>
			</a>
		</li>
		
		<li class="am-g">
			<a href="{{ url('borrowService/myBooks/plans') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_02.png')}}" alt=""/></em>
			 	<span class="fl">借阅书单</span>
			 <i class="am-icon-angle-right"></i>
			</a>
		</li>
		<li class="am-g">
			<a href="{{ url('member/children/readplan') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_02.png')}}" alt=""/></em>
			 	<span class="fl">阅读计划</span>
			 <i class="am-icon-angle-right"></i>
			</a>
		</li>
		<li class="am-g">
			<a href="{{ url('member/children/pointLog') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_03.png')}}" alt=""/></em>
			 	<span class="fl">我的蕊丁币</span>
			 	<i class="am-icon-angle-right"></i>
			</a>
		</li>
		<li class="am-g">
			<a href="{{ url('member/accountCenter/orders') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_04.png')}}" alt=""/></em>
			 	<span class="fl">我的订单</span>
			 	<i class="am-icon-angle-right"></i>
			</a>
		</li>
		<li class="am-g">
			<a href="{{ url('member/discount') }}" class="am-list-item-hd ">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_05.png')}}" alt=""/></em>
			 	<span class="fl">优惠券</span>
			 	<i class="am-icon-angle-right"></i>
			</a>
		</li>
		@if(auth('member')->checkPromoter())
			@if(auth('member')->checkRDMessenger())
			<li class="am-g">
				<a href="{{ url('member/promotions/wapMenu') }}" class="am-list-item-hd ">
					<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_06.png')}}" alt=""/></em>
				 	<span class="fl">蕊丁使者</span>
				 	<i class="am-icon-angle-right"></i>
				</a>
			</li>
			@endif
		@endif
		<li class="am-g">
			<a href="#" class="am-list-item-hd " v-on:click="showModel()">
				<em class="fl"><img src="{{url('home/wap/images/2017/icon/icon_my_07.png')}}" alt=""/></em>
			 	<span class="fl">礼品卡充值</span>
			 	<i class="am-icon-angle-right"></i>
			</a>
		</li>
		
	</ul>
	<div class="am-modal am-modal-prompt" tabindex="-1" id="mCardModal">
	  <div class="am-modal-dialog">
	   
	    <div class="am-modal-hd">礼品卡充值</div>
	    <div class="am-modal-bd">
	       <select v-model="rechargeGiftCard.student_id" v-on:change="selectChild()" class="am-modal-prompt-input">
											<option value=''>请选择孩子</option>
											<option v-for="s in students"  :value='s.id'>[[ s.name ]]</option>
			</select>
			<input v-model="rechargeGiftCard.card" placeholder="卡号" class="am-modal-prompt-input" type="text">
			<input v-model="rechargeGiftCard.card_pwd" placeholder="密码" class="am-modal-prompt-input" type="password">
			<input v-model="rechargeGiftCard.name" placeholder="联系人" class="am-modal-prompt-input" type="text">
			<input v-model="rechargeGiftCard.tel" placeholder="联系电话" class="am-modal-prompt-input" type="text">
			<input v-model="rechargeGiftCard.address" placeholder="礼品寄送地址" class="am-modal-prompt-input" type="text">
	    </div>
	    <div class="am-modal-footer am-text-center" v-if="activeCardStatus" >
	        <span style="line-height: 44px">激活中...</span>
	    </div>
	    <div class="am-modal-footer" v-else>
	      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
	      <span class="am-modal-btn"  v-on:click="doRecharge()" ">充值</span>
	    </div>
	  </div>
	</div>
</div>	
<script type="text/javascript">

var mmenu=new Vue({
 	el:"#mobileMenu",
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
			$("#mCardModal").modal();
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
						$("#mCardModal").modal();
						if(json.status){
							_this.getChildren();
							amazeAlert({
								'title':'提示',
								'msg':json.success
							});
						}else{
							amazeAlert({
								'title':'错误提示',
								'msg':json.error,
								onConfirm:function(){
									$("#mCardModal").modal();
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
				amazeAlert({
					title:"错误提示",
					msg:error,
					onConfirm:function(){
						$("#mCardModal").modal();
					}
				});
				return false;
			}
		}
 	}
})
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

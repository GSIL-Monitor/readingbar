<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')
@section('content')
<style type="text/css">
	.coupon-link{float: right;display: block; width: 60px;background: #e39d15;color: #fff;text-align: center;line-height: 30px;border-radius: 10px;}
	.coupon-list .coupon-text{    padding-top:0;}
	.am-form-label{    text-align: left;}
</style>
<section id="_DiscountList">
  <div class="container" >
  	<ul class="discount-list">
  		<template v-for="r in discounts.data">
			<li class="coupon-list" v-if="r.status==0">
	            <div class="fl coupon-money">
	                <span>￥[[ r.price ]]</span>
	                <em>[[ r.status_text ]]</em>
	            </div>
	            <!--<div class="fl coupon-dx"></div>-->
	            <div class="fl coupon-text">
	            	<a href="#" class=" am-btn-primary coupon-link"  data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, }" v-if='r.donation_able' v-on:click='selectDiscount(r)'>转赠</a>
	               	<p>[[ r.name ]]</p>
	               	<p>[[ r.expiration_time ]]</p>
	               	<p style="color: #f00;">仅限购买指定产品</p>
	            </div>
	        </li>
			<li class="coupon-list cl-gray" v-else>
	            <div class="fl coupon-money">
	                <span>￥[[ r.price ]]</span>
	                <em>[[ r.status_text ]]</em>
	            </div>
	            <!--<div class="fl coupon-dx"></div>-->
	            <div class="fl coupon-text">
	               	<p>[[ r.name ]]</p>
	               	<p>[[ r.expiration_time ]]</p>
	               	<p></p>
	            </div>
	        </li>
		</template>
  	</ul>
  	<div class="am-list-news-ft">
	   <a class="am-list-news-more am-btn am-btn-20 " href="javascript:void(0)" v-on:click="loadMore()">[[ loadBtn ]]</a>
	</div>
  </div>
   <!--/-->
	<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
	  <div class="am-modal-dialog">
	    <div class="am-modal-hd">选择转赠用户</div>
	    <div class="am-modal-bd">
	    	<div class="">
				<form action="" method="POST" enctype="" class="am-form am-form-horizontal">
					<div class="am-form-group am-form-group-sm">
					    <label class="am-u-sm-12 am-form-label">优惠券：</label>
					    <div class="am-u-sm-12"><input class="am-form-field" type="text" name="ukj" disabled v-model='donation.discount.name'  > </div>
					</div>
					<div class="am-form-group am-form-group-sm">
					    <label class="am-u-sm-12 am-form-label">赠与会员：</label>
					    <div class="am-u-sm-12">
							<select v-model='donation.username'  v-on:change='getMember()' class='form-control' >
		            				<option value='' selected>请选择会员</option>
		            				@foreach($members as $m)
		            							@if($m->cellphone)
		            								<option value="{{ $m->cellphone }}">{{ $m->nickname }}</option>
		            							@else
		            								<option value="{{ $m->email }}">{{ $m->nickname }}</option>
		            							@endif
		            				@endforeach
		            			</select>
					    </div>
					</div>
<!-- 					<div class="am-form-group am-form-group-sm"> -->
<!-- 					    <label class="am-u-sm-12 am-form-label">对方昵称：</label> -->
<!-- 					    <div class="am-u-sm-12"><input class="am-form-field" type="text" name="nicken_name" disabled v-model='donation.nickname'  > </div> -->
<!-- 					</div>  -->
				</form>
	    	</div>
	   		<div class="chose-child-tj"  >
				<button class="btn-mysure am-btn ds-ij2 fl  am-close-spin" v-on:click='doDonation()'>确定</button>
				<a class="btn-mycancel am-btn ds-ij3 fr am-close-spin" data-am-modal-close>取消</a>
			</div>
	  
	    </div>
	   
	  </div>
	</div>
	<!--/-->
</section>
<script type="text/javascript">
var _DiscountList=new Vue({
	el:'#_DiscountList',
	data:{
		discounts:null,
		search:{
			page:1,
			limit:5,
			type:"all"
		},
		loadBtn:"查看更多 »",
		donation:{
			discount:null,
			username:null,
			nickname:null
		},
	},
	created:function(){
		this.doGetDiscounts();
	},
	methods:{
		//获取用户折扣券
		doGetDiscounts:function(){
			var _this=this;
			_this.loadBtn="加载中...";
			$.ajax({
				url:"{{url('member/discount/getDiscountsList')}}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					if(_this.discounts){
						for(i in json.data){
							_this.discounts.data.push(json.data[i]);
						}
					}else{
						_this.discounts=json;
					}
					if(json.data.length){
						_this.search.page++;
						_this.loadBtn="查看更多 »";
					}else{
						_this.loadBtn="数据已全部加载完毕";
					}
				},
				errors:function(){
					
				}
		 	});
		},
		loadMore:function(){
			this.doGetDiscounts();
		},
		selectDiscount:function(discount){
			this.donation.discount=discount;
		},
		doDonation:function(){
			var _this=this;
			if(_this.checkUsername(_this.donation.username)){
				$.ajax({
					url:"{{url('member/discount/donation')}}",
					dataType:"json",
					data:{id:_this.donation.discount.id,username:_this.donation.username},
					success:function(json){
						if(json.status){
							_this.donation.discount.status_text='已转赠';
							_this.donation.discount.status=3;
							_this.donation.discount.donation_able=false;
							$('#doc-modal-1').modal('close');
							alert(json.success);
						}else{
							alert(json.error);
						}
					},
					errors:function(){
						
					}
			 	});
			}else{
				alert('请选择要赠送的用户！');
			}
		},
		getMember:function(){
			var _this=this;
			if(_this.checkUsername(_this.donation.username)){
				$.ajax({
					url:"{{url('member/discount/getPromotedMember')}}",
					dataType:"json",
					data:{username:_this.donation.username},
					success:function(json){
						_this.donation.nickname=json.nickname;
					},
					errors:function(){
						
					}
			 	});
			}
		},
		//校验账号是否是邮箱或手机
		checkUsername:function(username){
			var emailFomat=/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(username);
			var mobileFomat=/^1(3|4|5|7|8)\d{9}$/.test(username);
			if(emailFomat || mobileFomat){
				return true;
			}else{
				return false;
			}
		}
	}
})
</script>
@endsection
<!-- //继承整体布局 -->

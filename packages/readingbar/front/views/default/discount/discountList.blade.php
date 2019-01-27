<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->

<div class="container">
	<div class="row padt9">
	  	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	    </div>
	    <!--/ home-column-fl end-->
	    <div class="col-md-10 home-column-fr100" id="_DiscountList">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">优惠券列表</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="yhjlb" >
				<!--/-->
				<div class="table-responsive" style="margin-top: 50px;">
	        		<table class="table table-bordered discount-list yhjlb-slit" >
						<thead>
							<tr class="discount-list-titile">
								<th class="ddbj">优惠券</th>
								<th>限制消费产品</th>
								<th>面值（元）</th>
								<th>状态</th>
								<th>过期日期</th>
								<th class="ddbj2"  style=" border-right:0;">操作</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="r in discounts.data">
								<tr class="dis-not-used" v-if="r.status==0">
									<td>[[ r.name ]]</td>
									<th>
										<template v-for='p in r.products'>
												<span>【 [[ p.product_name ]] 】</span>
										</template>
									</th>
									<td>[[ r.price ]]</td>
									<td>[[ r.status_text ]]</td>
									<td>[[ r.expiration_time ]]</td>
									<td  style=" border-right:0;">
										<a class='btn btn-default' v-if='r.donation_able' v-on:click='selectDiscount(r)'>转赠</a>
									</td>
								</tr>
								<tr class="dis-Already-used" v-else>
									<td>[[ r.name ]]</td>
									<th>
										<template v-for='p in r.products'>
												<span>【 [[ p.product_name ]] 】</span>
										</template>
									</th>
									<td>[[ r.price ]]</td>
									<td>[[ r.status_text ]]</td>
									<td>[[ r.expiration_time ]]</td>
									<td style=" border-right:0;"></td>
								</tr>
							</template>
							
						</tbody>
					</table>
					<ul class="pagination pull-right" v-if="discounts.last_page>1">
				    	<li v-if="discounts.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
			    		<template v-for="p in discounts.last_page" v-if="Math.abs(discounts.current_page-(p+1))<=3">
			    			<li v-if="discounts.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
			    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
			    		</template>
				     	<li v-if="discounts.current_page < discounts.last_page" v-on:click="doChangePage(discounts.last_page)"><a>»</a></li>
			     	</ul>
                </div>
                <!--/-->
			</div>
			<!--/baseinfo-->
			<!-- 转赠弹出层 -->
	<div class="modal fade" id="donationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        	<div class="row">
            	<h3 class="col-md-12" style="color:#4bd2bf">选择转赠用户:</h3>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
		            <div class="col-md-12">
		            		<div class='form-group'>
		            			<lable>优惠券</lable>
		            			<input class='form-control'  v-model='donation.discount.name'  disabled>
		            		</div>
		            		<div class='form-group'>
		            			<lable>赠与会员</lable>
		            			<select v-model='donation.username'  v-on:change='getMember()' class='form-control' >
		            				<option value='' selected>请选择会员</option>
		            				@foreach($members as $m)
		            							@if($m->cellphone)
		            								<option value="{{ $m->cellphone }}">{{ $m->nickname }}</option>
		            							@else
		            								<option value="{{ $m->email }}">{{ $m->nickname }}"</option>
		            							@endif
		            				@endforeach
		            			</select>
<!-- 		            			<input class='form-control' v-model='donation.username'  v-on:keyup='getMember()'> -->
		            		</div>
<!-- 		            		<div class='form-group'> -->
<!-- 		            			<lable>对方昵称</lable> -->
<!-- 		            			<input class='form-control' disabled v-model='donation.nickname'> -->
<!-- 		            		</div> -->
            		</div>
            </div>
        </div>
        <div class="modal-footer">
        	<div class="row">
            	<div class="col-md-12">
	            	 <a href="javascript:void(0)" v-on:click="doDonation()" class="fr button-01 margft10">确认</a>
					 <a href="javascript:history.back()" class="fr button-02" data-dismiss="modal">取消</a>
				</div>
            </div>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- //转赠弹出层 -->
		</div>
		<!--/col-md-10-->	
	</div>
	<!--/row end-->

</div>
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
			$.ajax({
				url:"{{url('member/discount/getDiscountsList')}}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					_this.discounts=json;
				},
				errors:function(){
					
				}
		 	});
		},
		doChangePage:function(page){
			this.search.page=page;
			this.doGetDiscounts();
		},
		selectDiscount:function(discount){
			this.donation.discount=discount;
			$('#donationModal').modal('show');
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
							_this.doGetDiscounts();
							$('#donationModal').modal('hide');
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
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

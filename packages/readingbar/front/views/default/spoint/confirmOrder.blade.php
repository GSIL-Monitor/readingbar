<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<style>
		body{ background-color:#f7f7f7;}
	</style>

<div class="content" id="main">
	<div class="container">
		<div class="tjj-spoint-childpage">
			<span>您的位置</span>
			<a href="{{ url('member/spoint/product') }}">商城</a>
			<a href="#" class="active">订单确认</a>
		</div>
	</div>
	<div class="container">
			<div class="tjj-spoint-content995-1">
				<div class="tjj-title-line-1">
						确认产品信息
				</div>
				<br>
				<div class="row">
					<ul class="tjj-spoint-product-list tjj-dc-680">
						<li v-for="p in products">
							<div class="p-img">
								<img alt="" :src="p.image" >
							</div>
							<div >
							   <p class="p-name">[[ p.product_name ]]</p>
							   <p class="p-desc">[[ p.desc ]]</p>
							</div>
							<div class="p-quantity tjj-color-ff4e00">
								[[ p.quantity ]]
							</div>
							<div class="p-total-points tjj-color-ff4e00">
								<img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" >[[ p.point*p.quantity ]]
							</div>
						</li>
					</ul>
				</div>
				<br>
				
				<br>
				<div class="tjj-title-line-1">
						确认个人信息
				</div>
				<div class="row">
					<ul class="tjj-spoint-child-list col-xs-12">
						<li v-for="c in children">
							<div class="c-radio">
								<input type="radio"   :value="c.id"  name="pay_child" v-model="student_id">
							</div>
							<div class="c-avatar">
								<img alt=""  :src="c.avatar">
							</div>
							<div>
							    <div  class="c-name">姓名：[[ c.nick_name ]]</div>
								<div  class="c-nickname">昵称：[[ c.nick_name ]]</div>
	      						<div  class="c-points"><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" >  [[ c.point ]]</div>
							</div>
	      					
						</li>
					</ul>
				</div>
				<br>
				<div  class="row">
					<div class="col-xs-12">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<div class="tjj-spoint-input">
										<span>地址：</span>
										<input type="text" address="" v-model='address'>
								</div>
							</div>
							<div class="col-xs-1"></div>
					</div>
					
					<br><br><br>
					<div class="col-xs-12">
							<div class="col-xs-1"></div>
							<div class="col-xs-5">
								<div class="tjj-spoint-input">
										<span>电话：</span>
							<input type="text" address="" v-model='tel'>
								</div>
							</div>
							<div class="col-xs-5">
								<div class="tjj-spoint-input">
										<span>收货人：</span>
							<input type="text" address="" v-model='reciver'>
								</div>
							</div>
							<div class="col-xs-1"></div>
					</div>
					<br><br><br>
					<div class="col-xs-12 tjj-font-size-16">
							<div class="col-xs-9"></div>
							<div class="col-xs-3">
									<span class="tjj-color-333333  ">余额：</span>
									<span><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" ><span class="tjj-color-ff4e00">[[ last_points ]]</span></span>
							</div>
							<div class="col-xs-9"></div>
							<div class="col-xs-3">
								
									<span class="tjj-color-48cbb9">实付：</span>
										<span><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" ><span class="tjj-color-ff4e00">[[ total ]]</span></span>
								
							</div>
							
							<div class="col-xs-9"></div>
							<div class="col-xs-3">
									<br>
									<a v-on:click="pay()" class="tjj-btn-default-big">确认支付</a>
							</div>
					</div>
				</div>
	</div>
</div>
<script type="text/javascript">
	new Vue({
		el:"#main",
		data:{
			products:{!! $products !!},
			children:{!! $children !!},
			total:0,
			student_id:null,
			address:'',
			last_points:0,
			tel:"{{ auth('member')->member->cellphone }}",
			reciver:"{{ auth('member')->member->nickname }}",
		},
		watch:{
			student_id:function(n,o){
				for(c in this.children){
					if(this.children[c].id==this.student_id){
							this.address=this.children[c].address;
							this.last_points=this.children[c].point;
					}
			   }
			   return n;
			}
		},
		created:function(){
			this.getTotal();
		},
		methods:{
			//获取总价格
			getTotal:function(){
				for(i in this.products){
					this.total+=this.products[i].point*this.products[i].quantity;
				}
			},
			//支付
			pay:function(){
				var _this=this;
				if(!_this.checkPay()){
					return false;
				}
				if(_this.products.length==1){
					$.ajax({
						url:"{{ url('member/spoint/order/payProduct') }}",
						data:{
							product_id:_this.products[0].product_id,
							quantity:_this.products[0].quantity,
							student_id:_this.student_id,
							address:_this.address,
							tel:_this.tel,
							reciver:_this.reciver
						},
						dataType:"JSON",
						success:function(json){
							if(json.status){
								appAlert({
									title:"提示",
									msg:"支付成功",
									ok:{
										text:"返回订单",
										callback:function(){
											window.location.href="{{ url('/member/spoint/order/log') }}";
										}
									}
								});
							}else{
								alert(json.error);
							}
						}
					});
				}else if(_this.products.length>1){
					$.ajax({
						url:"{{ url('member/spoint/order/payCart') }}",
						data:{
							student_id:_this.student_id,
							address:_this.address,
							tel:_this.tel,
							reciver:_this.reciver
						},
						dataType:"JSON",
						success:function(json){
							if(json.status){
								appAlert({
									title:"提示",
									msg:"支付成功",
									ok:{
										text:"返回订单",
										callback:function(){
											window.location.href="{{ url('/member/spoint/order/log') }}";
										}
									}
								});
							}else{
								alert(json.error);
							}
						}
					});
				}
			},
			checkPay:function(){
					if(this.products.length==0){
						alert('请选择购买商品！');
						return false;
					}else if(this.student_id==null){
						alert('请选择要支付的孩子！');
						return false;
					}else if(this.address==''){
						alert('请填写地址！');
						return false;
					}else{
						for(c in this.children){
								if(this.children[c].id==this.student_id){
										if(this.total>this.children[c].point){
											alert('蕊丁币不足，赶快去赚吧~');
											return false;
										}
								}
						}
					}
					return true;
			}
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->

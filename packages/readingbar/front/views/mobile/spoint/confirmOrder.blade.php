<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">

<section id="main">
	<div class="am-g am-g-fixed prdetail01 confirmCart-dress">
	  	<div class="am-u-sm-2"><img src="{{url('home/wap/images/sp/sp4_1.png')}}" alt=""/></div>
	  	<div class="am-u-sm-10">
	  
	  		<div class="am-input-group">
			  	<span class="am-input-group-label">收货地址</span>
			 	<input type="text" address="" v-model='address' class="am-form-field" >
			</div>
			<!--/am-input-group-->
			<div class="am-input-group">
			  	<span class="am-input-group-label">联系电话</span>
			  	<input type="text" address="" v-model='tel' class="am-form-field" >
			</div>
			<!--/am-input-group-->
			<div class="am-input-group">
			 	<span class="am-input-group-label">收件人</span>
				<input type="text" address="" v-model='reciver' class="am-form-field" >
			</div>
			<!--/am-input-group-->
	  	</div>
	</div>
	<!--/am-g prdetail01-->
	<div class="prdetail01">
		<ul class="am-g am-g-fixed confirmCart-prolist">
			<li v-for="p in products">
				<div class="am-u-sm-4"><img  class="am-img-responsive"  :src="p.image"></div>
			  	<div class="am-u-sm-8">
			  		<h4> [[ p.product_name ]]</h4>
			  		<p>[[ p.desc ]]</p>
			  		<em>
			  			<span class="fl"><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" >[[ p.point*p.quantity ]]</span>
			  			<span class="fr">X[[ p.quantity ]]</span>
			  		</em>
			  	</div>
			</li>
		</ul>
		<!--/confirmCart-prolist-->
	</div>
	<!--/aprdetail01-->
	<div class="am-g">
		<ul class="am-g am-g-fixed confirmCart-hzlsit">
			<li v-for="c in children">
				<div class="am-u-sm-4"><img alt=""  :src="c.avatar"></div>
			  	<div class="am-u-sm-7">
			  		<em>
			  			<span>姓名：[[ c.nick_name ]]</span>
						<span>昵称：[[ c.nick_name ]]</span>
	      				<span><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" >  [[ c.point ]]</span>
			  		</em>
			  	</div>
			  	<div class="am-u-sm-1"><input type="radio"   :value="c.id"  name="pay_child" v-model="student_id"></div>
			</li>
		</ul>
		<!--/confirmCart-prolist-->
	</div>
	<!--/am-g-->
	<div class=" confirmCart-zj-momo">
		<div class="am-g confirmCart-zj ">
			<div class="am-u-sm-4 am-u-end">
			 	<span class="">余额：</span>
				<span><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" ><span class="tjj-color-ff4e00">[[ last_points ]]</span></span>
			</div>
		</div>
		<!--/am-g-->
		<div class="am-g confirmCart-zj ">
			
			<div class="am-u-sm-4 am-u-end">
			 	<span class="">实付：</span>
				<span><img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" ><span class="tjj-color-ff4e00">[[ total ]]</span></span>
			</div>
			<!--/am-u-sm-2am-u-end-->
		</div>
		<div class="am-g confirmCart-zj ">
			<div class="am-u-sm-4 am-u-end">
				<a class="tjj-btn-carbutton am-btn-primary" v-on:click="pay()"  >确认支付</a>
			</div>
			<!--/am-u-sm-2am-u-end-->
		</div>
		<!--/am-g-->
	</div>
</section>
<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">
<!--       <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a> -->
    </div>
    <div class="am-modal-bd confirmCartmodal-bd">
     	<p>支付成功!</p>
     	<!--<a href="javascript: void(0)" class="confirmCart-close" data-am-modal-close>返回订单页</a-->
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
				pl=_this.getPL();
				if(pl==1){
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
								$("#doc-modal-1").modal("open");
								setTimeout(function(){
									window.location.href="{{ url('member/spoint/order/log') }}"
								}, 1000);
							}else{
								alert(json.error);
							}
						}
					});
				}else if(pl>1){
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
								$("#doc-modal-1").modal("open");
								setTimeout(function(){
										window.location.href="{{ url('member/spoint/order/log') }}"
								}, 1000);
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
			},
			getPL:function(){
				var num=0;
				for(i in this.products){
					num++;
				}
				return num;
			}
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->

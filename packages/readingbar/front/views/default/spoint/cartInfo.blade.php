<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
	<style>
		body{ background-color:#f7f7f7;}
	</style>
	
	
    <div class="content "  id="main">
      		<div class="container">
				<div class="tjj-spoint-childpage">
					<span>您的位置</span>
					<a href="{{ url('member/spoint/product') }}">商城</a>
					<a href="#" class="active">购物车</a>
				</div>
			</div>
			<div class="container">
				<div class="tjj-spoint-content995-1">
					<div class="row">
						<div class="tjj-dc-740">
							<div class="col-xs-6 text-left tjj-pd-10" >
								<input type="checkbox" style="margin:0px;"v-model='selectAll'>
								<span class="tjj-font-size-14">全选</span>
							</div>
							<div class="col-xs-6 text-right tjj-pd-10">
								<a href="javascript:void(0)" class="	glyphicon glyphicon-trash" v-on:click="showDelete()"></a>
							</div>
						</div>
					</div>
					<div class="row">
						<ul class="tjj-dc-740 tjj-spoint-product-list ">
							<li v-for="p in products">
								<div class="p-checkbox">
									<input type="checkbox"  v-model="p.pay_status"   value="true"  v-on:change="update(p)">
								</div>
								<div class="p-img">
									<img alt="" :src="p.image" >
								</div>
								<div >
								   <p class="p-name">[[ p.product_name ]]</p>
								   <p class="p-desc">[[ p.desc ]]</p>
								</div>
								<div class="p-quantity tjj-color-ff4e00">
									<a href="javascript:void(0)"><img src="{{url('home/pc/images/spoint/shoppingcart_7.png')}}" alt="" v-on:click="changeQuantity(p,-1)"></a>
									[[ p.quantity ]]
									<a href="javascript:void(0)"><img src="{{url('home/pc/images/spoint/shoppingcart_8.png')}}" alt=""  v-on:click="changeQuantity(p,1)"/></a>
								</div>
								<div class="p-total-points tjj-color-ff4e00">
									<img alt=""  src="{{ asset('home/pc/images/spoint/rssc_32.png')}}" >[[ p.point*p.quantity ]]
								</div>
								<div class="p-total-points tjj-color-ff4e00">
									<!-- 已收藏 -->
	     							<a href="javasctript:void(0)"  v-if="p.collection_status"> 已收藏</a>
	     							<!-- 未收藏 -->
	     							<a v-on:click="addCollection(p)" href="javasctript:void(0)" v-else>收藏</a>
								</div>
								<a href="javascript:void(0)" class="tjj-btn-remove	glyphicon glyphicon-remove" v-if="deleteStatus" v-on:click="remove(p)"></a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="tjj-dc-740">
							<div class="col-xs-6 text-left tjj-pd-10" >
								<input type="checkbox" style="margin:0px;" v-model='selectAll'>
								<span class="tjj-font-size-14">全选</span>
							</div>
							<div class="col-xs-6 text-right tjj-pd-10">
								<div v-if="pay_quantity>0">
									已经选择<span class="tjj-color-ff4e00">[[ pay_quantity ]]</span>商品，合计<span class="tjj-color-ff4e00">[[ pay_total ]]</span><img alt="" src="{{ url('home/pc/images/spoint/rssc_32.png') }}">
								</div>
								<div v-else>
									 尚未选择商品，请选择
								</div>
								<div>
									<br>
									<a class="tjj-btn-default" href="{{ url('member/spoint/order/confirmCart') }}">立即支付</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
    </div>
<script type="text/javascript">
	new Vue({
		el:"#main",
		data:{
			products:[],
			search:{
				page:1,
				limit:5,
				order:'id',
				sort:'desc',
				catagory_id:''
			},
			deleteStatus:false,
			pay_quantity:0,
			pay_total:0,
			selectAll:true,
		},
		watch:{
			selectAll:function(n,o){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/cart/selectAll') }}",
					data:{'selectAll':n},
					dataType:"json",
					success:function(json){
						_this.getTotalInfo();
					}
				});
				for(i in _this.products){
					_this.products[i].pay_status=n;
				}
				return n;
			}
		},
		created:function(){
			this.getCart();
		},
		methods:{
			//获取积分商品
			getCart:function(){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/cart/getCart') }}",
					data:_this.search,
					dataType:"json",
					success:function(json){
						_this.products=json.products;
						_this.getTotalInfo();
					}
				});
			},
			//修改购物数据
			update:function(p){
				var _this=this;
				_this.checkQuantity(p);
				$.ajax({
					url:"{{ url('member/spoint/cart/update') }}",
					data:{
						'quantity':p.quantity,
						'product_id':p.product_id,
						'pay_status':p.pay_status,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							_this.getTotalInfo();
						}else{
							alert(json.error);
						}
					}
				});
			},
			//修改数量
			changeQuantity:function(p,n){
				if(n>0){
					p.quantity++;
				}else{
					p.quantity--;
				}
				this.update(p);
			},
			//校验数量
			checkQuantity:function(p){
				if(p.quantity>p.stock_quantity){
					p.quantity=p.stock_quantity;
				}else if(p.quantity<1){
					p.quantity=1;
				}
			},
			//移出购物车
			remove:function(p){
				var _this=this;
				_this.checkQuantity(p);
				$.ajax({
					url:"{{ url('member/spoint/cart/remove') }}",
					data:{
						'product_id':p.product_id,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							for(i in _this.products){
								if(_this.products[i].product_id==p.product_id){
										_this.products.splice(i,1);
									}
						    }
							_this.getTotalInfo();
						}else{
							alert(json.error);
						}
					}
				});
			},
			//加入收藏
			addCollection:function(p){
				var _this=this;
				$.ajax({
					url:"{{ url('member/spoint/collection/add') }}",
					data:{
						'product_id':p.product_id,
					},
					dataType:"json",
					success:function(json){
						if(json.status){
							p.collection_status=true;
						}else{
							alert(json.error);
						}
					}
				});
			},
			//删除按钮显示
			showDelete:function(){
				this.deleteStatus=!this.deleteStatus;
			},
			//获取总信息
			getTotalInfo:function(){
				var quantity=0;
				var total=0;
				for(i in this.products){
					if(this.products[i].pay_status){
						quantity+=parseInt(this.products[i].quantity);
						total+=parseInt(this.products[i].quantity)*parseInt(this.products[i].point);
					}
				}
				this.pay_quantity=quantity;
				this.pay_total=total;
			}
		}
	});
</script>
@endsection
<!-- //继承整体布局 -->

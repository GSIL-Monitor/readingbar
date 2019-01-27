<!-- 继承整体布局 -->
@extends('front::mobile.common.mainSpoint')

@section('content')
<link rel="stylesheet" href="{{url('home/wap/css/spoint.css')}}">
<section id="main">
	<!-- 产品列表 -->
     <div class="am-g">
		<ul class="carprolsit">
			<li v-for="p in products">
				<input type="checkbox"  v-model="p.pay_status"   value="true"  v-on:change="update(p)" class="choose" > 
				<div class="carprolsit-01">
					<div class="fl pic"><img alt=""  :src="p.image" width="100%"></div>
					<div class="fl carpro-conter">
						<h4>[[ p.product_name ]]</h4>
						<span>[[ p.desc ]]</span>
						<p>
							<span class="fl"><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt="" />[[ p.point ]]</span>
						</p>
					</div>
				</div>
				<!--/carprolsit-01-->
				<div class="carprolsit-02">
					<span class="fl">购买数量</span>
					<span class="fr">
						<b>库存：[[ p.stock_quantity ]]</b>
						<div class="fl">
							<a v-on:click="changeQuantity(p,1)" href="javascript:void(0)">+</a>
							<input v-model="p.quantity" v-on:change="update(p)" disabled>
							<a v-on:click="changeQuantity(p,-1)"  href="javascript:void(0)">-</a>
						</div>
					</span>
				</div>
				<!--/carprolsit-02-->
			</li>
		</ul>
		<div class="am-g carbutton-chose">
			<div class="fl ">
				<input type="checkbox" style="margin:0px;" v-model='selectAll'>
				<span class="tjj-font-size-14">全选</span>
			</div>
		</div>
		<!--/am-g-->
		<div class="am-g carbutton-chose2">
			
				<span>已经选择<b>[[ pay_quantity ]]</b>件产品</span>
				<span>合计<b>[[ pay_total ]]</b><img src="{{url('home/wap/images/sp/sp3_2.png')}}" alt=""/ width="20px"></span>
			
		</div>
		
		<!--/am-g-->
		<a class="tjj-btn-carbutton" href="{{ url('member/spoint/order/confirmCart') }}">立即支付</a>
     </div>
    <!-- 产品列表 -->
</section>

<!-- /扩展内容 -->
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

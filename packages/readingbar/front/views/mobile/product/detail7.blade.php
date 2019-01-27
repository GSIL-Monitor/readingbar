<!-- 整体布局 -->
<html>
	<head>
		<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>{{ $head_title or '蕊丁吧'}}</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
		<meta name="viewport"content="width=device-width, initial-scale=1">
		<meta name="renderer" content="webkit"> 
		<meta http-equiv="Cache-Control" content="no-siteapp"/>
		<!--css-->
		<link rel="stylesheet" href="{{url('home/wap/css/amazeui.min.css')}}">
		 <link rel="stylesheet" type="text/css" href="{{url('home/t-btns/btn.css')}}">
		<link rel="stylesheet" href="{{url('home/wap/css/app.css')}}">
		<!--js-->
		<script src="{{url('home/wap/js/jquery-2.1.1.js')}}"></script>
		<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.js"></script>
		<script type="text/javascript" src="{{url('home/wap/js/jquery.SuperSlide.2.1.1.js')}}"></script>
		<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': "{{ csrf_token() }}"
		    }
		});
		</script>
		<script src="{{url('home/wap/js/amazeui.js')}}"></script>
		<!--vuejs-->
		<script src="{{url('home/wap/js/vue/vue.min.js')}}"></script>
		<script type="text/javascript">
			//vuejs边界符修改
			Vue.config.delimiters = ['[[', ']]']; 
		</script>
		<script type="text/javascript">
		    //判断手机还是移动界面
			function browserRedirect() {
				var sUserAgent = navigator.userAgent.toLowerCase();
				var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
				var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
				var bIsMidp = sUserAgent.match(/midp/i) == "midp";
				var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"; 
				var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
				var bIsAndroid = sUserAgent.match(/android/i) == "android";
				var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce"; 
				var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
				if ((bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) )
				{                      
					//window.location.href="{{url('/?theme=mobile')}}";
				}else{
					//window.location.href="{{ url('/?theme=default') }}";
				}             
			}             
			browserRedirect();
		</script>
		<!--/vuejs-->
	</head>
	<body>
		
		
		<!-- 整体布局被扩展 kxf.jpg-->
		<section>
<!-- 			<img src="{{url('home/wap/images/2017/kxf.jpg')}}" class="am-img-responsive"> -->
			<article class="Singleread">
				<h4>STAR英文阅读能力测评系统</h4>
				<h4><b class="cob6efd0">30</b>年客观专业的大数据分析</h4>

				<p><b class="coff8400">1</b>次STAR测评</p>
				<p>共<b class="coff8400">34</b>道题目</p>
				<p>只需花费<b class="coff8400">20</b>分钟</p>
				<p>就可了解</p>
				<p><b class="cob6efd0">GE：</b>孩子目前的阅读水平相当于美国孩子的什么水平</p>
				<p><b class="cob6efd0">ZPD：</b>适合孩子阅读书籍的分级范围 </p>
				<p>根据测评报告选择符合阅读能力范围内的书</p>
				<p>让选书不再盲目，不费劲</p>
				<p>让阅读变得简单，易坚持</p>
				<span>购买仅需98元，还送199元优惠券！</span>
				@if(auth('member')->isLoged())
					<button v-on:click="skipProtocol(8)"  type="button" class="am-btn am-btn-primary am-radius" >点击购买</button>
				@else
					<button v-on:click="alertLogin()" type="button" class="am-btn am-btn-primary am-radius">点击购买</button>
				@endif
			</article>
		</section>
		<!-- /整体布局被扩展 -->
		

<!-- /扩展内容 -->
<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">
			用户付费购买须知内容 <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<div class="" style="overflow-y: scroll; height: 60%">

				<div class="product-txt">
				
				<p>押金、损耗和赔偿</p>
				<p>1.会员在购买此项服务时，同时需要缴纳图书借阅押金800元。</p>
				<p>2.蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：</p>
				<p>2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。</p>
				<p>2.2 若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。</p>
				<p>2.3 出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。</p>
				<p>3 书籍定价</p>
				<p>3.1 书籍的价值以每本书的RMB标价为准。RMB标价按照以下方式计算：</p>
				<p>3.1.1 对图书上标有美元定价的， RMB标价按照以书籍上美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
				<p>3.1.2 对图书上未标出美元定价的，RMB标价按照相同ISBN书籍的亚马逊网站的美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
					<a href="javascript:void(0)" v-on:click="setProtocol()"
						class="product-txt-link">同意并支付</a> <a href="javascript:void(0)"
						data-am-modal-close class="product-txt-link2 ">不同意</a>
				</div>
				<div class="am-modal-footer">
					<span class="am-modal-btn" data-am-modal-cancel>取消</span> <span
						class="am-modal-btn" data-am-modal-confirm>确定</span>
				</div>

				<!--/modal-footer-->
			</div>
			<!--/-->
		</div>
	</div>
</div>
		<!-- 孩子选择-模态框（Modal） -->
<div class="am-modal am-modal-no-btn" tabindex="-1"
	id="selectChildModal">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">
			<span>选择孩子购买产品</span> <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<temlpate v-for="s in students">
		
			<div v-if="checkArea(s)">
				<button v-if="buy.student_id==s.id" class="chose-childname2"
					v-on:click="setStudent(s.id)">[[s.name]]</button>
				<button v-else class="chose-childname" v-on:click="setStudent(s.id)">[[s.name]]</button>
			</div>
			</temlpate>
		</div>
		<!--/-->
		<div class="chose-child-tj">
			<button class="btn-mysure am-btn ds-ij2 fl cd-popup-close"
				v-on:click="goConfirm()">确定</button>
			<a class="btn-mycancel am-btn ds-ij3 fr cd-popup-close"
				v-on:click="cancel()">取消</a>
		</div>
		<!--/-->
	</div>
</div>
		<!-- 孩子选择-模态框（Modal） -->

<div class="am-modal am-modal-no-btn" tabindex="-1" id="no-stock">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd">
		      <a href="javascript: void(0)" class="am-close am-close-spin camp_close" data-am-modal-close>&times;</a>
		    </div>
		    <div class="am-modal-bd camp_modal">
		     <span>此商品已售尽，下次记得早点来哦~</span>
		     <a href="{{ url('/') }}">返回首页</a>
		    </div>
		  </div>
		</div>	
		
<script>
	var product_list=new Vue({
		el:"body",
		data:{
			products:{!! json_encode($products) !!},
			students:{!! json_encode($students) !!},
			buy:{
				product_id:null,
				student_id:null,
				protocol:false
			},
			service_area:null
		},
		methods:{
			setProduct:function(id){
				this.clearBuy();
				for(i in this.products){
					if(this.products[i].id==id){
						this.service_area=this.products[i].service_area;
						this.buy.product_id=id;
						break;
					}
				}
			},
			skipProtocol:function(id){
				alert('此商品已售完!');
// 				if(this.getLastQuantity(id)==0){
// 					$("#no-stock").modal('open');
// 				}else{
// 					this.setProduct(id);
// 					this.buy.protocol=true;
// 					$("#selectChildModal").modal('open');
// 				}
			},
			setProtocol:function(){
				this.buy.protocol=true;
				if(this.students.length==0){
					alert('请添加孩子！');
					window.location.href="{{ url('/member') }}";
					return;
				}
				$("#doc-modal-1").modal('close');
				$("#selectChildModal").modal('open');
			},
			setStudent:function(id){
				this.buy.student_id=id;
			},
			clearBuy:function(){
				this.buy={
						product_id:null,
						student_id:null,
						protocol:false
				};
			},
			goConfirm:function(){
				url="{{url('member/pay/confirm')}}";
				if(this.buy.product_id==null){
					alert('请选择产品！');
					return;
				}
				if(!this.buy.protocol){
					alert('您为同意购买协议！');
					return;
				}
				if(this.buy.student_id==null){
					alert('请选择孩子！');
					return;
				}
				window.location.href=url+"?product_id="+this.buy.product_id+"&protocol="+this.buy.protocol+"&student_id="+this.buy.student_id;
			},
			cancel:function(){
				$("#selectChildModal").modal('close');
			},
			//提示登录
			alertLogin:function(){
				alert('您尚未登录！');
				window.location.href="{{ url('/login') }}";
			},
			//校验孩子所在地与产品服务区域是否匹配
			checkArea:function(s){
				if(this.service_area=='全国'){
					return true;
				}else if(this.service_area.indexOf(s.province)!=-1){
					return true;
				}else{
					return false;
				}
			},
			getLastQuantity:function(id){
				for(i in this.products){
					if(this.products[i].id==id){
						return this.products[i].quantity;
					}
				}
				return 0;
			}
		}
	});
	@if($errors->has('product_id'))
		alert('选购的产品不存在！');
	@endif
</script>
		<!-- 整体布局包含footer -->
		@include('front::mobile.common.footer')
		<!-- /整体布局包含footer -->
		
	</body>
</html>
<!-- /整体布局 -->
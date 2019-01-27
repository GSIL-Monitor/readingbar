<!-- 整体布局 -->
<html>
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>{{ $head_title or '蕊丁吧'}}</title>
		<meta name="description" content="{{ $setting['description'] or '蕊丁吧'}}">
		<meta name="keywords" Content="{{ $setting['keywords'] or '蕊丁吧'}}">
        <meta name="author" content="">
        <!-- 百度站长验证  -->
        <meta name="baidu-site-verification" content="3i5fyO10zI" />
         <link rel="icon" href="{{ asset('logo.png')}}"  type="image/x-icon"/>
        <link rel="shortcut icon" href="">
        <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/bootstrap.min.css')}}">
       
	    <script src="{{url('home/pc/js/jquery-2.1.1.js')}}"> </script>
		<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.js"></script>
	    <script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': "{{ csrf_token() }}"
		    }
		});
		</script>
	    <script src="{{url('home/pc/js/bootstrap.js')}}"></script>
	    <!--vuejs-->
	    <script src="{{url('home/pc/js/vue/vue.min.js')}}"></script>
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
					window.location.href="{{url('/?theme=mobile')}}";
				}else{
					//window.location.href={{url('/?theme=default')}};
				}             
			}             
			browserRedirect();
		</script>
	    <!--/vuejs-->
	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	    <!--my--> 
	    <script type="text/javascript">
		    $(function () {
		    	$('.propoer_hover_html').popover({
						trigger:'hover', //触发方式
						html: true, // 为true的话，data-content里就能放html代码了
			    });
		    	$('.propoer_hover_string').popover({
					trigger:'hover', //触发方式
					html: false, // 为true的话，data-content里就能放html代码了
		   		 });
		    	$('.propoer_click_html').popover({
					trigger:'click', //触发方式
					html: true, // 为true的话，data-content里就能放html代码了
		    	});
		    	$('.propoer_click_string').popover({
					trigger:'click', //触发方式
					html: false, // 为true的话，data-content里就能放html代码了
		   		 });
			});		
		</script>
	    <link rel="stylesheet" type="text/css" href="{{url('home/t-btns/btn.css')}}">
	    <link rel="stylesheet" type="text/css" href="{{url('home/pc/css/style.css')}}">
	</head>
	
	<body>
	@include('front::default.common.jsConfirm')
	<!-- 扩展内容-->
	<div class="container marginout" >
<!-- 		<div class="Singleread-banner"><img src="{{  asset('home/pc/images/2017/ban100_01.jpg') }}"></div> -->
		<div class="Singleread">
			<div><h4>STAR英文阅读能力测评系统</h4>
			<h4><b class="cob6efd0">30</b>年客观专业的大数据分析</h4></div>

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
				<button v-on:click="showProtocalModal()"><img src="{{  asset('home/pc/images/2017/but100_01.png') }}"></button>
			@else
				<button v-on:click="alertLogin()"><img src="{{  asset('home/pc/images/2017/but100_01.png') }}"></button>
			@endif
		</div>
	</div>
	<div class="mon bgffcc00" style="height: 100px;"></div>
	<!-- 整体布局包含footer -->	
		@if(Request::getRequestUri()!='/')
			@include('front::default.common.footer')
		@endif
		@include('front::default.common.fixed_message')
		<!-- /整体布局包含footer -->

<!-- 模态框（Modal） -->
<div class="modal fade" id="protocolModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="" style="overflow-y: scroll; height: 60%">
					<h1 class="product-h1 textcenter">用户付费购买须知内容</h1>
					<div class="product product-txt ">
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
							data-dismiss="modal" class="product-txt-link">不同意</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 模态框（Modal）end -->
<!-- 孩子选择-模态框（Modal） -->
<div class="modal fade" id="selectChildModal" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>选择孩子购买产品</span>
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">

				<temlpate v-for="s in students">
					<div v-if="checkArea(s)">
						<button v-if="buy.student_id==s.id" class="btn btn-primary "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
						<button v-else class="btn btn-default "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
					</div>
				</temlpate>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					v-on:click="goConfirm()">确认</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 孩子选择-模态框（Modal）end -->    
<script>
	var product_list=new Vue({
		el:"body",
		data:{
			product_id:8,
			last_quantity:0,
			products:{!! json_encode($products) !!},
			students:{!! json_encode($students) !!},
			buy:{
				product_id:null,
				student_id:null,
				protocol:false
			},
			service_area:null
		},
		created:function(){
			 this.last_quantity=this.getLastQuantity();
			 this.setProduct();
		},
		methods:{
			//设置要购买的产品
			setProduct:function(){
				this.clearBuy();
				for(i in this.products){
					if(this.products[i].id==this.product_id){
						this.service_area=this.products[i].service_area;
						this.buy.product_id=this.product_id;
						break;
					}
				}
			},
			showProtocalModal:function(){
				appAlert({
					title: '通知',
					msg: '此商品已售完!'
				})
				//this.setProtocol();
			},
			//同意购买协议
			setProtocol:function(){
				this.buy.protocol=true;
				if(this.students.length==0){
					alert('请添加孩子！');
					window.location.href="{{ url('/member') }}";
					return;
				}
				$("#protocolModal").modal('hide');
				$("#selectChildModal").modal('show');
			},
			//设置购买产品的孩子信息
			setStudent:function(id){
				this.buy.student_id=id;
			},
			//清空购物信息
			clearBuy:function(){
				this.buy={
						product_id:null,
						student_id:null,
						protocol:false
				};
			},
			//校验&确认购买信息
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
			//提示登录
			alertLogin:function(){
				alert('您尚未登录！');
				window.location.href="{{ url('/login?intended='.request()->path()) }}";
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
			/*获取已经报名的人数*/
		   getLastQuantity:function(){
			   for(i in this.products){
					if(this.products[i].id==this.product_id){
						if(this.products[i].quantity>5){
							return 5;
						}else{
							return this.products[i].quantity;
						}
					}
				}	
			}
		}
	});
	@if($errors->has('product_id'))
		alert('选购的产品不存在！');
	@endif
</script>
	</body>
</html>
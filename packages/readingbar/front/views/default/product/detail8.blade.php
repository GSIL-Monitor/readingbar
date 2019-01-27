<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<div  id="product8">  
<section>
	<div><a href="javascript:void(0)" v-on:click="buy()">购买</a></div>
	<img alt="" src="{{ url('home/pc/images/products/19/paper.png') }}">
	
</section>
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
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				  <!-- Indicators -->
				  <!-- Wrapper for slides -->
					  <div class="carousel-inner" role="listbox">
					  <template v-for="i in Math.ceil(students.length/3)">
					  	<div class="item active"  v-if="i===0">
					  	  <template v-for="s in students"  v-if="$index>=3*i && $index<3*(i+1)">
						      <div class="child active" v-if="s.id===student_id" v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
						       <div class="child" v-else  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
					      </template>
					    </div>
					    <div class="item" v-else>
					        <template v-for="s in students"   v-if="$index>=3*i && $index<3*(i+1)">
						      <div class="child active" v-if="s.id===student_id"  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
						       <div class="child" v-else  v-on:click="selectStudent(s)">
						      	<img :src="s.avatar" class="avatar">
						      	<div  class="nickname">[[ s.nick_name ]]</div>
						      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
						      </div>
					      </template>
					  </div>
					  </template>
					  <!-- Controls -->
					  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-left.png') }}"">
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-right.png') }}"">
					  </a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" v-on:click="goPay()">确认</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<script type="text/javascript">
new Vue({
	 el:"#product8",
	 data: {
		product_id: 19,
		student_id: 0,
		auth: {!! auth('member')->check()?'true':'false' !!},
		newMember: {!! auth('member')->hasBoughtAnyProduct()?'true':'false' !!},
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!}
	},
	methods: {
		buy: function () {
			if (!this.auth) {
				appAlert({
					title: '提示',
					msg: '您尚未登录！',
					ok: {
						text: '登录',
						callback: function () {
							window.location.href="{{ url('login?intended='.request()->path()) }}"
						}
					}
				});
			}else if (this.newMember){
				appAlert({
					title: '提示',
					msg: '此产品只对新注册用户开放，您暂时没有权限购买此产品哦~'
				});
		    } else if (this.students.length=== 0) {
				appAlert({
					title: '提示',
					msg: '您名下没有孩子,请去添加孩子!',
					ok: {
						text: '添加孩子',
						callback: function () {
							window.location.href="{{ url('/member/children/create') }}"
						}
					}
				});
				return false;
			}else {
		    	this.student_id = 0;
			    $("#selectChildModal").modal('show');
			}
		},
		selectStudent: function (s) {
			this.student_id = s.id;
		},
		goPay: function () {
			$("#selectChildModal").modal('hide');
			if (!this.student_id) {
				appAlert({
					title: '提示',
					msg: '请选择孩子！',
					ok: {
						callback: function () {
							 $("#selectChildModal").modal('show');
						}
					}
				});
			} else {
		    	window.location.href="{{url('member/pay/confirm')}}"+"?product_id="+this.product_id+"&protocol=true&student_id="+this.student_id;
			}
		}
	}
})
</script>

<style>
section{
	background: #9971d6;
	margin-top:0px;
	text-align:center;
	padding:40px 0px 100px 0px;
	min-width:754px;
}
section img{
	margin: 0 auto;
}
section div{
	text-align:center;
	height:668px;
	width:100%;
	min-width:754px;
	padding-top: 565px;
	position:absolute;
}
section div a{
	color:#fff;
	background:#ff7800;
	padding: 5px  80px;
	font-weight:bold;
	font-size:22px;
	border-radius:5px;
}
section div a:hover{
	color:#fff;
	box-shadow: 0px 0px 2px 2px #dd6a03;
}
</style>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

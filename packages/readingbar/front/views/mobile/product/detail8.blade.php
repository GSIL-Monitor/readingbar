<!-- 继承整体布局 -->
@extends('front::mobile.common.main') @section('content')
<!-- 扩展内容-->
<section id="product8">
	<div class="content">
		<div><a href="javascript:void(0)" v-on:click="buy()">购买</a></div>
	    <img alt="" src="{{ url('home/wap/images/products/19/paper.png') }}">
	</div>
	<!-- 孩子选择 -->
	  	<div class="am-modal am-modal-confirm modal-buy" tabindex="-1" id="modal-SC">
		  <div class="am-modal-dialog" style="width: 96%;">
		    <div class="am-modal-hd">请选择孩子</div>
		    <div class="am-modal-bd">
		    	<template  v-for="s in students" >
			       <div class="child active" v-on:click="selectStudent(s)" v-if="s.id==this.student_id">
			          <div>
			          	<img alt="" :src="s.avatar" class="avatar">
			          </div>
			          <div>
			          	<div class="sc-nickname">[[ s.nick_name ]]</div>
			          	<div class="point">
			          		<img src="{{ url('home/pc/images/ioc-rdm.png') }}">
			          		[[ s.point ]]
			          	</div>
			          </div>
			       </div>
			       <div class="child "  v-on:click="selectStudent(s)" v-else>
			          <div>
			          	<img alt="" :src="s.avatar" class="avatar">
			          </div>
			          <div>
			          	<div class="sc-nickname">[[ s.nick_name ]]</div>
			          	<div class="point">
			          		<img src="{{ url('home/pc/images/ioc-rdm.png') }}">
			          		[[ s.point ]]
			          	</div>
			          </div>
			       </div>
		       </template>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
		      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
		    </div>
		  </div>
		</div>
	  <!-- 孩子选择 -->
</section>
<script type="text/javascript">
new Vue({
	 el:"#product8",
	 data: {
		product_id: 19,
		student_id: 0,
		auth: {!! auth('member')->check()?'true':'false' !!},
		newMember: {{ auth('member')->hasBoughtAnyProduct()?'true':'false' }},
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!}
	},
	methods: {
		buy: function () {
			if (!this.auth) {
				amazeAlert({
					title: '提示',
					msg: '您尚未登录！',
					onConfirm: function () {
						window.location.href="{{ url('login?intended='.request()->path()) }}"
					}
				});
			}else if (this.newMember){
				amazeAlert({
					title: '提示',
					msg: '此产品只对新注册用户开放，您暂时没有权限购买此产品哦~'
				});
		    } else if (this.students.length === 0) {
				amazeAlert({
					title: '提示',
					msg: '您名下没有孩子,请去添加孩子!',
					confirm: '添加孩子',
					onConfirm: function () {
						window.location.href="{{ url('/member/children/create') }}"
					}
				});
				return false;
			}else {
		    	this.student_id = 0;
		    	this.showModalSC();
			}
		},
		showModalSC: function () {
			var _this= this;
			$('#modal-SC').modal({
				closeViaDimmer:false,
		        onConfirm: function(options) {
		        	if(_this.student_id) {
						url="{{url('member/pay/confirm')}}";
						window.location.href=url+"?product_id="+_this.product_id+"&protocol=true&student_id="+_this.student_id;
			        }else {
			        	amazeAlert({
                            msg: '请选择产品服务',
                            onConfirm: function () {
                         	   _this.showModalSC()
                            }
						});
				    }
		        },
		        onCancel: function (){
					_this.cancel();
			    }
		   });
		},
		selectStudent: function (s) {
			this.student_id = s.id;
		}
	}
})
</script>
<style>
#product8{
	background:#9971d6;
	width:100%;
	height:100%;
	padding-top:20px;
}
#product8 .content{
	position:relative;
}
#product8 .content img{
	width:100%;
}
#product8 .content div{
	width:100%;
	height:100%;
	padding-top:15px;
	position:absolute;
	text-align:center;
	padding-top: 90%;
}
#product8 .content  a{
	color:#fff;
	background:#ff7800;
	padding: 5px  80px;
	font-weight:bold;
	font-size:22px;
	border-radius:5px;
}
#product8 .content  a:hover{
	color:#fff;
	box-shadow: 0px 0px 2px 2px #dd6a03;
}
</style>
<!-- /扩展内容-->
@endsection
<!-- //继承整体布局 -->

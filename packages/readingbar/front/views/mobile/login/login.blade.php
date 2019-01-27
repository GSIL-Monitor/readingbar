<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<section id="login-register-form">
  <div class="link-register">还没有注册 <a href="{{url('/register')}}" v-on:click="goRegister()">立即注册</a></div>
	<div class="tab">
		<a href="javascript:void(0)" v-on:click="changeMode('normal')"  :class="mode == 'normal'?'active':''">账号登录</a>
		<a href="javascript:void(0)" v-on:click="changeMode('messge')" :class="mode != 'normal'?'active':''">短信验证登录</a>
	</div>
	<div style="clear: both"></div>
	<template v-if="mode == 'normal'">
		<div class="control">
			<input v-model="account"  type="text"  placeholder="手机号或邮箱"/>
		</div>
		<div class="control">
			<input v-model="password"  type="password"  placeholder="密码"/>
		</div>
		<div class="remember"><input type="checkbox" v-model="remember"/>记住密码</div>
		<div class="btn-login">
			<a href="javascript:void(0)" v-if="isLogin">正在登录...</a>
			<a href="javascript:void(0)" v-else v-on:click="doLogin()">登录</a>
		</div>
		<div class="forgoten"><a href="{{url('/forgoten')}}">忘记密码</a></div>
	</template>
	<template v-else>
		<div class="control">
			<input  v-model="tel" placeholder="手机号"/>
		</div>
		<div class="control message">
			<input  v-model="code" placeholder="验证码"/>
			<a href="javascript:void(0)" v-if="codeSending">正在发送</a>
			<a href="javascript:void(0)" v-else v-on:click="doSendCode()">发送验证码</a>
		</div>
		<div class="remember" style="clear:both"></div>
		<div class="btn-login">
			<a href="javascript:void(0)" v-if="isLogin">正在登录...</a>
			<a href="javascript:void(0)" v-else v-on:click="doLogin()">登录</a>
		</div>
	</template>
</section>
<script>
	//发送登录验证消息
	new Vue({
			el:"section",
			data: {
					mode: 'normal',
					account: '',
					password: '',
					remember: null,
					tel: '',
					code: '',
					isLogin: false,
					codeSending: false
			  },
			  methods: {
				  goRegister:function(){
					this.$parent.setCurrentLRForm('v-register');
				  },
				  changeMode (m) {
					this.mode = m;
				  },
				  doLogin () {
					  var _this = this;
					  var url = '{{url("/api/loginByPassword")}}';
					  var data = {
							  		username: _this.account,
									password: _this.password
							 	}
					 if(_this.mode != 'normal') {
						 var url = '{{url("/api/loginByCode")}}';
						  var data = {
								  		username: _this.tel,
										code: _this.code
								 	}
					 }
					 $.ajax({
						url: url,
						data:data,
						dataType: 'json',
						type: 'post',
						beforeSend: function(){
							_this.isLogin = true;
						},
						success: function (json) {
							if (document.referrer) {
								window.location.href = document.referrer
							}else{
								window.location.href = "{{url('/member')}}"
							}
						},
						error: function(e) {
							if(e.status == 400) {
								amazeAlert({
									title: '提示',
									msg: e.responseJSON.message
								})
							}else{
								amazeAlert({
									title: '提示',
									msg: e.status + '错误'
								})
							}
						},
						complete: function(){
							_this.isLogin = false;
						},
					 })
				  },
				  doSendCode () {
					  var _this = this
					  $.ajax({ 
							url:"{{ url('api/message/sendLoginCode')}}",
							type:"GET",
							data:{username:this.tel},
							dataType:"json",
							beforeSend: function(){
								_this.codeSending = true;
							},
							success:function(json){
							},
							complete: function(){
									_this.codeSending = false;
							}
						});
				  }
			  }
		})
</script>
<style>
<!--
footer{display:none}
-->
</style>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

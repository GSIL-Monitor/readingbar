<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<section id="login-register-form">
	<div class="control" style="margin-top: 0px !important">
		<input  v-model="username" placeholder="手机号/邮箱"/>
	</div>
	<div class="error" v-if="errors.username">[[ errors.username[0] ]]</div>
	<div class="error" 	v-else-if="errors.cellphone">[[ errors.cellphone[0] ]]</div>
	<div class="error" 	v-else-if="errors.email">[[ errors.email[0] ]]</div>
	<div class="control image-code">
		<input  v-model="captcha" placeholder="图像验证"/>
		<img src="{{ url('captcha/register?'.rand(0001,9999)) }}" alt="图像验证码" id="captcha" v-on:click="refreshCaptcha()"/>
	</div>
	<div style="clear: both;"></div>
	<div class="error" v-if="errors.captcha">[[ errors.captcha[0] ]]</div>
	<div class="control message">
		<input  v-model="code" placeholder="验证码"/>
		<a href="javascript:void(0)" v-if="codeSending">正在发送</a>
		<template v-else>
			<a href="javascript:void(0)" v-if="captcha" v-on:click="doSendCode()">发送验证码</a>
			<a href="javascript:void(0)" v-else style="background-color:#f5f5f5;color:black;" >发送验证码</a>
		</template>
	</div>
	<div style="clear: both;"></div>
	<div class="error" v-if="errors.code">[[ errors.code[0] ]]</div>
	<div class="error" v-if="errors.verification_code_expire">[[ errors.verification_code_expire[0] ]]</div>
	
	<div class="control">
		<input  v-model="password" placeholder="登录密码" type="password"/>
	</div>
	<div class="error" v-if="errors.password">[[ errors.password[0] ]]</div>
	<div class="control">
		<input  v-model="password_confirmation" placeholder="重复密码" type="password"/>
	</div>
	<div class="control">
		<input  v-model="nickname" placeholder="昵称"/>
	</div>
	<div class="error" v-if="errors.nickname">[[ errors.nickname[0] ]]</div>
	<div class="btn-register">
		<a href="javascript:void(0)" v-if="isRegister">正在注册...</a>
		<a href="javascript:void(0)" v-else v-on:click="doRegister()">确认注册</a>
	</div>
	<div class="register-bottom">
		<a href="{{url('/login')}}" >直接登录</a>
		<a href="{{url('/forgoten')}}" >找回密码</a>
	</div>
</section>
<style>
<!--
footer{display:none}
-->
</style>
<script>
	//发送登录验证消息
	new Vue({
			el:"section",
			 data: function () {
				    return {
				        username: '',
				        captcha: '',
				        code: '',
				        password: '',
				        password_confirmation: '',
				        nickname: '',
				        errors: {},
				        isRegister: false,
						codeSending: false
				    }
				  },
				  methods: {
					  goLogin:function(){
						 this.$parent.setCurrentLRForm('v-login');
					  },
					  refreshCaptcha () {
						  $("#captcha").attr('src',"{{ url('captcha/register?') }}" + Date.parse(new Date()))
					  },
					  doSendCode () {
						  var _this = this
						  $.ajax({ 
								url:"{{ url('api/message/sendCodeForRegister') }}",
								type:"POST",
								data:{
									username:this.username,
									captcha:this.captcha
								},
								dataType:"json",
								beforeSend: function(){
									_this.errors = {};
									_this.codeSending = true;
								},
								success:function(json){
									if(json.status){
										amazeAlert({
											title:'提示',
											msg:json.success
										})
									}else{
										amazeAlert({
											title:'错误',
											msg:json.error
										})
									}
								},
								complete: function(){
										_this.codeSending = false;
								}
							});
					  },
					  doRegister () {
						  var _this = this
						  $.ajax({
							url: "{{url('api/register')}}",
							data:{
								username: _this.username,
						        captcha:_this.captcha,
						        code:_this.code,
						        password: _this.password,
						        password_confirmation: _this.password_confirmation,
						        nickname: _this.nickname
							},
							dataType: 'json',
							type: 'post',
							beforeSend: function(){
								_this.isRegister= true;
							},
							success: function (json) {
								_this.goLogin()
								amazeAlert({
										title: '提示',
										msg: json.message
									})
							},
							error: function(e) {
								if(e.status == 400) {
									_this.errors = e.responseJSON.errors;
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
								_this.isRegister = false;
							},
						 })
					  }
				  }
	})
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

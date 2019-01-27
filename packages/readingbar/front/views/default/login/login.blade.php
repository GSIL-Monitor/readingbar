<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
 
<!-- 扩展内容-->
<div class="content">
    <div class="container cont-about2">
	    <div class="col-md-6  pbt25"><img src="{{url('home/pc/images/banner/login.jpg')}}"></div>
	    <div class="col-md-6  pbt25 padl138 margintop59">
	    	<div class="cont-login-top"><h4>用户登录</h4><span>还没有账号<a href="{{ url('register')}}">立即注册</a></span></div>
	    	<div class="cont-login">
	    		<ul id="myTab" class="nav nav-tab-100">
					<li class="active"><a href="#home" data-toggle="tab">账号登录</a></li>
					<li><a href="#ios" data-toggle="tab">短信验证登录</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<!--from1-->
					<div class="tab-pane fade in active" id="home">
						<form id="loginForm1" method="post" class="form-horizontal bv-form form-dr" action="{{url('api/loginByPassword')}}" novalidate="novalidate">
						   <input type="hidden" value="{{ csrf_token() }}" name="_token">
						   {{ method_field('POST') }} 
						   <div class="form-group">
								<div class="form-group-fl">用户名:</div>
								<div class="form-group-fr"><input class="form-control" name="username" id="ds_email" type="text" value="" placeholder="手机或邮箱">
									@if(isset($error) && isset($login_type) && $login_type==0)
										<label style="color:red">{{ $error }}</label>
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">密码:</div>
								<div class="form-group-fr"><input class="form-control" name="password" id="ds_mm" type="password"></div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group" style="margin: 0;">
		                    	<div class="form-group-fl"></div>
								<div class="form-group-fr">
									<button  class="button-01 fl" >登录</button>
									<div class="ds-kep fr"><input type="checkbox" value="true" name="remember_me"><span>记住密码</span></div>
									
								</div>
								
							</div>
							 <div class="form-group"><a href="{{ url('forgoten') }}" class="ds-bjd fr">忘记密码？</a></div>
		                    <!--/-->
		                    <div class="form-group loginpd padt15">
								<h6 class="ds-dsf-titile">使用合作账号登录：</h6>
								<ul class="quicklogin_socical">
									<!--<li class="quicklogin_socical_weibo"><a href="#">微博账号登录</a></li>-->
									<li class="quicklogin_socical_wx"><a href="{{ url('oauth/WXPC') }}">微信账号登录</a></li>
									<li class="quicklogin_socical_qq"><a href="{{ url('oauth/QQ') }}">QQ账号登录</a></li>
									<div class="clear"></div>
								</ul>
		                    </div>
		                </form>
					</div>
					<!--from2-->
					<div class="tab-pane fade" id="ios">
						<form id="loginForm2" method="post" class="form-horizontal bv-form form-dr" action="{{url('api/loginByCode')}}" novalidate="novalidate">
						   <input type="hidden" value="{{ csrf_token() }}" name="_token">
						   {{ method_field('POST') }} 
						   <div class="form-group">
								<div class="form-group-fl">用户名：</div>
								<div class="form-group-fr"><input class="form-control" v-model="username" name='username' id="ds_phone" type="text" placeholder="手机或邮箱">
									@if(isset($error) && isset($login_type) && $login_type==1)
										<label style="color:red">{{ $error }}</label>
										<script type="text/javascript">
											$('#myTab a:last').tab('show');
										</script>
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">验证码:</div>
								<div class="form-group-fr">
									<input class="form-control" id="ds_message" type="text" name='code' style="width: 120px;float: left;">
									<button id="ds_message_pass" class="ds_message_pass" onclick="return false;" v-on:click="doSendLoginCode()"  v-if="sendStatus==0">
										[[ sendBtn ]]
									</button>
									<button id="ds_message_pass" class="ds_message_pass" onclick="return false;"  disabled v-else>
										[[ sendBtn ]]（[[ sendStatus ]]）
									</button>
								</div>
		                    </div>
		                    <!--/-->
<!--		                    <div class="form-group">-->
<!--                                <div class="form-group-fl">验证码:</div>-->
<!--								<div class="form-group-fr">验证码图片</div>-->
<!--		                    </div>-->
		                    <div class="form-group">
		                    	<div class="form-group-fl"></div>
								<div class="form-group-fr">
									<button  class="button-01 fl" >登录</button>
									<!--<a href="{{ url('forgoten') }}" class="ds-bjd">忘记密码？</a>-->
								</div>
							</div>
		                    <!--/-->
		                    
		                </form>
					</div>
				</div>
				<script>
				    $(function(){
							$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
								// 获取已激活的标签页的名称
								var activeTab = $(e.target).text(); 
								// 获取前一个激活的标签页的名称
								var previousTab = $(e.relatedTarget).text(); 
								$(".active-tab span").html(activeTab);
								$(".previous-tab span").html(previousTab);
							});
						});
					//发送登录验证消息
					new Vue({
							el:"#loginForm2",
							data:{
								username:null,
								sendStatus:0,
								sendBtn:'发送动态密码',
								Interval:null,
							},
							methods:{ 
									doSendLoginCode:function(){ 
										var _this=this;
										if(_this.sendStatus){
											return;
										}
										if(!_this.checkUsername()){
											alert('您输入的手机或邮箱格式错误！');
											return false;
										}
										_this.sendStatus=60;
										_this.sendBtn='重新发送';
										_this.Interval=setInterval(function(){
											if(_this.sendStatus>0){
												_this.sendStatus--;
											}else{
												window.clearInterval(_this.Interval);
											}
										},1000);
										$.ajax({ 
											url:"{{ url('api/message/sendLoginCode')}}",
											type:"GET",
											data:{username:this.username},
											dataType:"json",
											success:function(json){
													if(json.status){
														//alert(json.success);
													}else{
														_this.sendStatus=0;
														_this.sendBtn='发送动态密码';
														alert(json.error);
													}
												}
										});
									},
									checkUsername:function(){
										var c1=true;
										var c2=true;
										//校验手机格式
										if(!(/^1[3|4|5|7|8][0-9]\d{4,8}$/.test(this.username))){ 
											c1=false;
										}
										//校验邮箱格式
										var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
								        if(!myreg.test(this.username))
								        {
								        	c2=false;
								        }  
								        if(c1 || c2){
									        return true;
									     }else{
											return false;
										 }
									}
								}
						})

					@if(isset($success))
						alert("{{$success}}");
					@endif
				</script>
	    	</div>
	    	<!--/cont-login-->
	    </div>
	    <!--/col-md-6-->
    </div>
</div>
<!-- /content end -->



<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

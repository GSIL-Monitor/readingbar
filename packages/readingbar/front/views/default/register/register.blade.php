<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<link href="{{url('home/pc/js/video-js/video-js.css')}}" rel="stylesheet" type="text/css">
<script src="{{url('home/pc/js/video-js/video.js')}}"></script>
 <script>
    videojs.options.flash.swf = "video-js.swf";
  </script>
<!-- 扩展内容-->
	<div class="content">
    <div class="container cont-about2 ">
	    <div class="col-md-6  margintop70">
	    	<!--flash-->
             <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="568" height="305"
			      poster="{{url('home/pc/js/video-js/register_03.jpg')}}"
			      data-setup="{}">
			    <source src="{{url('home/pc/js/video-js/register.mp4')}}" type='video/mp4' />
			   	<track kind="captions" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
			    <track kind="subtitles" src="demo.captions.vtt" srclang="en" label="English"></track><!-- Tracks need an ending tag thanks to IE9 -->
			  </video>
            <!--/-->
	    </div>
		<script type="text/javascript">
		    var myPlayer = videojs('example_video_1');
		    videojs("example_video_1").ready(function(){
		        var myPlayer = this;
		        myPlayer.play();
		    });
		</script>
	    <div class="col-md-6  pbt25 mon82">
	    	<div class="cont-login-top"><h4>用户注册</h4><span>已有账号<a href="{{ url('login')}}">立即登录</a></span></div>
	    	<div class="cont-login">
	    		<!--from1-->
					<div class="tab-pane fade in active" id="home">
						<form id="registerForm" method="post" class="form-horizontal bv-form" action="{{url('api/register')}}" novalidate="novalidate">
							<input type="hidden" value="{{ csrf_token() }}" name="_token">
						   {{ method_field('POST') }}
						   <div class="form-group">
								<div class="form-group-fl">手机号/邮箱:</div>
								<div class="form-group-fr"><input class="form-contro2" v-model="username" name="username" id="ds_user" type="text" value="{{old('username')}}" placeholder="手机或邮箱">
									@if(isset($errors))
										@if($errors->has('username'))
											<label style="color:red">{{$errors->first('username')}}</label>
										@elseif($errors->has('cellphone'))
											<label style="color:red">{{$errors->first('cellphone')}}</label>
										@elseif($errors->has('email'))
											<label style="color:red">{{$errors->first('email')}}</label>
										@endif
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">图形验证:</div>
								<div class="form-group-fr">
									<div class="row col-md-12">
										<input class="form-contro3" id="ds_mm" type="text" name="captcha" value="{{old('captcha')}}" v-model="captcha">
										<img class="message_pass2" src="{{ url('captcha/register?'.rand(0001,9999)) }}" id="captcha"/>
										<script type="text/javascript">
											function refleshCaptcha() {
												$('#captcha').attr('src',"{{ url('captcha/register?') }}" + Date.parse(new Date()));
											}
											$('#captcha').click(function(){
												refleshCaptcha();
											})
											refleshCaptcha();
										</script>
									</div>
								</div>
		                    </div>
		                    <div class="form-group">
								<div class="form-group-fl">验证码:</div>
								<div class="form-group-fr">
									<div class="row col-md-12">
										<input class="form-contro3" id="ds_mm" type="text" name="code" value="{{old('code')}}">
										<button id="message_pass2" class="message_pass2" onclick="return false" v-on:click="doSendRegisterCode()">发送验证码</button>
									</div>
									@if(isset($errors))
											@if($errors->has('registercode'))
												<label style="clear:both;color:red">{{$errors->first('registercode')}}</label>
											@elseif($errors->has('verification_code_expire'))
												<label style="clear:both;color:red">{{$errors->first('verification_code_expire')}}</label>
											@elseif($errors->has('code'))
												<label style="clear:both;color:red">{{$errors->first('code')}}</label>
											@endif
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">登录密码:</div>
								<div class="form-group-fr">
									<input class="form-contro2" id="ds_psaa1" type="password" name="password" placeholder="8～20位字符,包含英文和数字">
									@if(isset($errors))
											@if($errors->has('password'))
												<label style="color:red">{{$errors->first('password')}}</label>
											@endif
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">确认密码:</div>
								<div class="form-group-fr">
									<input class="form-contro2" id="ds_psaa2" type="password" name="password_confirmation" placeholder="重复输入登录密码">
								</div>
		                    </div>
		                    <!--/-->
		                    <div class="form-group">
								<div class="form-group-fl">昵称:</div>
								<div class="form-group-fr">
									<input class="form-contro2" id="ds_name" type="text" name="nickname" value="{{old('nickname')}}">
									@if(isset($errors))
											@if($errors->has('nickname'))
												<label style="color:red">{{$errors->first('nickname')}}</label>
											@endif
									@endif
								</div>
		                    </div>
		                    <!--/-->
		                     <div class="form-group" style="margin-bottom: 0;">
								<div class="form-group-fl"></div>
								<div class="form-group-fr logAuto">
									<span  class="selected"><input name="license" value="agree" type="checkbox">同意并阅读<a href="{{ url('/protocol/register') }}">《蕊丁吧用户协议》</a></span>
									@if(isset($errors))
											@if($errors->has('license'))
												<label style="color:red">{{$errors->first('license')}}</label>
											@endif
									@endif
								</div>
		                    </div>
		                    <!--
		                    <div class="logAuto">
		                    	<span  class="selected"><input type="checkbox">同意并阅读<a href="#">蕊丁吧服务协议</a></span>
		                    </div>/-->
		                    <div class="form-group">
		                    	<div class="form-group-fl"></div>
								<div class="form-group-fr">
									<button href="javascript:void(0);" class="button-01" >确认注册</button>
								</div>
							</div>
		                    <!--/-->
		                    
		                </form>
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
				  //发送注册验证消息
					new Vue({
							el:"#registerForm",
							data:{
								username:null
							},
							methods:{ 
								 doSendRegisterCode:function(){ 
									 	// 判断用户名是否输入
									 	if (!this.username){
											appAlert({
												title:'提示',
												msg:'请输入用户名！'
											});
											return false;
										}
									 	// 判断图形验证码是否输入
									 	if (!this.captcha){
											appAlert({
												title:'提示',
												msg:'请输入图形验证码！'
											});
											return false;
										}
										$.ajax({ 
											url:"{{ url('api/message/sendCodeForRegister')}}",
											type:"POST",
											data:{
												username:this.username,
												captcha:this.captcha
											},
											dataType:"json",
											success:function(json){
													if(json.status){
														appAlert({
															title:'提示',
															msg:json.success
														})
													}else{
														appAlert({
															title:'错误',
															msg:json.error
														})
													}
												}
										});
									}
								}
						})
				</script>
	    	</div>
	    	<!--/cont-login-->
	    </div>
	    <!--/col-md-6-->
    </div>
</div>
<!-- /content end -->
<script src="{{url('home/pc/js/validate.js')}}"> </script>	
<script>
	function toValidate(){
		var val = new validate({
			/*rules里面是检验规则，
			*key为需要检验的input的id,
			*value为此input对应的检验规则
			*/
			rules:{
				card_name:"notEmpty",   
				ds_phone:"mobile",
				ds_email:"email",
				card_name3:"notEmpty",
				ds_mm:"password"
			},
			/*submitFun里面为检验成功后要执行的方法*/
			submitFun:function(){
				toSubmit();
			}
		})
	}
	function toSubmit(){
		alert("验证通过，提交啦 ！！！")
	}
	@if(isset($error))
		alert('{{$error}}');
	@endif
</script>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

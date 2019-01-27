<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<style>
#forgoten{
	margin:0 auto;
	width:600px;
	font-size:13px;
}
#forgoten .panel-heading{
	height:50px;
	line-height:30px;
	background-color:#4bd2bf;
	color:white;
}

#forgoten .panel-heading .col-md-6{
	padding:0px;
}
#forgoten .panel-body form{
	margin:15px 30px;
}
#forgoten .panel-body .form-myinput{
	background-color:#f3f3f3;
	height:50px;
	border:0;
	border-radius:5px;
	margin-bottom:30px;
	padding:13px;
}
#forgoten .panel-body .form-myinput input{
	border:0px;
	height:25px;
	background:#f3f3f3;
	border-left:1px solid #b4b4b4;
}
#forgoten .panel-body .form-myinput input:focus{
	border:0px;
	height:25px;
	background:white;
}
#forgoten .panel-body .form-myinput em{
	border:0px;
	height:25px;
	line-height:25px;
	font-size:25px;
	padding:0px;
	color:#b4b4b4;
}
#forgoten .btn{
	height:50px;
	border:0;
	
}
.btn-mysure,.btn-mysure:hover{
	background:#4bd2bf;
	color:white;
	line-height:30px;
	float:left;
}
.btn-mycancel,.btn-mycancel:hover{
	background:#f3f3f3;
	color:#b4b4b4;
	float:right;
	line-height:35px;
}
.btn-sendMessage,.btn-sendMessage:hover{
	background:#7f8080;
	color:white;
	float:right;
	line-height:35px;
}
</style>
<!-- 扩展内容-->
<div class="container ">
		<div class="content">
			<div id="forgoten" >
				<div class="panel panel-default">
				    <div class="panel-heading">
				        <font class="panel-title col-md-6 inline">
				           	 找回密码
				        </font>
				        <font class="panel-title col-md-6 inline text-right">
				                                     返回
				        </font>
				    </div>
				    <div class="panel-body">
			        	<form class="" role="form" method="post" action="{{url('api/forgoten')}}">
			        		<input type="hidden" name="_token" value="{{csrf_token()}}">
			        		@if($errors->has('username'))
			        			<label style="color:red">{{$errors->first('username')}}</label>
			        		@elseif($errors->has('username_format'))
			        			<label style="color:red">{{$errors->first('username_format')}}</label>
			        		@endif
			        		<div class="row">
			        			<div class="form-myinput">
			        				<em class="col-md-1">
										<i class="glyphicon glyphicon-user"></i>
									</em>
			        				<input placeholder="手机或邮箱" class="col-md-11" name="username">
			        			</div>
			        		</div>
			        		@if($errors->has('password'))
			        			<label style="color:red">{{$errors->first('password')}}</label>
			        		@endif
			        		<div class="row">
			        			<div class="form-myinput">
			        				<em class="col-md-1">
										<i class="glyphicon glyphicon-lock"></i>
									</em>
			        				<input placeholder="8～20位字符,包含英文和数字" type="password" class="col-md-11" name="password">
			        			</div>
			        		</div>
			        		<div class="row">
			        			<div class="form-myinput">
			        				<em class="col-md-1">
										<i class="glyphicon glyphicon-lock"></i>
									</em>
			        				<input placeholder="再次输入密码" type="password" class="col-md-11" name="password_confirmation">
			        			</div>
			        		</div>
			        		@if($errors->has('verification_message'))
			        			<label style="color:red">{{$errors->first('code')}}</label>
			        		@elseif($errors->has('verification_code_expire'))
			        			<label style="color:red">{{$errors->first('verification_code_expire')}}</label>
			        		@elseif($errors->has('verification_code'))
			        			<label style="color:red">{{$errors->first('verification_code')}}</label>
			        		@endif
			        		<div class="row">
			        			<div class="form-myinput col-md-6">
			        				<input placeholder="输入验证密码" style="border-left:0px;width:100%" name="code">
			        			</div>
			        			<a class="btn btn-sendMessage col-md-5" onclick="sendMessage();">发送验证码到邮箱</a>
			        		</div>
			        		<div class="row">
			        			<button class="btn btn-mysure col-md-5" >确定</button>
			        			<a onclick="history.back()" class="btn btn-mycancel col-md-5">取消</a>
			        		</div>
			        	</form>
				    </div>
				</div>
			</div>
		</div>
</div>	
<script type="text/javascript">
	function sendMessage(){
		$.ajax({
				url:"{{url('api/message/sendForgotenCode')}}",
				dataType:"json",
				data:{username:$("input[name=username]").val()},
				success:function(json){
					if(json.status){
						alert(json.success);
					}else{
						alert(json.error);
					}
				}
		});
		return false;
	}
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

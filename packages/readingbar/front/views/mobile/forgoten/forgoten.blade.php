<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
 
<!-- 扩展内容-->
<section>
	<div class="container pab15 margin20">
    	   	<form class="" role="form" method="post" action="{{url('api/forgoten')}}">
			    <input type="hidden" name="_token" value="{{csrf_token()}}">
			    	@if($errors->has('username'))
			    <label style="color:red">{{$errors->first('username')}}</label>
			    	@elseif($errors->has('username_format'))
			    <label style="color:red">{{$errors->first('username_format')}}</label>
			    @endif
			    <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-user am-icon-fw"></i></span>
					<input type="text" name="username" class="dl-user-anme am-form-field" placeholder="用户名或者邮箱">
				</div>
			    @if($errors->has('password'))
			        <label style="color:red">{{$errors->first('password')}}</label>
			    @endif
			    <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
					<input type="password" name="password" class="dl-user-anme am-form-field" placeholder="输入密码">
				</div>    		
                <!--/-->
                <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
					<input type="password" name="password_confirmation" class="dl-user-anme am-form-field" placeholder="再次输入密码">
				</div>    		
                <!--/-->
                @if($errors->has('verification_message'))
			        <label style="color:red">{{$errors->first('code')}}</label>
			        @elseif($errors->has('verification_code'))
			        <label style="color:red">{{$errors->first('code')}}</label>
			    @endif
                <div class="margintop15 am-input-group container">
					<div class="am-input-100 am-input-group fl" style="width: 60%;">
						<span class="dl-user am-input-group-label"><i class="am-icon-th am-icon-fw"></i></span>
						<input type="text" name="code" class="dl-user-anme am-form-field" placeholder="输入验证密码">
					</div>
					<div class="sd-hq fr btn-sendMessage" onclick="sendMessage();"><a href="javascript:void(0)" v-on:click="doSendLoginCode()">发送验证码</a></div>
				</div>
				<!--/-->
				<div class="margintop15 am-input-group container ">
                    <button class="btn-mysure am-btn ds-ij2 fl" >确定</button>
			        <a onclick="history.back()" class="btn-mycancel am-btn ds-ij3 fr">取消</a>
				</div>

			</form>
	</div>
</section>
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

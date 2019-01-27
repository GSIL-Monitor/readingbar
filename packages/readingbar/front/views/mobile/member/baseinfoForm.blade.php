<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<div id="baseinfo">
<section>
	<div class="am-container">
		<div class="user-heard-modify pab15 marginbottom25 update_member_avatar">
    		<div class="user-heard-photo">
    			<img src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/default_avatar.jpg') }}" class="am-img-thumbnail am-circle marg0_auto">
               </div>
    		<em class="user-heard-modify-upload user-tx-upload"><i class="am-icon-camera"></i></em>
    	</div>
    	<!--/user-heard-photo-->
        <div class="am-g margintop15 pad30">
			  <div class="am-u-sm-4 fontsize-16">昵称：</div>
			  <div class="am-u-sm-8 fontsize-16">[[member.nickname]]</div>
		</div>
		<!--/am-g-->
		<div class="am-g margintop15 pad30 post_relat">
			<div class="am-u-sm-4 fontsize-16">手机号码：</div>
			<div class="am-u-sm-8 fontsize-16">
			  	<span>[[member.cellphone]]</span>
			  	<a href="javascript:void(0);" class="cd-popup-trigger0 color4ad2be" v-on:click="showForm('phone')">修改</a>
			</div>
	    </div>
        <!--/am-g-->
		<div class="am-g margintop15 pad30">
			<div class="am-u-sm-4 fontsize-16">邮箱：</div>
			<div class="am-u-sm-8 fontsize-16">
				<span>[[member.email]]</span>
				<a href="javascript:void(0);" class="cd-popup-trigger1 color4ad2be" v-on:click="showForm('email')">修改</a>
			</div>
		</div>
		<!--/am-g-->
    </div>
	<!--/am-container-->
</section>
<!--手机验证-->
<div class="cd-popup">
    <div class="cd-popup-container">
        <div class="cd-buttons">
          <div class="cd-buttons-02">
           	    <!--/-->
		        <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-phone am-icon-fw"></i></span>
					<input type="text" name="cellphone" v-model="phone.cellphone" class="dl-user-anme am-form-field" placeholder="输入手机号">
				</div>
                <!--/-->
                <div class="margintop15 am-input-group container">
					<div class="am-input-100 am-input-group fl" style="width: 60%;">
						<span class="dl-user am-input-group-label"><i class="am-icon-th am-icon-fw"></i></span>
						<input type="text" name="code" v-model="phone.code" class="dl-user-anme am-form-field" placeholder="输入验证密码">
					</div>
					<div class="sd-hq fr btn-sendMessage" ><a href="javascript:void(0)" v-on:click="doSendCode()">发送验证码</a></div>
				</div>
                <!--/-->
                <div class="margintop15 am-input-group container ">
                    <button class="btn-mysure am-btn ds-ij2 fl cd-popup-close" v-on:click="submit()">确定</button>
			        <a  class="btn-mycancel am-btn ds-ij3 fr cd-popup-close" v-on:click="cancel()">取消</a>
				</div>
		        <!--/-->
		    </div>
          </div>
    </div>
</div>
<!--邮箱验证-->
<div class="cd-popup1">
    <div class="cd-popup-container1">
        <div class="cd-buttons">
          <div class="cd-buttons-02">
           	    <!--/-->
		        <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-envelope am-icon-fw"></i></span>
					<input type="text" name="email" v-model="email.email" class="dl-user-anme am-form-field" placeholder="输入邮箱号">
				</div>
                <!--/-->
                <div class="margintop15 am-input-group container">
					<div class="am-input-100 am-input-group fl" style="width: 60%;">
						<span class="dl-user am-input-group-label"><i class="am-icon-th am-icon-fw"></i></span>
						<input type="text" name="code" v-model="email.code" class="dl-user-anme am-form-field" placeholder="输入验证密码">
					</div>
					<div class="sd-hq fr btn-sendMessage" ><a href="javascript:void(0)" v-on:click="doSendCode()">发送验证码</a></div>
				</div>
                <!--/-->
                <div class="margintop15 am-input-group container ">
                    <button class="btn-mysure am-btn ds-ij2 fl cd-popup-close" v-on:click="submit()">确定</button>
			        <a class="btn-mycancel am-btn ds-ij3 fr cd-popup-close" v-on:click="cancel()">取消</a>
				</div>
		        <!--/-->
		    </div>
          </div>
    </div>
</div>
@include('front::mobile.member.memberAvatarForm')
</div>

<!-- /扩展内容 -->
<script type="text/javascript">
var baseinfo=new Vue({
	el:"#baseinfo",
	data:{
		ajaxUrls:{
			submitEmailUrl:"{{ url('api/member/modify/email') }}",
			sendEmailCode:"{{ url('api/message/sendEmailCode') }}",
			submitMobileUrl:"{{ url('api/member/modify/mobile') }}",
			sendMobileCode:"{{ url('api/message/sendMobileCode') }}",
		},
		form:null,
		member:{!! json_encode($member) !!},
		email:{
			email:null,
			code:null
		},
		phone:{
			cellphone:null,
			code:null
		},
		freeStar:{{session('freeStar')?'true':'false'}}
	},
	watch: {
		    form: function (val, oldVal) {
		      switch(val){
		      	case 'email':$('.cd-popup1').addClass('is-visible1');break;
		      	case 'phone':$('.cd-popup').addClass('is-visible');break;
		      	default:$('.cd-popup1').removeClass('is-visible1');
		      			$('.cd-popup').removeClass('is-visible');
		      }
		    }
	},
	methods:{
		showForm:function(form){
			switch(form){
				case 'null':this.form=null;break;
				default:this.form=form;
			}
		},
		//发送验证消息
		doSendCode:function(){ 
			var _this=this;
			switch(_this.form){
				case 'email':
					url=_this.ajaxUrls.sendEmailCode;
					info=_this.email;
				break;
				case 'phone':
					url=_this.ajaxUrls.sendMobileCode;
					info=_this.phone;
				break;
				default:return false;
			}
			$.ajax({
					url:url,
					data:info,
					type:"GET",
					dataType:"json",
					success:function(json){ 
						if(json.status){ 
							alert(json.success);
						}else{
							alert(json.error);
						}				
					}
			});
		},
		//提交修改
		submit:function(){ 
			var _this=this;
			switch(_this.form){
				case 'email':
					url=_this.ajaxUrls.submitEmailUrl;
					info=_this.email;
				break;
				case 'phone':
					url=_this.ajaxUrls.submitMobileUrl;
					info=_this.phone;
				break;
				default:return false;
			}
			$.ajax({
					url:url,
					data:info,
					type:"POST",
					dataType:"json",
					success:function(json){ 
						if(json.status){ 
							switch(_this.form){
								case 'email':_this.member.email=info.email;break;
								case 'phone':_this.member.cellphone=info.cellphone;break;
								default:alert(json.success);
							}
							_this.form=null;
							_this.goFreeStar();
						}else{
							alert(json.error);
						}				
					}
			});
		},
		cancel:function(){
			this.form=null;
		},
		//判断是否是免费评测流程
		goFreeStar:function(){
			if(this.freeStar){
				if(this.member.email!='' && this.member.cellphone!=''){
					window.location.href="{{url('member/freeStar')}}";
				}
			}
		}
	}
});
@if(isset($message))
	alert('{{ $message }}');
@endif
</script>



@endsection
<!-- //继承整体布局 -->

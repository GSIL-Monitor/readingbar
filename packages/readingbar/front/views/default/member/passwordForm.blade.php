<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')


<div class="container">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr100">
	               <ul class="nav nav-tabs">
						  <li role="presentation" class="active"><a href="#">修改密码</a></li>
					</ul>
					<div style="clear:both"></div>
					<div class="content mgl-40">
						<form id="baseinfoForm" class="mgl-40 mgb-20" action="http://account.cowinhome.com/index.php?route=pcuser/manage/baseinfo" method="post">
							<div class="form-tip2">
								*填写真实的资料方便大家更了解您，以下信息将显示在您的个人中心
							</div>
							<div class="row margin15_182_15">
								<div class="input-column col-md-3 color4bd2bf">新密码：</div>
								<div class="input-value col-md-9">
									<input v-model="info.password" placeholder="8～20位字符,包含英文和数字" type="text" class="form-control2">
								</div>
							</div>
							<div class="row margin15_182_15">
								<div class="input-column col-md-3 color4bd2bf">重复密码：</div>
								<div class="input-value col-md-9 inline">
									<input placeholder="再次输入密码" v-model="info.password_confirmation" type="text" class="form-control2">
								</div>
							</div>
							<div class="row margin15_182_15">
								<div class="input-column col-md-3"></div>
								<div class="col-md-9">
									<button v-on:click="submit()" onclick="return false;" class="button-01">确认修改</button>
								</div>
							</div>
						</form>
						<script type="text/javascript">
							new Vue({
								el:"#baseinfoForm",
								data:{
									ajaxUrls:{
										submitUrl:"{{ url('api/member/modify/password') }}",
									},
									info:{
										password:null,
										password_confirmation:null
									}
								},
								methods:{
									submit:function(){ 
										var _this=this;
										$.ajax({
												url:_this.ajaxUrls.submitUrl,
												data:_this.info,
												type:"POST",
												dataType:"json",
												success:function(json){ 
													if(json.status){ 
														alert(json.success);
														window.location.href="{{url('member')}}";
													}else{
														alert(json.error);
													}				
												}
										});
									}
								}
							});
						</script>
					</div>
				  </div>	
				</div>
				<!--/row end-->
			</div>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

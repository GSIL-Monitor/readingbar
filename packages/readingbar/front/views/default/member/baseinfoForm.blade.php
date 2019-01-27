<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->

<div class="container">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr">
	             <ul class="nav nav-tabs">
						  <li role="presentation" class="active"><a href="#">完善信息</a></li>
					</ul>
					<div style="clear:both"></div>
					<div class="content mgl-40">
						<form id="baseinfoForm" class="mgl-40 mgb-20" action="http://account.cowinhome.com/index.php?route=pcuser/manage/baseinfo" method="post">
							<div class="form-tip">
								<em>*</em>填写真实的资料方便大家更了解您，以下信息将显示在您的个人资料页
							</div>
							<div class="row">
								<div class="input-column col-md-3">昵称：</div>
								<div class="input-value col-md-9">
									<input v-model="baseinfo.nickname" type="text">
								</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3">地址：</div>
								<div class="input-value col-md-9">
									<input v-model="baseinfo.address" type="text">
								</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3"></div>
								<div class="col-md-9">
									<button v-on:click="submit()" onclick="return false;" class="btn-save fz-14">保存</button>
								</div>
							</div>
						</form>
						<script type="text/javascript">
							new Vue({
								el:"#baseinfoForm",
								data:{
									ajaxurl:"{{ url('api/member/modify/baseinfo') }}",
									baseinfo:{
										nickname:"{{auth('member')->member->nickname}}",
										address:"{{auth('member')->member->address}}"
									}
								},
								methods:{
									submit:function(){ 
										var _this=this;
										$.ajax({
												url:_this.ajaxurl,
												data:_this.baseinfo,
												type:"POST",
												dataType:"json",
												success:function(json){ 
													if(json.status){ 
														alert(json.success);
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

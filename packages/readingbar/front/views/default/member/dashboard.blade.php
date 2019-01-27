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
	  <div class="col-md-10 home-column-fr100">
	             <ul class="nav nav-tabs">
						  <li role="presentation" class="active"><a href="#">基础信息</a></li>
					</ul>
					<div style="clear:both"></div>
					<div class="content mgl-40">
						<form class="mgl-40 mgb-20" action="http://account.cowinhome.com/index.php?route=pcuser/manage/baseinfo" method="post">
							<div class="form-tip">
								<em>*</em>填写真实的资料方便大家更了解你，以下信息将显示在您的个人资料页
							</div>
							<div class="row row1">
								<div class="input-column col-md-3">当前头像：</div>
								<div class="input-value col-md-9">
									<img width="64px" height="64px" src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/default_avatar.jpg') }}">
<!-- 									<span>修改</span> -->
								</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3">昵称：</div>
								<div class="input-value col-md-9">
									{{ auth('member')->member->nickname }}
								</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3">邮箱：</div>
								<div class="input-value col-md-9">
									{{ auth('member')->member->email }}
								</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3">手机号码：</div>
								<div class="input-value col-md-9">{{ auth('member')->member->cellphone }}</div>
							</div>
							<div class="row">
								<div class="input-column col-md-3">地址：</div>
								<div class="input-value col-md-9">
									{{ auth('member')->member->address }}
								</div>
							</div>
						</form>
					</div>
				  </div>	
				</div>
				<!--/row end-->
			</div>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

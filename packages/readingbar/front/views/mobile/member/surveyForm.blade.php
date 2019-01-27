<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 包含会员菜单@include('front::default.member.memberMenu')
基础信息
完善信息
修改密码
设置邮箱
设置手机
设置安全问答
孩子信息
 -->
	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->

<div class="container">
	<div class="row">
	    <div class="col-md-9 home-column-fl" style="height: 754px;">@include('front::default.member.memberMenu')</div><!--/ home-column-fl end-->
	    <div class="col-md-3 home-column-fr">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="javascript:volid(0);">孩子基础问卷调查</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content">
				<form class="mgl-40 mgb-20" action="" method="post">
					<div class="home-questionnaire-titile">
						<i>1</i>
						<span>单选择题</span>
					</div>
					<div class="home-questionnaire">
						<h5 class="questionnair-heard">问题一:孩子的年龄 </h5>
						<div class="q-choice-piccheck">
				            <div class="q_choice_in"> 
					             <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
					            <label class="">a.三岁以下</label>
				            </div>
				        </div> 
				        <!--/q-choice-piccheck-->
				        <div class="q-choice-piccheck">
				            <div class="q_choice_in"> 
					            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
					            <label class="">b.三岁以下</label>
				            </div>
				        </div> 
				        <!--/q-choice-piccheck-->
				        <div class="q-choice-piccheck">
				            <div class="q_choice_in"> 
					            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
					            <label class="">c.三岁以下</label>
				            </div>
				        </div> 
				        <!--/q-choice-piccheck-->
				        <div class="q-choice-piccheck">
				            <div class="q_choice_in"> 
					            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
					            <label class="">d.三岁以下</label>
				            </div>
				        </div> 
				        <!--/q-choice-piccheck-->
				        
					</div>
					<a href="" class="home-questionnaire-referre">下一题</a>	
				</form>
			</div>
		</div>
		<!--/col-md-3-->	
	</div>
	<!--/row end-->
</div>

<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

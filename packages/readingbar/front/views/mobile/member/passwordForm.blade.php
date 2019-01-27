<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')
@section('content')
<!-- 扩展内容-->
<section>
	<div class="container pab15">
    	   <form id="baseinfoForm" class="pad30" action="http://account.cowinhome.com/index.php?route=pcuser/manage/baseinfo" method="post">
	
			    <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
					<input v-model="info.password" type="password"  class="dl-user-anme am-form-field" placeholder="输入密码">
				</div>    		
                <!--/-->
                <div class="am-input-100 am-input-group margintop15">
					<span class="dl-user am-input-group-label"><i class="am-icon-lock am-icon-fw"></i></span>
					<input v-model="info.password_confirmation" type="password"  class="dl-user-anme am-form-field" placeholder="再次输入密码">
				</div>    		
                <!--/-->
               <div class="margintop15 am-input-group container ">
                    <button v-on:click="submit()" onclick="return false;"  class="btn-mysure am-btn ds-ij2 fl" >确定</button>
			        <a onclick="history.back()" class="btn-mycancel am-btn ds-ij3 fr">取消</a>
				</div>

			</form>
	</div>


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
													}else{
														alert(json.error);
													}				
												}
										});
									}
								}
							});
						</script>
</section>	
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

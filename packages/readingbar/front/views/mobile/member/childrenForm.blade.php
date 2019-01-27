<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	[class*=am-u-] {padding-left: 0.5rem;padding-right: 0.5rem;float: left;position: relative;}
	.am-form-field{ background-color: #fff !important;}
</style>
<!-- 扩展内容-->
<section>
	<div class="pab0_0 am-container" id="childForm">
		<div class="user-heard-modify2 pab15">
    		<div class="user-heard-photo">
    			<img src="{{ auth('member')->member->avatar?url(auth('member')->member->avatar):url('files/avatar/default_avatar.jpg') }}" class="am-img-thumbnail am-circle marg0_auto">
               </div>
    		<em class="user-heard-modify-upload user-tx-upload"><i class="am-icon-camera"></i></em>
    	</div>
    	<!--/user-heard-photo-->
    	<form action=""  method="POST" enctype="multipart/form-data" class="am-form am-form-horizontal"> 
	      	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
	      	<input v-model="student.id" type="hidden" name="id"/>
			<input v-model="student.avatar" type="hidden" name="avatar"/>
			<input v-model="cropper.width" type="hidden" name="avatar_width"/>
			<input v-model="cropper.height" type="hidden" name="avatar_height"/>
			<input v-model="cropper.x" type="hidden" name="avatar_x"/>
			<input v-model="cropper.y" type="hidden" name="avatar_y"/>
			@if(session('freeStar') || old('freeStar'))
				<!-- 免费评测标识 -->
				<input type="hidden" name="freeStar" value="true"/>
				<!-- /免费评测标识 -->
			@endif
			<!--/am-form-group--> 
            <div class="am-form-group am-form-group-sm pad0_15">
			    <label class="am-u-sm-2 am-form-label">昵称：</label>
			    <div class="am-u-sm-8">
			        <input class="am-form-field" v-model="student.nick_name" type="text" name="nick_name">
				    @if($errors->has('nick_name'))
					  <font class="ds-bjd">{{$errors->first('nick_name')}}</font>
				    @endif
			    </div>
			    <div class="am-u-sm-2 ds-bjd">*必填</div>
			</div> 
			<!--/am-form-group-->
			<div class="am-form-group am-form-group-sm pad0_15">
			    <label  class="am-u-sm-2 am-form-label">生日：</label>
			    <div class="am-u-sm-8">
			        <input id="dob" v-model="student.dob" readonly type="text" name="dob" class="am-form-field"/>
				    @if($errors->has('dob'))
						<font class="ds-bjd">	{{$errors->first('dob')}}</font>
					@endif
			    </div>
			    <div class="am-u-sm-2 ds-bjd">*必填</div>
			</div> 
			<!--/am-form-group-->
			<div class="am-form-group am-form-select pad0_15">
			    <label class="am-u-sm-2 am-form-label">性别：</label>
			    <div class="am-u-sm-8">
			        <select class=" am-input-sm" v-model="student.sex"  name='sex'>
				      <option value="0">女</option>
					  <option value="1">男</option>
				    </select>
				    @if($errors->has('sex'))
						<font class="ds-bjd">{{$errors->first('sex')}}</font>
					@endif
			    </div>
			    <div class="am-u-sm-2 ds-bjd">*必填</div>
			</div> 
			
			<!--/am-form-group-->
			<div class="am-form-group am-form-select pad0_15">
			    <label class="am-u-sm-2 am-form-label">年级：</label>
			    <div class="am-u-sm-8">
			        <select class=" am-input-sm" v-model="student.grade" name="grade">
				     					 <option value="k">K年级</option>
										<option value="1">一年级</option>
										<option value="2">二年级</option>
										<option value="3">三年级</option>
										<option value="4">四年级</option>
										<option value="5">五年级</option>
										<option value="6">六年级</option>
										<option value="7">初一</option>
										<option value="8">初二</option>
										<option value="9">初三</option>
										<option value="10">高一</option>
										<option value="11">高二</option>
										<option value="12">高三</option>
				    </select>
				    @if($errors->has('grade'))
						<font class="ds-bjd">	{{$errors->first('grade')}}</font>
					@endif
			    </div>
			    <div class="am-u-sm-2 ds-bjd">
			    		*必填
			    </div>
			</div> 
			<div class="am-form-group am-form-group-sm pad0_15">
			    	<span style='color:red''>请选择2018年9月开学后的年级！！</span>
			 </div>
			<!--/am-form-group-->
			<div class="am-form-group am-form-group-sm pad0_15">
			    <label  class="am-u-sm-2 am-form-label">阅读偏好：</label>
			    <div class="am-u-sm-8">
			        <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox1" value="动作冒险">动作冒险
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox2" value="童话">童话
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox3" value="历史传记">历史传记
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox4" value="自然科学">自然科学
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox5" value="百科">百科
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox6" value="动物">动物
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox7" value="体育">体育
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox8" value="旅行">旅行
                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox9" value="诗歌">诗歌
                    <br> 
                    @if($errors->has('favorite'))
						<font class="ds-bjd">{{$errors->first('favorite')}}</font>
					@endif	
			    </div>
			    <div class="am-u-sm-2 ds-bjd">*必填</div>
			</div> 
			<!--/am-form-group-->
			<div class="am-form-group am-form-group-sm pad0_15">
			    <label  class="am-u-sm-2 am-form-label">书籍邮寄地址：</label>
			    <div class="am-u-sm-8">
			        <div data-toggle="distpicker" class="mon">
						<select  name="province" :data-province="student.province" class="margintop10 am-form-field"></select>
						<select  name="city" :data-city="student.city" class=" margintop10 am-form-field"></select>
						<select  name="area" :data-district="student.area" class=" margintop10  am-form-field"></select>
						<input v-model="student.address" type="text" name="address" class="margintop10 am-form-field">
				   </div>
			    </div>
			    <div class="am-u-sm-2 ds-bjd"></div>
			</div> 
			<!--/am-form-group-->   
			<div class="am-g pad30 ds-bjd" style="text-align: center;">*请填写准确信息的地址，便于快速配送和上门取书服务</div>
			<div class="am-g add-childer-box2">
				<a v-on:click="doAction()" class="btn-save2">保存</a>
			</div>


	   </form>
    </div>
	<!--/am-container-->
</section>
<!-- /扩展内容 -->
<script src="{{url('home/pc/js/distpicker.data.js')}}"></script>
<script src="{{url('home/pc/js/distpicker.js')}}"></script>
<script src="{{url('home/pc/js/main.js')}}"></script>				
<script type="text/javascript">
				var childForm=new Vue({
						el:"#childForm",
						data:{
							student:{!! $student?json_encode($student):'null' !!},
							cropper:null,
							listdata:null,
							editAvatar:false,
							favorite:{!! isset($student['favorite'])?json_encode($student['favorite']):'[]' !!},
						},
						methods:{
							doAction:function(){
								if(this.student!=null && this.student.id){
									this.doEdit();
								}else{
									this.doCreate();
								}
							},
							doEdit:function(){
								$("#childForm form").attr('action',"{{url('api/member/children/modifyChild')}}").submit();
							},
							doCreate:function(){
								$("#childForm form").attr('action',"{{url('api/member/children/newChild')}}").submit();
							},
							//编辑头像
							doEditAvatar:function(){
								$("#inputImage").click();
							},
							//显示头像编辑框
							showAvatarForm:function(){
								$("#avatarForm").show();
							}
						}
				});
				//图裁剪设置
				$(document).ready(function(){
		            var $image = $(".image-crop > img");
		            $($image).cropper({
		                aspectRatio: 1,
		                preview: ".img-preview",
		                done: function(data) {
		                	childForm.cropper=data;
		                }
		            });
		            var $inputImage = $("#inputImage");
		            if (window.FileReader) {
		                $inputImage.change(function() {
		                    var fileReader = new FileReader(),
		                            files = this.files,
		                            file;

		                    if (!files.length) {
		                        return;
		                    }

		                    file = files[0];

		                    if (/^image\/\w+$/.test(file.type)) {
		                        fileReader.readAsDataURL(file);
		                        fileReader.onload = function () {
		                            //$inputImage.val("");
		                            $image.cropper("reset", true).cropper("replace", this.result);
		                        };
		                    } else {
		                        showMessage("Please choose an image file.");
		                    }
		                });
					}
				});	
				</script>
				<!--/row end-->
			</div>
	<script type="text/javascript">
		$('#dob').datepicker({
	        startView: 1,
	        todayBtn: "linked",
	        keyboardNavigation: false,
	        forceParse: false,
	        autoclose: true,
	        language:"cn",
	        format: "yyyy-mm-dd"
	    });
	</script>
<!-- //继承整体布局 -->
@endsection
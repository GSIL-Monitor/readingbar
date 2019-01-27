<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>

<link href="{{url('assets/css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{url('assets/js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>
	
<div class="container">
	<div class="row padt9">
	   <div class="col-md-2 home-column-fl" >
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr100">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">{{$head_title}}</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content mgl-40 margintop59" id="childForm">
				<div class="col-md-2">
				   <!--这里-->
        			<div class="user-tx">
        				<div  style="width:160px;height:160px;overflow:hidden" v-on:click="doEditAvatar()" class="img-preview img-preview-sm"></div>
                    	<em class="user-tx-hover"></em>
                    </div>
                    <button class="user-tx-upload margft20 button-01" v-on:click="doEditAvatar()">上传头像</button>
                </div>
        		<div class="col-md-10 marginbt15">
        		    <form action=""  method="POST" enctype="multipart/form-data"> 
                           	<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                           
                            <input v-model="student.id" type="hidden" name="id"/>
							<input v-model="student.avatar" type="hidden" name="avatar"/>
							<input v-model="cropper.width" type="hidden" name="avatar_width"/>
							<input v-model="cropper.height" type="hidden" name="avatar_height"/>
							<input v-model="cropper.x" type="hidden" name="avatar_x"/>
							<input v-model="cropper.y" type="hidden" name="avatar_y"/>
							
							<input type="file" style="display:none" id="inputImage" v-on:change="showAvatarForm()" name="avatarFile"/>
							
							@if(session('freeStar') || old('freeStar'))
								<!-- 免费评测标识 -->
								<input type="hidden" name="freeStar" value="true"/>
								<!-- /免费评测标识 -->
							@endif
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">昵称：</div>
								<div class="input-value col-md-9">
									<input v-model="student.nick_name" type="text" name="nick_name" class="form-control fl" />
									@if($errors->has('nick_name'))
										<b class="fl">*{{$errors->first('nick_name')}}</b>
									@else
										<b class="fl">*必填</b>
									@endif
								</div>					
							</div>
							
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">生日：</div>
								<div class="input-value col-md-9">
									<input id="dob" v-model="student.dob" readonly type="text" name="dob" class="form-control fl" />
									@if($errors->has('dob'))
										<b class="fl">*{{$errors->first('dob')}}</b>
									@else
										<b class="fl">*必填</b>
									@endif
								</div>					
							</div>
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">性别：</div>
								<div class="input-value col-md-9">
									<select v-model="student.sex" class="form-control fl"  name='sex'>
										<option value="0">女</option>
										<option value="1">男</option>
									</select>
									@if($errors->has('sex'))
										<b class="fl">*{{$errors->first('sex')}}</b>
									@else
										<b class="fl">*必填</b>
									@endif
								</div>					
							</div>
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">年级：</div>
								<div class="input-value col-md-9">
									<select  v-model="student.grade" name="grade" class="form-control fl" />
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
										<b class="fl">*{{$errors->first('grade')}}</b>
									@else
										<b class="fl">*必填</b>
									@endif
									<br>
								</div>					
								
							</div>
							<div class="row marginbt15" >
								<div class="input-column col-md-3 color4bd2bf"></div>
								<div class="input-value col-md-9" style='color:red''>
									请选择2018年9月开学后的年级！！
								</div>
							</div>
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">阅读偏好：</div>
								<div class="padt9 col-md-9">
                                	<input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox1" value="动作冒险">动作冒险
                                	<input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox2" value="童话">童话
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox3" value="历史传记">历史传记
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox4" value="自然科学">自然科学
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox5" value="百科">百科
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox6" value="动物">动物
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox7" value="体育">体育
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox8" value="旅行">旅行
                                    <input  v-model="favorite" type="checkbox" name="favorite[]" id="inlineCheckbox9" value="诗歌">诗歌
                                    
								</div>		
								<br>
								<div class="input-value col-md-10">
								 @if($errors->has('favorite'))
									<b class="fl">*{{$errors->first('favorite')}}</b>
								 @else
									<b class="fl">*必填</b>
								 @endif		
								 </div>	
							</div>
							<!--/row-->
							<div class="row marginbt15" v-if="form!='phone'">
								<div class="input-column col-md-3 color4bd2bf">书籍邮寄地址：</div>
								<div class="input-value col-md-9">
								    <div data-toggle="distpicker" class="mon">
									  <select  name="province" :data-province="student.province" class="fl form-control"></select>
									  <select  name="city" :data-city="student.city" class="fl form-control margft10"></select>
									  <select  name="area" :data-district="student.area" class="fl form-control margintop15"></select>
									</div>
									
									<input v-model="student.address" type="text" name="address" class="form-control" style="width: 300px;margin-top: 15px;" />
									
									<br><br>
									<b>*请填写准确信息的地址，便于快速配送和上门取书服务</b>
								</div>					
							</div>
							<!--/row-->
							<div class="row marginbt15">
								<div class="input-column col-md-2 color4bd2bf"></div>
								<div class="input-value col-md-10">
									<a v-on:click="doAction()" class="button-01">保存</a>
								</div>					
							</div>
							
						    <div class="col-md-8 inline" style="display: none">
								<div class="image-crop">
				                     <img src="{{ (isset($student['avatar']) && $student['avatar'])?url($student['avatar']):url('files/avatar/default_avatar.jpg')}} ">
				                </div>
							</div>
						</form>        			
        		</div>
        		<!--/col-md-10-->	
			</div>
			<!--/content-->			
		</div>
	</div>	
</div>
				
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
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

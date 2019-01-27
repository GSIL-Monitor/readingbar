<!-- 会员头像修改  -->
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>

  <div class="modal inmodal" id="MemberAvatarFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <form action="" method="POST" id="MemberAvatarForm" enctype="multipart/form-data" target="memberAvatarIframe">
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">图片裁剪</h4> 
     </div> 
     <div class="modal-body"> 
     	<div style="display:none">
     		<input name="_token" type="text" vaule="{{ csrf_token() }}">
			<input name="member_avatar" id="member_avatar" type="file">
			<input name="member_avatar_x" id="member_avatar_x" type="hidden">
			<input name="member_avatar_y" id="member_avatar_y" type="hidden">
			<input name="member_avatar_width" id="member_avatar_w" type="hidden">
			<input name="member_avatar_height" id="member_avatar_h" type="hidden">
     	</div>
	     <div class="row" style="position: relative;margin:0 auto;width:400px;">
		     <div style="position: relative">
		    	 <div class="col-md-8 inline" style="width:400px;height:400px">
					<div class="image-crop">
						<img src="">
					</div>
				 </div>
			 </div>
		 </div>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" >取消</button> 
      <button type="submit" class="btn btn-primary">确认</button> 
     </div> 
    </div> 
   </div> 
   </form>
  </div>
<script type="text/javascript">
		//图像裁剪按钮
		$(document).on('click','.update_member_avatar',function(){
			$("#member_avatar").change(function(){
				$("#MemberAvatarFormModal").modal({backdrop: 'static', keyboard: false});
			});
			$("#member_avatar").click();
		});
		//图像回调查看
		$('#MemberAvatarForm').submit(function(){
			 var formData = new FormData($(this)[0]);
		     $.ajax({  
		          url: '{{url("api/member/modify/avatar")}}',  
		          type: 'POST',  
		          data: formData,  
		          async: false,  
		          cache: false,  
		          dataType:'json',
		          contentType: false,  
		          processData: false,  
		          success: function (json) {  
		             if(json.status){
		            	 location.reload()
			         }else{
			        	 alert(json.error);
				     }
		          },  
		          error: function (returndata) {  
		              alert(returndata);
		          }  
		     });  
		     $("#MemberAvatarFormModal").modal('hide');
		     return false;
		});
		//图裁剪设置
		$(document).ready(function(){
            var $image = $(".image-crop > img");
            $($image).cropper({
                aspectRatio: 1,
                preview: ".img-preview",
                done: function(data) {
                	$("#member_avatar_x").val(data.x);
                	$("#member_avatar_y").val(data.y);
                	$("#member_avatar_w").val(data.width);
                	$("#member_avatar_h").val(data.height);
                }
            });
            var $inputImage = $("#member_avatar");
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
                        showMessage("请选择一张图片.");
                    }
                });
			}
		});	
</script>
<!-- /会员头像修改  -->
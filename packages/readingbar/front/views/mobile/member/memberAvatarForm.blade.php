<!-- 会员头像修改  -->
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>
<style>
#MemberAvatarFormModal {
    background-color: rgba(0, 0, 0, 0.5);
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    transition: opacity 0.3s ease 0s, visibility 0s ease 0.3s;
    width: 100%;
    z-index: 9999;
}
#MemberAvatarFormModal .cd-popup-container {
    backface-visibility: hidden;
    background: #fff none repeat scroll 0 0;
    border-radius: 0.4rem;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    margin: 0 auto;
    position: relative;
    text-align: center;
    top: 10%;
    transform: translateY(-60px);
    transition-duration: 0.3s;
    transition-property: transform;
    width: 90%;
}
#MemberAvatarFormModal .cropper-container{
	left:auto !important;
	margin:0 auto;
}
</style>
<div id="MemberAvatarFormModal"style="display:none">
    <div class="cd-popup-container">
    <form action="" method="POST" id="MemberAvatarForm" enctype="multipart/form-data" target="memberAvatarIframe">
        <div class="cd-buttons">
          <div class="cd-buttons-02">
                <div class="margintop15 am-input-group container">
					
					 <h4 class="modal-title">图片裁剪</h4> 
			     	<div style="display:none">
			     		<input name="_token" type="text" vaule="{{ csrf_token() }}">
						<input name="member_avatar" id="member_avatar" type="file">
						<input name="member_avatar_x" id="member_avatar_x" type="hidden">
						<input name="member_avatar_y" id="member_avatar_y" type="hidden">
						<input name="member_avatar_width" id="member_avatar_w" type="hidden">
						<input name="member_avatar_height" id="member_avatar_h" type="hidden">
			     	</div>
				     <div style="position: relative;margin:0 auto;width:100%;">
					     <div style="position: relative">
					    	 <div class="col-md-8 inline" style="width:100%;height:200px">
								<div class="image-crop" style="width:100%;">
									<img src="">
								</div>
							 </div>
						 </div>
					 </div>
					   
				</div>
                <!--/-->
                <div class="margintop15 am-input-group container ">
                    <button class="btn-mysure am-btn ds-ij2 fl cd-popup-close">确定</button>
			        <a class="btn-mycancel am-btn ds-ij3 fr cd-popup-close">取消</a>
				</div>
		        <!--/-->
		    </div>
          </div>
          </form>
    </div>
</div>
<script type="text/javascript">
		//图像裁剪按钮
		$(document).on('click','.update_member_avatar',function(){
			$("#member_avatar").change(function(){
				$('#MemberAvatarFormModal').show();
			});
			$("#member_avatar").click();
		});
		//取消图像裁剪
		$(document).on('click','#MemberAvatarFormModal .btn-mycancel',function(){
			$('#MemberAvatarFormModal').hide();
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
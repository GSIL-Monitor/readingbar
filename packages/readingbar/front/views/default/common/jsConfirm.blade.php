<!-- confirm -->
  <div class="modal inmodal" id="appConfirmModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <h4 class="modal-title" id="title">确认信息</h4> 
     </div> 
     <div class="modal-body text-center" id="msg"> 
    	请输入消息内容
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" id="appConfirmNo">取消</button> 
      <button type="button" class="btn btn-default" id="appConfirmOk">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>
<script>
	function appConfirm(options){
		var obj={
				title:'确认信息',
				msg:'请输入消息内容',
				ok:{
						text:'确定',
						callback:null
					},
				no:{
						text:'取消',
						callback:null
				}
			};
		if(options.ok){
			if(options.ok.text){
				obj.ok.text=options.ok.text;
			}
			if(options.ok.callback){
				obj.ok.callback=options.ok.callback;
			}else{
				obj.no.callback=null;
			}
		}
		if(options.no){
			if(options.no.text){
				obj.no.text=options.no.text;
			}
			if(options.no.callback){
				obj.no.callback=options.no.callback;
			}else{
				obj.no.callback=null;
			}
		}
		if(options.title){
			obj.title=options.title;
		}
		if(options.msg){
			obj.msg=options.msg;
		}

		$("#appConfirmModal #appConfirmOk").unbind("click").text(obj.ok.text).click(function(){
			$("#appConfirmModal").modal('hide');
			if(obj.ok.callback){
				obj.ok.callback();
			}
			
		});
		$("#appConfirmModal #appConfirmNo").unbind("click").text(obj.no.text).click(function(){
			$("#appConfirmModal").modal('hide');
			if(obj.no.callback){
				obj.no.callback();
			}
		});
		$("#appConfirmModal #title").html(obj.title);
		$("#appConfirmModal #msg").html(obj.msg);
		
		$("#appConfirmModal").modal('show');
	};
</script>
<!-- confirm -->

<!-- alert 返回首页-->
	<div class="modal inmodal" id="appAlertModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <h4 class="modal-title" id="title">确认信息</h4> 
     </div> 
     <div class="modal-body text-center" id="msg"> 
    	请输入消息内容
     </div> 
     <div class="modal-footer"> 
      	<button type="button" class="btn btn-default" id="appAlertOk">确认</button>
     </div> 
    </div> 
   </div> 
  </div>
<script>
	function appAlert(options){
		var obj={
				title:'确认信息',
				msg:'请输入消息内容',
				ok:{
						text:'确定',
						callback:null
				}
			};
		if(options.ok){
			if(options.ok.text){
				obj.ok.text=options.ok.text;
			}
			if(options.ok.callback){
				obj.ok.callback=options.ok.callback;
			}else{
				obj.no.callback=null;
			}
		}
		if(options.title){
			obj.title=options.title;
		}
		if(options.msg){
			obj.msg=options.msg;
		}
		$("#appAlertModal #appAlertOk").unbind("click").text(obj.ok.text).click(function(){
			$("#appAlertModal").modal('hide');
			if(obj.ok.callback){
				obj.ok.callback();
			}
		});
		$("#appAlertModal #title").html(obj.title);
		$("#appAlertModal #msg").html(obj.msg);
		$("#appAlertModal").modal('show');
	};
</script>
<!-- alert -->
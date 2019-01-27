
  <div class="modal inmodal" id="MRFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">本月报告编辑</h4> 
     </div> 
     <div class="modal-body"> 
    	 <form :action="ajaxUrls.submitMRUrl" enctype="multipart/form-data" method="Post"  target="MRFormIframe">
    	 	  <input  name="_token" value="{{ csrf_token() }}" type="hidden" />
    	 	  <input  name="id"  :value="readPlan.id" type="hidden" />
    	 	  <div class="form-group">
		       	
		       	<div class="form-inline">
		       		<div class="form-group col-md-12 text-center">
		       		<label>[[readPlan.Mr_pdf]]</label>
		       		</div>
		       		<div class="form-group col-md-12 text-center">
				       <input v-model="readPlan.Mr_pdf" class="form-control" style="display:none" name='Mr_pdf' id='Mr_pdf' type="file" />
			    	   <a  class="btn btn-primary" onclick="$('input[name=Mr_pdf]').click();"><i class="fa fa-upload "></i> 选择上传文件</a> 
				    </div> 
		       	</div>
		       	<div style="clear:both"></div>
		       	<div style="clear:both"></div>
		      </div>
	      </form>
	      <iframe name="MRFormIframe" style="display:none"></iframe>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doCancelMRForm()">取消</button> 
      <button type="button" class="btn btn-primary" v-on:click="doSubmitMRForm()">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>

  <div class="modal inmodal" id="ArFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">Ar 报告编辑</h4> 
     </div> 
     <div class="modal-body"> 
    	 <form :action="ajaxUrls.submitARUrl" enctype="multipart/form-data" method="Post"  target="ArFormIframe">
    	 	  <input  name="_token" value="{{ csrf_token() }}" type="hidden" />
    	 	  <input  name="id"  v-model="editRPD.id" type="hidden" />
    	 	  <div class="form-group">
		       	<label>阅读测评报告:</label>
		       	<div class="form-inline">
		       		<div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_rar_zh" class="form-control" style="display:none" name='Ar_pdf_rar_zh' id='b.Ar_pdf_rar_zh' type="file" />
			    	   <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_rar_zh]').click();"><i class="fa fa-upload "></i> 选择上传文件(中文)</a>  
				    	[[editRPD.Ar_pdf_rar_zh]]
				    </div> 
				      <div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_rar_en" class="form-control" style="display:none" name='Ar_pdf_rar_en' id='Ar_pdf_rar_en' type="file" />
				       <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_rar_en]').click();"><i class="fa fa-upload "></i> 选择上传文件(英文)</a>  
				    	[[editRPD.Ar_pdf_rar_en]]
				    </div>
		       	</div>
		       	<div style="clear:both"></div>
		       	<br>
		       	<label>词汇测试报告:</label>
		       	<div class="form-inline">
		       		<div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_vt_zh" class="form-control" style="display:none" name='Ar_pdf_vt_zh' id='Ar_pdf_vt_zh' type="file" />
			    	   <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_vt_zh]').click();"><i class="fa fa-upload "></i> 选择上传文件(中文)</a>  
				    	[[editRPD.Ar_pdf_vt_zh]]
				    </div> 
				      <div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_vt_en" class="form-control" style="display:none" name='Ar_pdf_vt_en' id='Ar_pdf_vt_en' type="file" />
				       <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_vt_en]').click();"><i class="fa fa-upload "></i> 选择上传文件(英文)</a>  
				    	[[editRPD.Ar_pdf_vt_en]]
				    </div>
		       	</div>
		       	<div style="clear:both"></div>
		       	<br>
		       	<label>读写能力分析报告:</label>
		       	<div class="form-inline">
		       		<div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_rwaar_zh" class="form-control" style="display:none" name='Ar_pdf_rwaar_zh' id='Ar_pdf_rwaar_zh' type="file" />
			    	   <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_rwaar_zh]').click();">
			    	   <i class="fa fa-upload "></i> 
			    	         选择上传文件(中文)
			    	   </a>  
			    	   [[editRPD.Ar_pdf_rwaar_zh]]
				    </div> 
				      <div class="form-group col-md-6 text-center">
				       <input v-model="editRPD.Ar_pdf_rwaar_en" class="form-control" style="display:none" name='Ar_pdf_rwaar_en' id='Ar_pdf_rwaar_en' type="file" />
				       <a  class="btn btn-primary" onclick="$('input[name=Ar_pdf_rwaar_en]').click();">
				       <i class="fa fa-upload"></i> 
					   	  选择上传文件(英文)
				       </a>  
				       [[editRPD.Ar_pdf_rwaar_en]]
				    </div>
		       	</div>
		       	<div style="clear:both"></div>
		      </div>
		       
	      </form>
	      <iframe name="ArFormIframe" style="display:none"></iframe>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doCancelArForm()">取消</button> 
      <button type="button" class="btn btn-primary" v-on:click="doSubmitArForm()">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>
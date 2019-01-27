
  <div class="modal inmodal" id="FTFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">计划日期编辑</h4> 
     </div> 
     <div class="modal-body"> 
     		<form id="FTForm">
     			  <input type="hidden" v-model="readPlan.id"  name="plan_id" value=""/>
			      <div class="input-daterange input-group" id="datepicker" style="margin:0 auto;">
	                  <input type="text" v-model="readPlan.from" class="input-sm form-control" name="from" value=""/>
	                  <span class="input-group-addon">to</span>
	                  <input type="text" v-model="readPlan.to" class="input-sm form-control" name="to" value="" />
	        	  </div>
        	 </form>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doCancelFTForm()">取消</button> 
      <button type="button" class="btn btn-primary" v-on:click="doSubmitFTForm()">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>
  <script>
//日期控件
  $('.input-daterange').datepicker({
  				format:"yyyy-mm-dd",
                  keyboardNavigation: false,
                  forceParse: false,
                  autoclose: true,
  });
 </script>
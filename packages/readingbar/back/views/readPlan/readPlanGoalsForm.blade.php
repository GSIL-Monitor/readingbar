
  <div class="modal inmodal" id="GoalsFormModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated bounceInRight"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
     
      <h4 class="modal-title">本月目标</h4> 
     </div> 
     <div class="modal-body"> 
    	 <form :action="ajaxUrls.submitARUrl" enctype="multipart/form-data" method="Post"  target="ArFormIframe">
    	 	  <input  name="id"  v-model="Goals.id" type="hidden" />
    	 	  <input  name="plan_id"  v-model="Goals.plan_id" type="hidden" />
		      <div class="form-group">
		       <label>本月目标</label> 
		       <input placeholder="本月目标" class="form-control" v-model="Goals.goals" name="goals"  type="text" />
		      </div>
	      </form>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal" >取消</button> 
      <button type="button" class="btn btn-primary" v-on:click="doSubmitGoals()">确认</button> 
     </div> 
    </div> 
   </div> 
  </div>
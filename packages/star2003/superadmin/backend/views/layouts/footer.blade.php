<div class="footer">
    <div class="pull-right">
        Version <strong>1.0</strong> Dev.
    </div>
    <div>
        <strong>Copyright</strong> Readingbar.Net &copy; 2016-2017
    </div>
</div>
<div class="modal inmodal fade" id="deleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header" style="padding:5px">
					
             </div>
	         <div class="modal-body">
	         	<p><strong>{{ trans("common.text_delete?")}}</strong></p>
	         </div>
	         <div class="modal-footer">
	              <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans("common.text_no")}}</button>
	              <button type="button" class="btn btn-primary" onclick="$('#form').submit();">{{ trans("common.text_yes")}}</button>
	         </div>
    	 </div>
	</div>
</div>		
                           				
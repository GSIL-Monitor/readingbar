<script type="text/javascript">
	var fileSet=null;
	$(document).on('click',".file-set",function(){
		fileSet=$(this);
		if($("#loadfilemanage").html()==''){
			$("#loadfilemanage").load("{{url('admin/filemanage/operations')}}?operation=load_filemanage_html");
		}
		$("#myModal-filemanage").modal('show');
	});

	$(document).on('dblclick',".file",function(){
		if(fileSet){
			if(fileSet.attr('needType')){
				if(fileSet.attr('needType')!=$(this).attr('file-type')){
					alert('类型不匹配！');
					return;
				}
			}
			switch(fileSet[0].tagName){
				case 'INPUT':fileSet.val($(this).attr('id'));break;
				case 'IMG':fileSet.attr('src',$(this).attr('file-webPath'));break;
			}
			if(fileSet.attr("for-img") && $("#"+fileSet.attr("for-img"))[0]){
				$("#"+fileSet.attr("for-img")).attr('src',$(this).attr('file-webPath'));
			}
			if(fileSet.attr("for-input") && $("#"+fileSet.attr("for-input"))[0]){
				$("#"+fileSet.attr("for-input")).val($(this).attr('id'));
			}
			$("#myModal-filemanage").modal('hide');
		}
	});
</script> 
<div class="modal inmodal" id="myModal-filemanage" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="width:80%;">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title">Modal title</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="loadfilemanage"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
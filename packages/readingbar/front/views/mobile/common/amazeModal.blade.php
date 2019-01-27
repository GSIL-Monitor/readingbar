<div class="am-modal am-modal-alert" tabindex="-1" id="amazeAlert">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">Amaze UI</div>
    <div class="am-modal-bd">
      Hello world！
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>
<script>
	function amazeAlert(options){
		//标题
		title='提示';
		if(options.title){
			title=options.title;
		}
		$("#amazeAlert .am-modal-hd").text(title);
		//按钮
		var confirm='确定';
		if(options.confirm){
			confirm=options.confirm;
		}
		$("#amazeAlert .am-modal-btn").text(confirm);
		$("#amazeAlert .am-modal-btn").unbind("click");
		if(options.onConfirm){
			$("#amazeAlert .am-modal-btn").click(function(){
				options.onConfirm();
			});
		}
		//提示信息
		$("#amazeAlert .am-modal-bd").text(options.msg);
		$("#amazeAlert").modal();
	}
</script>

<script>
	var amazeConfirmNum=0;
	function amazeConfirm(options){
		amazeConfirmNum=(++amazeConfirmNum)%3;
		var id="#amazeConfirm"+amazeConfirmNum;
		html='<div class="am-modal am-modal-confirm" tabindex="-1" id="amazeConfirm'+amazeConfirmNum+'">';
		html=html+'<div class="am-modal-dialog">';
		html=html+'<div class="am-modal-hd">Amaze UI</div>';
		html=html+'<div class="am-modal-bd">';
		html=html+'message';
        html=html+'</div>';
        html=html+'<div class="am-modal-footer">';
        html=html+'<span class="am-modal-btn am-modal-btn-cancel" data-am-modal-cancel>取消</span>';
        html=html+'<span class="am-modal-btn am-modal-btn-confirm" data-am-modal-confirm>确定</span>';
        html=html+'</div>';
        html=html+'</div>';
	    html=html+'</div>';
	    if($(id).length==0){
	    	$('body').append(html);
		};
		//标题
		title='确认提示';
		if(options.title){
			title=options.title;
		}
		$(id+" .am-modal-hd").text(title);
		//按钮
		var confirm='确定';
		if(options.confirm){
			confirm=options.confirm;
		}
		$(id+"  .am-modal-btn-confirm").text(confirm);
		var cancel='取消';
		if(options.cancel){
			cancel=options.cancel;
		}
		$(id+"  .am-modal-btn-cancel").text(cancel);
		
		$(id+"  .am-modal-btn-confirm").unbind("click");
		if(options.onConfirm){
			$(id+"  .am-modal-btn-confirm").click(function(){
				options.onConfirm();
			});
		}
		
		$(id+"  .am-modal-btn-cancel").unbind("click");
		if(options.onCancel){
			$(id+"  .am-modal-btn-cancel").click(function(){
				options.onCancel();
			});
		}
		
		//提示信息
		$(id+"  .am-modal-bd").text(options.msg);
		$(id).modal('open');
	}
</script>
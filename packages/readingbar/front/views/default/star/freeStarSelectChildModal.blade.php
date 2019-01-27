<div class="modal fade" id="freeStarStuddent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">请选择孩子或添加一个孩子</h4>
            </div>
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-3" style="padding-bottom: 10px;">
            			<button  class="btn btn-default col-md-12" v-on:click="selectThis($event)" href="{{url('member/freeStar/goChildCreate')}}">添加新孩子</button>
            		</div>
            		@foreach(session('freeStarStuddent') as $s)
            			<div class="col-md-3" style="padding-bottom: 10px;">
            				<button class="btn btn-default col-md-12" v-on:click="selectThis($event)" href="{{url('member/freeStar/asignChild/'.$s['id'])}}">{{$s['name']}}</button>
            			</div>
            		@endforeach
            	
            	</div>
            </div>
            <div class="modal-footer">
           	 	<button type="button" class="btn btn-default" v-on:click="doSure()">确认</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
	$("#freeStarStuddent").modal('show');
	new Vue({
		el:"#freeStarStuddent",
		data:{
			goUrl:null
		},
		methods:{
			selectThis:function(e){
				$("#freeStarStuddent .modal-body button").removeClass('btn-primary');
				$(e.target).addClass('btn-primary');
				this.goUrl=$(e.target).attr('href');
			},
			doSure:function(){
				window.location.href=this.goUrl;
			}
		}
	});
</script>
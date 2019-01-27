<div class="am-modal am-modal-no-btn" tabindex="-1" id="freeStarStuddent">
    <div class="am-modal-dialog">
	    <div class="am-modal-hd"><span>请选择孩子或添加一个孩子</span>
	      <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
	    </div>
	    <div class="am-modal-bd">
	    	<temlpate v-for="s in students">
				<div>
					<button v-if="choose.id==s.id" class="chose-childname2" v-on:click="setStudent(s)">[[s.name]]</button>
					<button v-else class="chose-childname" v-on:click="setStudent(s)">[[s.name]]</button>
				</div>
			</temlpate>
	    </div>
	     <!--/-->
        <div class="chose-child-tj">
             <button class="btn-mysure am-btn ds-ij2 fl cd-popup-close" v-on:click="doSure()">确定</button>
			 <a  class="btn-mycancel am-btn ds-ij3 fr cd-popup-close" v-on:click="cancel()">取消</a>
		</div>
	    <!--/-->
    </div>
</div>
<script>
	$("#freeStarStuddent").modal('open');
	new Vue({
		el:"#freeStarStuddent",
		data:{
			students:{!! json_encode( session('freeStarStuddent')) !!},
			choose:null
		},
		methods:{
			doSure:function(){
				window.location.href="{{url('member/freeStar/asignChild')}}/"+this.choose.id;
			},
			setStudent:function(s){
				this.choose=s;
			}
		},
		
	});
</script>
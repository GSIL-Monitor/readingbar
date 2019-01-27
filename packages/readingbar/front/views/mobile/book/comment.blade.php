<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')

<!-- 扩展内容-->
<section id="bookComment">
  <div class="container pad30 margin20">
        <div class="am-form-group pad15">
                <textarea class="am-g book-message" rows="5" id="doc-ta-1" v-model="comment"></textarea>
        </div>
        <div class="am-form-group pad15">
                <button v-on:click="doComment()" class="btn-save5 fr">发送</button>
        </div>
        <!--/am-form-group-->
  </div>
</div>
  <!--/-->
</section>
<script type="text/javascript">
	var bookComment=new Vue({
		el:"#bookComment",
		data:{
			comment:null,
			search:{
				student_id:"{{$student_id}}",
				book_id:"{{$book_id}}"
			}
		},
		methods:{
			getComment:function(){
				var _this=this;
				$.ajax({
					url:"{{url('book/comment/'.$student_id.'/'.$book_id)}}",
					type:"GET",
					dataType:"json",
					success:function(json){
						if(json.status){
							if(json.data!=null){
								_this.comment=json.data.comment;
							}
						}else{
							amazeAlert({
								msg: json.error
							})
						}
					}
				});
			},
			doComment(){
				var _this=this;
				c={
					student_id:_this.search.student_id,
					book_id:_this.search.book_id,
					comment:_this.comment
				};
				$.ajax({
					url:"{{url('/book/comment')}}",
					data:c,
					type:"POST",
					dataType:"json",
					success:function(json){
						if(json.status){
							amazeAlert({
								msg: json.success,
								onConfirm: function () {
									window.history.back();
								}
							})
						}else{
							amazeAlert({
								msg: json.error
							})
						}
					}
				});
			}
		}
	});
	bookComment.getComment();
</script>
<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->

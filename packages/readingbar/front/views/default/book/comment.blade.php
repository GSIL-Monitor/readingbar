<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

<!-- 扩展内容-->
<link href="{{url('assets/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/js/plugins/cropper/cropper.min.js')}}"></script>
<div class="container">
    <div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	   <div class="col-md-10 home-column-fr100" id="bookComment">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">书评留言</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content mgl-40">
             	<div class="plan-book-message">
             		<textarea v-model="comment" class="book-message"></textarea>
             		<a href="javascript:void(0)" v-on:click="doComment()" class="book-message-buttom">发送</a>
             	</div>
           
          
		   <!--content-->
		   </div>
		
	</div>
	<!--/row end-->
	</div>
</div>
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
							appAlert({
								title: '提示',
								msg: json.error
							});
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
					url:"{{url('book/comment')}}",
					data:c,
					type:"POST",
					dataType:"json",
					success:function(json){
						if(json.status){
							appAlert({
								title: '提示',
								msg: json.success,
								ok: {
									text: '返回',
									callback: function () {
										window.history.back();
									}
								}
							});
						}else{
							appAlert({
								title: '提示',
								msg: json.error
							});
						}
					}
				});
			}
		}
	});
	bookComment.getComment();
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

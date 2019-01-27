<div style="clear:both"></div>
<footer>
    		<div>
	    		<p>京ICP备16035931号</p>
	    		<p>北京至诚天下网络科技有限公司</p>
    		</div>
</footer>
@if(session('freeStarStuddent'))
	<!-- 免费评测孩子信息 -->
	@include('front::default.star.freeStarSelectChildModal')
@endif
<script type="text/javascript">
	@if(session('alert'))
		//接收消息提示
		appAlert({
			title: '提示',
			msg: "{{ session('alert') }}"
		});
	@endif
</script>
<script src="{{url('home/pc/js/home_hover.js')}}"> </script>

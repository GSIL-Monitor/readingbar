<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<style type="text/css">
	body{ background: #fafafa;}
	.booklist-top{
		background: url('{{url('home/pc/images/booklist-top.png')}}')  0 0 no-repeat;
		background-size:100% auto;
		width:100%;
		height:41px;
	}
	.booklist-middle{
		background: url('{{url('home/pc/images/booklist-middle.png')}}')   0 0 repeat-y;
		background-size:100% auto;
		width:100%;
		min-height:40px;
		padding: 0px 70px 30px 70px;
	}
	.booklist-bottom{
		background: url('{{url('home/pc/images/booklist-bottom.png')}}')   0 0  no-repeat;
		background-size:100% auto;
		width:100%;
		height:43px;
	}
	.booklist-title{
		color: #009999;
		font-size: 26px;
		font-weight:bold;
		text-align:center;
		line-height:80px;
	}
	.bootlist-table{
		margin-bottom: 0px;
		font-size: 20px;
	}
	.bootlist-table,.bootlist-table th,.bootlist-table td{
		border-color:#7fe1d2 !important;
	}
	.bootlist-table thead th{
		text-align:center;
		color:#009999;
	}
	.bootlist-table tr td{
		vertical-align: middle !important;
	}
	.bootlist-table tr td:nth-child(1){
		color: #7fe1d2;
		font-weight:bold;
	}
	.bootlist-table tr th:nth-child(3),.bootlist-table tr th:nth-child(4){
		min-width:150px;
	}
</style>
<div class="container padt9">
	<div class="row">
	  	<div class="col-md-2 home-column-fl">
	  		@include('front::default.member.memberMenu')
	    </div>
	    <!--/ home-column-fl end-->
	    <div id="booklist" class="col-md-10 home-column-fr500" style="background-color:white">
		    <div class='booklist-top'></div>
		    <div class='booklist-middle'>
		    	<div class="booklist-title">蕊丁吧推荐书单</div>
		    	<table class='table bootlist-table table-bordered'>
		    		<thead>
		    			<tr>
			    			<th></th>
			    			<th>书名及作者</th>
			    			<th>Book Level</th>
			    			<th>AR Quiz No</th>
		    			<tr>
		    		</thead>
		    		<tbody>
		    			<tr v-for='(index,item) in list'>
		    				<td>[[index + 1]]</td>
		    				<td>《[[item.book_name]]》- [[item.author]]</td>
		    				<td>[[item.BL]]</td>
		    				<td>[[item.ARQuizNo]]</td>
		    			</tr>
		    		</tbody>
		    	</table>
		    </div>
		    <div class='booklist-bottom'></div>
		</div>
	</div>
</div>
<script>
	new Vue({
		el: '#booklist',
		data: {
			list: {!! $list !!}
		}
	});
</script>
<!-- //扩展内容--> 
@endsection
<!-- //继承整体布局 -->

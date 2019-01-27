<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<style type="text/css">
	.am-control-nav{ display: none;}
	.booklist-top{
		background: url('{{url('home/pc/images/booklist-top.png')}}')  0 0 no-repeat;
		background-size:100% auto;
		width:100%;
		height:20px;
	}
	.booklist-middle{
		background: url('{{url('home/pc/images/booklist-middle.png')}}')   0 0 repeat-y;
		background-size:100% auto;
		width:100%;
		min-height:40px;
		padding: 0px 40px 12px 40px;
		overflow:hidden;
	}
	.booklist-bottom{
		background: url('{{url('home/pc/images/booklist-bottom.png')}}')   0 0  no-repeat;
		background-size:100% auto;
		width:100%;
		height:23px;
	}
	.booklist-title{
		color: #009999;
		font-size: 18px;
		font-weight:bold;
		text-align:center;
		line-height: 40px;
	}
	.bootlist-table{
		margin-bottom: 0px;
		font-size: 12px;
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
		text-align:center;
	}
	.bootlist-table tr td:nth-child(1){
		color: #7fe1d2;
		font-weight:bold;
	}
	.bootlist-table tr th:nth-child(3),.bootlist-table tr th:nth-child(4){
		min-width:90px;
	}
</style>
<section  id="booklist">
	
		    <div class='booklist-top'></div>
		    <div class='booklist-middle'>
		    	<div class="booklist-title">蕊丁吧推荐书单</div>
		    	<table class='am-table bootlist-table am-table-bordered'>
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
</section>

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

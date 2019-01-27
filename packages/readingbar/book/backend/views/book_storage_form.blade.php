
<table class="table table-stripped table-bordered" id="book_storage_table">
  <thead>
    <tr>
      <th>编号</th>
      <th>全路径</th>
      <th>状态</th>
      <th>star账号</th>
      <th>学生</th>
      <th>学生昵称</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  	 @if(isset($storages))
 		@foreach($storages as $k=>$v)
		    <tr class="book_storage_row">
		    	   <input type="hidden" name="book_storage[{{$k}}][id]" value="{{$v['id']}}">
		    	  <td>
			        <input type="text" placeholder="" class="form-control serial" readonly="readonly" name="book_storage[{{$k}}][serial]" value="{{$v['serial']}}">
			      </td>
			      <td>
			        <input type="text" placeholder="" class="form-control"  name="book_storage[{{$k}}][storage_full_name]" value="{{$v['storage_full_name']}}">
			      </td>
			      <td style="vertical-align: middle">
			      		{{trans('Books.storage_status_'.	$v['status'])}}
			      </td>
			      <td style="vertical-align: middle">
			         @if(isset($v['lend_student']))
			         		<span>{{ $v['lend_student']->star_account }}</span>
			         @endif
			      </td>
			      <td style="vertical-align: middle">
			         @if(isset($v['lend_student']))
			         		<span>{{ $v['lend_student']->name }}</span>
			         @endif
			      </td>
			      <td style="vertical-align: middle">
			         @if(isset($v['lend_student']))
			         		<span>{{ $v['lend_student']->nick_name }}</span>
			         @endif
			      </td>
			      <td style="vertical-align: middle">
			      		@if($v['status']!=5)
			      			<input type="checkbox"  name="book_storage[{{$k}}][damage]">报损
			      		@endif
			      </td>
		    </tr>
 		@endforeach
 	@endif
    <tr>
	  	<td colspan="7" class="text-right"> 
	  		<a class="btn btn-white book-storage-btn-plus" >
		          <i class="fa fa-plus"></i>
		    </a>
		</td>
	</tr>
  </tbody>
</table>
<!--     用于编辑添加项                   -->
<div id="trhtml" style="display: none">
<!-- 	<tr class="book_storage_row"> -->
<!-- 		  <td> -->
<!-- 		        <input type="text" placeholder="" class="form-control serial" readonly="readonly" name="book_storage[{book_storage_num}][serial]"> -->
<!-- 		  </td> -->
<!-- 	      <td> -->
<!-- 	        <input type="text" placeholder="" class="form-control" name="book_storage[{book_storage_num}][storage_full_name]"> -->
<!-- 	      </td> -->
<!-- 	      <td> -->
<!-- 	        <input type="text" placeholder="" class="form-control" name="book_storage[{book_storage_num}][operate_by]"> -->
<!-- 	      </td> -->
<!-- 	      <td> -->
<!-- 		  	<select name="book_storage[{book_storage_num}][status]" class="form-control"> -->
<!-- 			  <option value="0">{{trans("Books.storage_status_0")}}</option> -->
<!-- 			  <option value="1">{{trans("Books.storage_status_1")}}</option> -->
<!-- 			  <option value="2">{{trans("Books.storage_status_2")}}</option> -->
<!-- 			  <option value="3">{{trans("Books.storage_status_3")}}</option> -->
<!-- 			  <option value="4">{{trans("Books.storage_status_4")}}</option> -->
<!-- 			</select> -->
<!-- 		  </td> -->
<!-- 	      <td> -->
<!-- 	        <a class="btn btn-white book-storage-btn-trash"> -->
<!-- 	          <i class="fa fa-trash"></i> -->
<!-- 	        </a> -->
<!-- 	      </td> -->
<!--     </tr> -->
</div>   
<script>
	$(function(){
		$(".book-storage-btn-plus").click(function(){
			cnum=$(".book_storage_row").length;
			tr='<tr class="book_storage_row"><td><input type="text"placeholder=""class="form-control serial"readonly="readonly"name="book_storage[{book_storage_num}][serial]"></td><td><input type="text"placeholder=""class="form-control"name="book_storage[{book_storage_num}][storage_full_name]"></td><td></td><td></td><td></td><td></td><td><a class="btn btn-white book-storage-btn-trash"><i class="fa fa-trash"></i></a></td></tr>';
			var regS = new RegExp("{book_storage_num}",'gi');
			$("#book_storage_table tbody tr").last().before(tr.replace(regS,cnum));
		});
		$("#book_storage_table").on("click",".book-storage-btn-trash",function(){
			$(this).parents(".book_storage_row").remove();
		});
		$("#book_storage_table").on("click",".book-storage-btn-trash-exist",function(){
			index=$(this).parents('.book_storage_row').index('.book_storage_row');
			$('.book_storage_row').eq(index).append('<input type="text" name="book_storage['+index+'][delete]" value="true">');
			$('.book_storage_row').eq(index).hide();
		});
		$("input[name='book[ISBN]']").keyup(function(){
			$(".storage_full_name").each(function(){
				str=$(this).val();
				arr=str.split('-');
				arr.length;
				
			});
		});
	});
</script>

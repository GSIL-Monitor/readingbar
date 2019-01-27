
<table class="table table-stripped table-bordered" id="attach_table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Type</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
 	@if(isset($attaches))
 		@foreach($attaches as $k=>$v)
		 	<tr class="attach_row">
		 		  <input type="hidden" name="attach[{{$k}}][id]" value="{{$v['id']}}">
			      <td>
			        <input type="text" placeholder="" class="form-control" name="attach[{{$k}}][title]" value="{{$v['title']}}" id="attach_title_{{ $k }}">
			        <input type="file" placeholder=""  name="attach[{{$k}}][file]" value="{{$v['title']}}" id="attach_file_{{ $k }}" style="display: none">
			      </td>
			       <td>
			        {{$v['type']}}
			      </td>
			      <td>
			        <a class="btn btn-white attach-btn-trash-exist">
			          <i class="fa fa-trash"></i>
			        </a>
			        <a class="btn btn-white attach-btn-edit">
			          <i class="fa fa-edit"></i>
			        </a>
			      </td>
		    </tr>
 		@endforeach
 	@endif
    <tr>
	  	<td colspan="4" class="text-right"> 
	  		<a class="btn btn-white attach-btn-plus" >
		          <i class="fa fa-plus"></i>
		    </a>
		</td>
	</tr>
  </tbody>
</table>
<!--     用于编辑添加项                   -->
<!--     <tr class="attach_row"> -->
<!-- 	      <td> -->
<!-- 	        <input type="text" placeholder="" class="form-control file-set" readonly="readonly" name="attach[{attach_num}][path]"> -->
<!-- 	      </td> -->
<!-- 	      <td> -->
<!-- 	        <input type="text" placeholder="" class="form-control" name="attach[{attach_num}][type]"> -->
<!-- 	      </td> -->
<!-- 	      <td> -->
<!-- 	        <input type="text" placeholder="" class="form-control" name="attach[{attach_num}][title]"> -->
<!-- 	      </td> -->
<!-- 	      <td> -->
<!-- 	        <a class="btn btn-white attach-btn-trash"> -->
<!-- 	          <i class="fa fa-trash"></i> -->
<!-- 	        </a> -->
<!-- 	      </td> -->
<!--     </tr> -->
<script>
	$(function(){
		$(".attach-btn-plus").click(function(){
			cnum=$(".attach_row").length;
			//var tr='<tr class="attach_row"><td><input type="text"placeholder=""class="form-control file-set"readonly="readonly"name="attach[{attach_num}][path]"></td><td><input type="text"placeholder=""class="form-control"name="attach[{attach_num}][type]"></td><td><input type="text"placeholder=""class="form-control"name="attach[{attach_num}][title]"></td><td><a class="btn btn-white attach-btn-trash"><i class="fa fa-trash "></i></a></td></tr>';
			var tr='<tr class="attach_row"><td colspan=3><input type="file"placeholder=""name="attachFiles[]"></td></tr>';
			var regS = new RegExp("{attach_num}",'gi');
			$("#attach_table tbody tr").last().before(tr.replace(regS,cnum));
		});
		$("#attach_table").on("click",".attach-btn-trash",function(){
			$(this).parents(".attach_row").remove();
		});
		$("#attach_table").on("click",".attach-btn-trash-exist",function(){
			index=$(this).parents('.attach_row').index('.attach_row');
			$('.attach_row').eq(index).append('<input type="text" name="attach['+index+'][delete]" value="true">');
			$('.attach_row').eq(index).hide();
		});
		$("#attach_table").on("click",".attach-btn-edit",function(){
			index=$(this).parents('.attach_row').index('.attach_row');
			if($('.attach_row').eq(index).find("input[type=file]").is(":hidden")){
				$('.attach_row').eq(index).find("input[type=file]").removeAttr("disabled").show();
				$('.attach_row').eq(index).find("input[type=text]").attr("disabled","disabled").hide();
			}else{
				$('.attach_row').eq(index).find("input[type=text]").removeAttr("disabled").show();
				$('.attach_row').eq(index).find("input[type=file]").attr("disabled","disabled").hide();
			}
		});
	});
</script>
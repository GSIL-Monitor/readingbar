@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'List' }}</h2>
                    <ol class="breadcrumb">
                    	@foreach($breadcrumbs as $b)
                        <li>
                        	@if($b['active'])
                            	<strong class="active">{{ trans($b['name']) }}</strong>
                        	@else
                        		<a href="{{$b['url']!=''?url($b['url']):'javascript:void(0);'}}">{{ trans($b['name']) }}</a>
                        	@endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
 <div class="wrapper wrapper-content animated fadeInRight">
 	@if($success!='')
    <div class="alert alert-success" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>{{$success}}</strong>
	</div>
	@endif
	@if($error!='')
	<div class="alert alert-danger" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>{{$error}}</strong>
	</div>
	@endif
    <div class="row">
             <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  {{ trans('book_comment.list_title') }} </h5>
                        <div class="ibox-tools">
                        	<a href="{{ url('/admin/book_comment/create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a  href="#" data-target="#deleteModal" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-trash-o"></i>   {{ trans('common.delete') }}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
						<form method="POST" action="{{ url('/admin/book_comment/destroy') }}" id="form">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
                        <table id="comment_table" class="table table-striped">
                           <thead>
	                           
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                        </form>	
                    </div>
                </div>
            </div>
    </div>
</div>

<!-- Page-Level Scripts -->
<link href="{{asset('assets/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<script src="{{asset('assets/js/plugins/dataTables/datatables.min.js')}}"></script>
<script>
        $(document).ready(function(){
            $('#comment_table').DataTable({
            	processing : true,  
                serverSide : true,  
                ajax : {
                		url:"{{url('admin/book_comment/ajax_comments')}}",
                		"dataSrc": function ( json ) {
                		      for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                		    	json.data[i][json.data[i].length] = '<a class="btn btn-outline btn-info" href="{{url("admin/book_comment")}}/'+json.data[i][0]+'/edit"><i class="fa fa-edit"></i>{{trans("common.edit")}}</a>';
                		    	json.data[i][0]="<input type='checkbox' id='check-selected' name='selected[]' value='"+json.data[i][0]+"'/>";
								if(json.data[i][5]==1){
									json.data[i][5]="{{trans('book_comment.comment_status_1')}}";
								}else{
									json.data[i][5]="{{trans('book_comment.comment_status_0')}}";
								}
                		      }
                		      return json.data;
                		}
                },
                "columns": [
							{ "title": "<input type='checkbox' id='check-selected-all'/>","bSortable": false },
							@foreach($columns as $column)
								{ "title": "{{trans('book_comment.column_'.$column)}}" },
							@endforeach
							{ "title": "{{trans('common.operations')}}","bSortable": false },
                        ],
                        "oLanguage": {//插件的语言设置
                            "sLengthMenu": "每页显示 _MENU_ 条记录",
                            "sZeroRecords": "抱歉， 没有找到",
                            "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                            "sInfoEmpty": "没有数据",
                            "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "前一页",
                                "sNext": "后一页",
                                "sLast": "尾页"
                            },
                            "sZeroRecords": "没有检索到数据",
                            "sProcessing": "<img src='' />",
                            "sSearch": "搜索"
                        },   
                        "oLanguage": {//插件的语言设置
                            "sLengthMenu": "{{trans('datatableJs.sLengthMenu')}}",
                            "sZeroRecords": "{{trans('datatableJs.sZeroRecords')}}",
                            "sInfo": "{{trans('datatableJs.sInfo')}}",
                            "sInfoEmpty": "{{trans('datatableJs.sInfoEmpty')}}",
                            "sInfoFiltered": "{{trans('datatableJs.sInfoFiltered')}}",
                            "oPaginate": {
                                "sFirst": "{{trans('datatableJs.oPaginate.sFirst')}}",
                                "sPrevious": "{{trans('datatableJs.oPaginate.sPrevious')}}",
                                "sNext": "{{trans('datatableJs.oPaginate.sNext')}}",
                                "sLast": "{{trans('datatableJs.oPaginate.sLast')}}"
                            },
                            "sZeroRecords": "{{trans('datatableJs.sZeroRecords')}}",
                            "sSearch": "{{trans('datatableJs.sSearch')}}"
                        },                        
            });
        });
</script>
@endsection



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
	 <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  {{trans('survey.members_list')}} </h5>
                    </div>
                    
                    <div class="ibox-content">
						<div class="row">
	                        <div class="table-responsive col-md-12">
			                    <table id="member_table" class="table table-striped table-bordered table-hover dataTables-example" >
			                    <thead>
			                   	
			                    </thead>
			                    <tbody>
			                   
			                    </tbody>
			                    </table>
	                        </div>
						</div>
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
            $('#member_table').DataTable({
            	processing : true,  
                serverSide : true,  
                ajax : {
                		url:"{{url('admin/survey/ajax_studentList')}}",
                		"dataSrc": function ( json ) {
                		      for ( var i=0, ien=json.data.length ; i<ien ; i++ ) {
                		        json.data[i][5] = '<a class="btn btn-outline btn-info" href="{{url("admin/survey")}}/'+json.data[i][0]+'/result"><i class="fa fa-edit"></i>{{trans("survey.survey_result")}}</a>';
                		      }
                		      return json.data;
                		}
                },
                "columns": [
							{ "title": "{{trans('survey.column_id')}}" },
                            { "title": "{{trans('survey.column_parent')}}" },
                            { "title": "{{trans('survey.column_student')}}" },
                            { "title": "{{trans('survey.column_cellphone')}}" },
                            { "title": "{{trans('survey.column_email')}}"},
                            { "title": "{{trans('survey.column_action')}}" }
                        ],
                        "aoColumnDefs":[//设置列的属性，此处设置第一列不排序
                            {"bSortable": false, "aTargets": [-1]},{ "class": "tn", "targets": [ 0 ] }
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



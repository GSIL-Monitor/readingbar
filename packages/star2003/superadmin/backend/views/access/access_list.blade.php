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
                        <h5><i class="fa fa-list-ul"></i>  {{ trans('access.list_title') }} </h5>
                        <div class="ibox-tools">
                            <a href="{{ url('/admin/access/create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a  href="#" data-target="#deleteModal" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-trash-o"></i>   {{ trans('common.delete') }}</a>
                        </div>
                    </div>
                    <div class="ibox-content">
						<form method="POST" action="{{ url('/admin/access/destroy') }}" id="form">
						{!! csrf_field() !!}
						{{ method_field('DELETE') }}
                        <table class="table table-striped">
                           <thead>
	                            <tr>
									<td><input type="checkbox"></td>
									@foreach($columns as $column)
										<td>{{trans('access.column_'.$column)}}</td>
									@endforeach
									<td>{{trans('common.operations')}}</td>
								</tr>
                            </thead>
                            <tbody>
                            @foreach ($accesss as $access)
						       <tr>
						       <td><input type="checkbox" name="selected[]" value="{{ $access->id }}"/></td>
						       	@foreach($columns as $column)
						       		@if($column=='role')
						       			<td>{{ $accesss[$access->$column] or '' }}</td>
						       		@else
						       			<td>{{ $access->$column }}</td>
						       		@endif
								@endforeach
								<td>
									<a href="{{url('admin/access/'.$access->id.'/edit')}}" class="btn btn-outline btn-info"><i class="fa fa-edit"></i>  {{trans('common.edit')}}</a>
								</td>
						       </tr> 
						     @endforeach
                            </tbody>
                        </table>
                        </form>	
                        <div >{!! $accesss->links() !!}</div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection



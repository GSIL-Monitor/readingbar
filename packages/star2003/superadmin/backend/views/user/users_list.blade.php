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
                            <h5><i class="fa fa-list-ul"></i>  {{ trans('user.list_title') }} </h5>
                            <div class="ibox-tools">
                                <a href="{{ url('/admin/user/create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            
<!--  -->
					    <div class="row">
					    @foreach ($users as $user)
					    	<div class="col-lg-3">
					                <div class="contact-box center-version">
					                    <a href="{{url('admin/user/'.$user->id.'/edit')}}">
					                        <img alt="image" class="img-circle" src="{{$user->avatar?url($user->avatar):url('files/avatar/default_avatar.jpg')}}">
					                        <h3 class="m-b-xs"><strong>{{$user->name}}</strong></h3>
					                        <div class="font-bold">{{$roles[$user->role]}}</div>
					                        <address class="m-t-md">
					                            <strong>Readingbar.Net</strong><br>
					                            {{$user->email}}<br>
					                            
					                        </address>
					                    </a>
					                    <div class="contact-box-footer">
					                        <div class="m-t-xs btn-group">
					                            <a href="{{url('admin/user/'.$user->id.'/edit')}}" class="btn btn-xs btn-white"><i class="fa fa-edit"></i> {{ trans('common.edit') }}</a>
					                            <a v-on:click="setDeleteId({{$user->id}})" data-target="#userDeleteModal" data-toggle="modal" class="btn btn-xs btn-white"><i class="fa fa-trash"></i> {{ trans('common.delete') }}</a>
					                        </div>
					                    </div>
					                </div>
					        </div>
					    @endforeach
					    </div>
					     <div >{!! $users->links() !!}</div>
                        </div>
                    </div>
                </div>

    </div>
</div>
<div class="modal inmodal fade" id="userDeleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header" style="padding:5px">
					
             </div>
	         <div class="modal-body">
	         	<p><strong>{{ trans("common.text_delete?")}}</strong></p>
	         </div>
	         <div class="modal-footer">
	              <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans("common.text_no")}}</button>
	              <button type="button" class="btn btn-primary" v-on:click="doDelete()">{{ trans("common.text_yes")}}</button>
	         </div>
    	 </div>
	</div>
</div>	
<script>
	new Vue({
		el:"body",
		data:{
			id:null
		},
		methods:{
				setDeleteId:function(id){
					this.id=id;
				},
				doDelete:function(){
					if(this.id!=null){
						window.location.href="{{url('admin/user')}}/"+this.id+"/delete";
					}
				}
			}
	});
</script>
@endsection
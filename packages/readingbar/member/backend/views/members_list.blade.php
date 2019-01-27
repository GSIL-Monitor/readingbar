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
                        <h5><i class="fa fa-list-ul"></i>  {{ trans('members.list_title') }} </h5>
                        <div class="ibox-tools">
                        	<a href="{{ url('/admin/members/create') }}" class="btn btn-primary btn-xs"><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        </div>
                    </div>
                    <!--  -->
                    <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody>
                                    <tr v-for="m in listdata.data">
                                        <td width="90px">
                                            <div class="cart-product-imitation" style="padding-top: 0px">
                                            	<img alt="" :src="m.avatar" style="width:80ox;height:80px;">
                                            </div>
                                        </td>
                                        <td class="desc">
                                            <h3>
                                            <a href="#" class="text-navy">
                                               [[m.nickname]]
                                            </a>
                                            </h3>
                                            <div class="inline col-md-3">
                                            	<label>{{trans('members.column_email')}}:<em>[[m.email]]</em></label>
                                            </div>
                                            <div class="inline col-md-3">
                                            	<label>{{trans('members.column_cellphone')}}:<em>[[m.cellphone]]</em></label>
                                            </div>
                                            <div class="m-t-sm" style="clear:both">
                                                <a :href="m.editurl" class="text-muted"><i class="fa fa-edit"></i>{{trans('common.edit')}}</a>
                                                |
                                                <a v-on:click='doDelete(m.deleteurl)' class="text-muted"><i class="fa fa-trash"></i>{{trans('common.delete')}}</a>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                    <tfoot v-if="listdata.total_pages">
                                    	<tr>
                                    		<td colspan='3'>
                                    			<ul class="pagination pull-right" >
											    	<li v-if="listdata.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
										    		<template v-for="p in listdata.total_pages" v-if="Math.abs(listdata.current_page-(p+1))<=3">
										    			<li v-if="listdata.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
										    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
										    		</template>
											     	<li v-if="listdata.current_page < listdata.total_pages" v-on:click="doChangePage(listdata.total_pages)"><a>»</a></li>
										     	</ul>
                                    		</td>
                                    	</tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    <!--  -->
                </div>
            </div>
    </div>
</div>

<script type="text/javascript">

 var _members=new Vue({
		el:"body",
		data:{
				search:{
						page:1,
						limit:10,
						like:null
				},
				listdata:null,
		},
		methods:{
			//获取会员列表
			getMembers:function(){
					var _this=this;
					$.ajax({
						url:"{{url('admin/members/ajax_memberList')}}",
						type:"GET",
						data:_this.search,
						dataType:"json",
						success:function(json){
							if(json.status){
								_this.listdata=json;
							}else{
								alert(json.msg);
							}
						}
					});
			},
			//翻页
			doChangePage:function(page){
				this.search.page=page;
				this.getMembers();
			},
			//删除
			doDelete:function(url){
				if(!confirm('删除后将不可恢复！是否要删除？')){
					return false;
				}
				var _this=this;
				$.ajax({
					url:url,
					type:"GET",
					data:_this.search,
					dataType:"json",
					success:function(json){
						if(json.status){
							alert(json.success);
							_this.getMembers();
						}else{
							alert(json.error);
						}
					}
				});
			}
		}
	});
 _members.getMembers();
</script>
@endsection



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
<div class="wrapper wrapper-content animated fadeInRight" id="PEPsList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  公告列表 </h5>
                        <div class="ibox-tools">
                        	<a :href="a.create" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a href="javascript:void(0)" v-on:click="doDelete()" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i>   {{ trans('common.delete') }}</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th><input type="checkbox" :checked="(selected.length==PEPs.data.length)" name="selectedAll" v-on:click="selectedAll()"></th>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	附加价格标识
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	押金
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	附加价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	类型
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	备注
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建时间
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	更新时间 
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="r in PEPs.data">
		                        <td class="footable-visible footable-first-column">
		                   
		                        <input v-model="selected" type="checkbox" name="selected" :value="r.id">
		                        </td>
		                        <td class="footable-visible">[[r.id]]</td>
		                        <td class="footable-visible">[[r.name]]</td>
		                        <td class="footable-visible">[[r.product_name]]</td>
		                        <td class="footable-visible">[[r.price]]</td>
		                        <td class="footable-visible">[[r.deposit]]</td>
		                        <td class="footable-visible">[[r.extra_price]]</td>
		                        <td class="footable-visible">
			                       	<a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" :data-original-title="r.areas"  v-if='r.type=1'>
		                        		[[r.type_name]]
		                        	</a>
		                        	<template v-else>
		                        		[[r.type_name]]
		                        	</template>
		                        </td>
		                        <td class="footable-visible">[[r.memo]]</td>
		                        <td class="footable-visible">[[r.status]]</td>
		                        <td class="footable-visible">[[r.created_at]]</td>
		                        <td class="footable-visible">[[r.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" :href="r.edit">编辑</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="PEPs && PEPs.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="PEPs.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in PEPs.last_page" v-if="Math.abs(PEPs.current_page-(p+1))<=3">
							    			<li v-if="PEPs.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="PEPs.current_page < PEPs.last_page" v-on:click="doChangePage(PEPs.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
</div>
<script type="text/javascript">
var PEPsList=new Vue({
	el:"#PEPsList",
	data:{
		PEPs:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		a:{
			create:"{{url('admin/product/PEP/form')}}"
		},
		selected:[],
		alert:null
	},
	created:function(){
		this.doGetPEPs();
	},
	methods:{
		//获取公告数据
		doGetPEPs:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/product/PEP/getPEPs') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.PEPs=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//选择所有复选框
		selectedAll:function(){
			if(this.selected.length==this.PEPs.data.length){
				this.selected=[];
			}else{
				s=[];
				for(i in this.PEPs.data){
					s[i]=this.PEPs.data[i].id;
				}
				this.selected=s;
			}
		},
		//删除按钮
		doDelete:function(){
			if(confirm('是否确认删除！')){
				var _this=this;
				$.ajax({
					url:"{{ url('admin/api/product/PEP/deletePEP') }}",
					data:{selected:_this.selected},
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doAlert('success',json.success);
							_this.doGetPEPs();
						}else{
							_this.doAlert('error',json.error);
						}
						
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						console.log(XMLHttpRequest.status);
						console.log(XMLHttpRequest.readyState);
						console.log(textStatus);
					}
				});
			}
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetPEPs();
		},
		//提示信息
		doAlert:function(type,msg){
			switch(type){
				case 'success':
					this.alert={
							msg:msg,
							classes:'alert alert-success'
						}
					break;
				case 'error':
					this.alert={
						msg:msg,
						classes:'alert alert-danger'
					}
	 				break;
			}
		}
	}
});
$('body').on('mouseenter',"[data-toggle='tooltip']",function(){
	$(this).tooltip('show');
});
</script>
@endsection



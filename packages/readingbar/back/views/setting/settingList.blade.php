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
<div class="wrapper wrapper-content animated fadeInRight" id="mainList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  配置列表 </h5>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	配置
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	值
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
		                    <tr class="footable-even" style="display: table-row;" v-for="n in settings.data">
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.name]]</td>
		                        <td class="footable-visible">[[n.value]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" v-on:click="showModal(n)">编辑</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="notices && notices.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="notices.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in notices.last_page" v-if="Math.abs(notices.current_page-(p+1))<=3">
							    			<li v-if="notices.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="notices.current_page < notices.last_page" v-on:click="doChangePage(notices.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	<!-- setting编辑modal -->
	  <div class="modal inmodal" id="SettingModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
	   <div class="modal-dialog"> 
	    <div class="modal-content animated bounceInRight"> 
	     <div class="modal-header"> 
	      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
	     
	      <h4 class="modal-title">配置编辑</h4> 
	     </div> 
	     <div class="modal-body"> 
	    	 <div class="row">
	    	 	<div class="form-group">
	    	 		<lable><strong>[[ form.name ]]</strong></lable>
	    	 		<textarea v-model="form.value" class="form-control"></textarea>
	    	 		<label class="error" v-if="form.memo">注:[[ form.memo ]]</label>
	    	 	</div>
	    	 </div>
	     </div> 
	     <div class="modal-footer"> 
	      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doCancelArForm()">取消</button> 
	      <button type="button" class="btn btn-primary" v-on:click="editSetting()">保存</button> 
	     </div> 
	    </div> 
	   </div> 
	  </div>
</div>

<!-- setting编辑modal -->
<script type="text/javascript">
var mainList=new Vue({
	el:"#mainList",
	data:{
		settings:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		form:null,
	},
	created:function(){
		this.doGetDatas();
	},
	methods:{
		//获取公告数据
		doGetDatas:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/setting/getSettings') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.settings=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//翻页
		doChangePage:function(p){
			this.search.page=p;
			this.doGetDatas();
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
		},
		//showModal
		showModal:function(s){
			this.form=s;
			$("#SettingModal").modal('show');
		},
		//编辑配置信息
		editSetting:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/setting/editSetting') }}",
				data:_this.form,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						alert(json.success);
					}else{
						alert(json.error);
					}
					_this.search.ajaxStatus=false;
					_this.doGetDatas();
				},
				error:function(){
					_this.search.ajaxStatus=false;
					_this.doGetDatas();
				}
			});
			$("#SettingModal").modal('hide');
		}
	}
});
</script>
@endsection



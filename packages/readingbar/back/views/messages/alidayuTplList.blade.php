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
<div class="wrapper wrapper-content animated fadeInRight"  id='main-container'>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  模板列表 </h5>
                        <div class="ibox-tools">
                        	<a class="btn btn-primary btn-xs"  v-on:click='doCreate()'><i class="fa fa-plus-square-o"></i>   新增</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	标题
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	SMS Code
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	消息内容
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	创建时间
		                        </th>
		                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody v-if="loading">
		                    <tr class="footable-even" >
		                        <td colspan="12"  class="footable-visible text-center">
		                        	<i class='fa fa-spin fa-refresh'></i>
		                        	数据加载中
		                        </td>
		                    </tr>
		                </tbody>
		                <tbody v-if="!loading">
		                    <tr class="footable-even" style="display: table-row;" v-for="d in list.data">
		                        <td class="footable-visible">[[d.name]]</td>
		                        <td class="footable-visible">[[d.sms]]</td>
		                        <td class="footable-visible" >
		                        		<a :title="d.content">[[d.content.substr(0,10)]]...</a>
		                        </td>
		                        <td class="footable-visible" >
		                        		[[d.created_at]]
		                        </td>
		                        <td class="footable-visible text-right">
		                        	<i class='fa fa-spin fa-refresh' v-if='d.operating'></i>
		                        	<template v-else>
		                        		<a v-on:click='showTestModal(d)'>测试</a>
		                        		<a v-on:click='doEdit(d)'>编辑</a>
		                        		<a v-on:click='doDelete(d)'>删除</a>
		                        	</template>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="!loading && list && list.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="list.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in list.last_page" v-if="Math.abs(list.current_page-(p+1))<=3">
							    			<li v-if="list.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="list.current_page < list.last_page" v-on:click="doChangePage(list.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="myModalLabel">消息模板编辑</h4>
	            </div>
	            <div class="modal-body ">
	            	<div class="form-group">
	                  <label>标题</label>
	                  <input type="text" class="form-control" placeholder="Enter ..."  v-model='form.name'>
	                  <label style='color:red' v-if='formErrors["name"]'>[[ formErrors["name"][0] ]]</label>
	                </div>
	                <div class="form-group">
	                  <label>sms code</label>
	                  <input type="text" class="form-control" placeholder="Enter ..."  v-model='form.sms'>
	                  <label style='color:red' v-if='formErrors["sms"]'>[[ formErrors["sms"][0] ]]</label>
	                </div>
	                <div class="form-group">
	                  <label>内容（该内容仅作参考，短信内容以短信服务商设置为准）</label>
	                  <textarea type="text" class="form-control"  v-model='form.content'></textarea>
	                  <label style='color:red' v-if='formErrors["content"]'>[[ formErrors["content"][0] ]]</label>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary"  v-if='submiting'>
	                	<i class='fa fa-spin fa-refresh' ></i>
	                </button>
	                 <button type="button" class="btn btn-primary" v-on:click='doSubmit()' v-else>
	                	保存
	                </button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="modal-send-test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="myModalLabel">模板测试</h4>
	            </div>
	            <div class="modal-body ">
	            	<div class="form-group">
	                  <label>电话</label>
	                  <input type="text" class="form-control" placeholder="Enter ..."  v-model='tel'>
	                  <label>注：该测试仅仅测试短信模板是否可用！</label>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	                <button type="button" class="btn btn-primary"  v-if='submiting'>
	                	<i class='fa fa-spin fa-refresh' ></i>
	                </button>
	                 <button type="button" class="btn btn-primary" v-on:click='doTest()' v-else>
	                	发送
	                </button>
	            </div>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div>
</div>
<script type="text/javascript">
	new Vue({
		el: '#main-container',
		data: {
			list: [],
			search: {
				page: 1
			},
			form: {
				id: null,
				name: null,
				sms: null,
				content: null
			},
			formErrors: {},
			tel: '',
			loading: false,
			submiting: false,
			checkData: null
		},
		created: function(){
			this.doGetList();
		},
		methods: {
			// 获取列表数据
			doGetList: function(){
				var _this = this;
				$.ajax({
					url: "{{ url('admin/alidayuTpl/list')}}",
					type: "get",
					dateType: 'json',
					data: this.search,
					beforeSend: function(){
						_this.loading = true;
					},
					success: function (json) {
						for(var i in json.data) {
							 json.data[i].operating = false
						}
						_this.list  = json;
					},
					complete: function () {
						_this.loading = false;
					}
				});
			},
			// 删除
			doDelete: function(d){
				var _this = this;
				appConfirm({
					title: '删除确认',
					msg: '删除前请确认该模板未在使用中，确认删除？',
					ok: {callback:function(){
						$.ajax({
							url: "{{ url('admin/alidayuTpl/delete')}}",
							type: "post",
							dateType: 'json',
							data: {id: d.id},
							beforeSend: function(){
								d.operating = true;
							},
							success: function (json) {
								for(var i in _this.list.data){
									if(_this.list.data[i].id == d.id){
										_this.list.data.splice(i,1);
									}
								}
							},
							complete: function () {
								if (d){
									d.operating = false;
								}
							}
						});
					}}
				});
			},
			// 创建modal
			doCreate:function(){
				this.formErrors = {};
				this.form.id = null;
				this.form.name = null;
				this.form.sms = null;
				this.form.content = null;
				$("#modal-form").modal({backdrop: 'static', keyboard: false});
			},
			// 修改modal
			doEdit:function(d){
				this.formErrors = {};
				this.form.id = d.id;
				this.form.name = d.name;
				this.form.sms = d.sms;
				this.form.content = d.content;
				$("#modal-form").modal({backdrop: 'static', keyboard: false});
			},
			// 提交数据
			doSubmit: function(){
				var _this = this;
				$.ajax({
					url: _this.form.id?"{{ url('admin/alidayuTpl/update')}}":"{{ url('admin/alidayuTpl/store')}}",
					type: 'post',
					dateType: 'json',
					data:_this.form,
					beforeSend: function(){
						_this.submiting = true;
					},
					success: function (json) {
						if (_this.form.id){
							for(var i in _this.list.data){
								if(_this.list.data[i].id == json.data.id){
									_this.list.data.splice(i,1,json.data);
								}
							}
						}else{
							_this.list.data.splice(0,0,json.data);
						}
						appAlert({
							title: '提示',
							msg: json.message
						});
						$("#modal-form").modal('hide');
					},
					error: function(error){
						if (error.status == 400){
							_this.formErrors = error.responseJSON.errors;
						}
					},
					complete: function () {
						_this.submiting = false;
					}
				});
			},
			// 列表翻页
			doChangePage: function(page){
				this.search.page = page;
				this.doGetList();
			},
			showTestModal(d){
				this.checkData = d;
				$("#modal-send-test").modal({backdrop: 'static', keyboard: false});
			},
			doTest () {
				var _this = this;
				$.ajax({
					url: "{{ url('admin/alidayuTpl/test')}}",
					type: 'post',
					dateType: 'json',
					data:{
						id: _this.checkData.id,
						tel: _this.tel
					},
					beforeSend: function(){
						_this.submiting = true;
					},
					success: function (json) {
						appAlert({
							title: '提示',
							msg: json.message?json.message:'手机号或者sms code 有误'
						});
						$("#modal-send-test").modal('hide');
					},
					error: function(error){
						appAlert({
							title: '提示',
							msg:  '手机号或者sms code 有误'
						});
					},
					complete: function () {
						_this.submiting = false;
					}
				});
			}
		}
	})
</script>
@endsection



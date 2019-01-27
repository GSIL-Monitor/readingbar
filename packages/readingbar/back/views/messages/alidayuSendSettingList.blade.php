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
	                        <h5><i class="fa fa-list-ul"></i>条件筛选</h5>
	                </div>
			        <div class="ibox-content">
			        		<div role="form" class="form-inline">
                                <div class="form-group col-md-2">
                                    <select class="form-control"  v-model='readySearch.tpl_id'  style='width: 100%;'>
				                  		<option value="">请选择消息模板</option>v-model='readySearch.
				                  		<option v-for='t in tpls' :value="t.id">[[ t.name ]]</option>
				                  </select>
                                </div>
                                <div class="form-group  col-md-2">
                                    <select class="form-control"  v-model='readySearch.type'  style='width: 100%;'>
				                  		<option value="">请选择消息类型</option>
				                  		<option v-for='(key,type) in types' :value="key">[[ type ]]</option>
				                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                   <select class="form-control"  v-model='readySearch.product_id'  style='width: 100%;'>
				                  		<option value="">请选择产品</option>
				                  		<option v-for='p in products' :value="p.id">[[ p.name ]]</option>
				                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control"  v-model='readySearch.service_id'  style='width: 100%;'>
				                  		<option value="">请选择服务</option>
				                  		<option v-for='s in services' :value="s.id">[[ s.name ]]</option>
				                  </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control"  v-model='readySearch.status' style='width: 100%;'>
				                  		<option value="">请选状态</option>
				                  		<option v-for='(key, s) in status' :value="key">[[ s ]]</option>
				                  </select>
                                </div>
                                <button class="btn btn-white" type="submit" v-on:click='doSearch()'>检索</button>
                            </div>
			        </div>
			     </div>
			 </div>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  发送设置列表 </h5>
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
		                        	类型
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	关联产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	关联服务
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	设置天数
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	状态
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
		                        <td class="footable-visible">[[ valueToText('types',d.type)]]</td>
		                        <td class="footable-visible">[[ valueToText('products',d.product_id)]]</td>
		                        <td class="footable-visible">[[ valueToText('services',d.service_id)]]</td>
		                        <td class="footable-visible">[[d.days]]</td>
		                        <td class="footable-visible" :style='d.status?"color:green":"color:red"'>[[valueToText('status',d.status)]]</td>
		                        <td class="footable-visible" >
		                        		[[d.created_at]]
		                        </td>
		                        <td class="footable-visible text-right">
		                        	<i class='fa fa-spin fa-refresh' v-if='d.operating'></i>
		                        	<template v-else>
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
	                <h4 class="modal-title" id="myModalLabel">消息设置编辑</h4>
	            </div>
	            <div class="modal-body ">
	            	<div class="form-group">
	                  <label>标题</label>
	                  <input type="text" class="form-control" placeholder="Enter ..."  v-model='form.name'>
	                  <label style='color:red' v-if='formErrors["name"]'>[[ formErrors["name"][0] ]]</label>
	                </div>
	                <div class="form-group">
	                  <label>消息类型</label>
	                  <select class="form-control"  v-model='form.type'>
	                  		<option value="">请选择消息类型</option>
	                  		<option v-for='(key,type) in types' :value="key">[[ type ]]</option>
	                  </select>
	                  <label style='color:red' v-if='formErrors["type"]'>[[ formErrors["type"][0] ]]</label>
	                </div>
	                <div class="form-group">
	                  <label>消息模板</label>
	                  <select class="form-control"  v-model='form.tpl_id'>
	                  		<option value="">请选择消息模板</option>
	                  		<option v-for='t in tpls' :value="t.id">[[ t.name ]]</option>
	                  </select>
	                  <label style='color:red' v-if='formErrors["tpl_id"]'>[[ formErrors["tpl_id"][0] ]]</label>
	                </div>
	                <div class="form-group" v-if='form.type == 4 || form.type == 5 || form.type == 7 || form.type == 8'>
	                  <label>关联产品</label>
	                  <select class="form-control"  v-model='form.product_id'>
	                  		<option value="">请选择产品</option>
	                  		<option v-for='p in products' :value="p.id">[[ p.name ]]</option>
	                  </select>
	                  <label style='color:red' v-if='formErrors["product_id"]'>[[ formErrors["product_id"][0] ]]</label>
	                </div>
	                <template v-if='form.type == 13 ||  form.type == 16'>
	                	<div class="form-group" >
		                  <label>天数</label>
		                  <input type="text" class="form-control" placeholder="请输入n的指定天数"  v-model='form.days'>
		                  <label style='color:red' v-if='formErrors["days"]'>[[ formErrors["days"][0] ]]</label>
		                </div>
	                </template>
	                <template v-if='form.type == 1 ||  form.type == 2 ||  form.type == 3'>
	                	<div class="form-group" >
		                  <label>天数</label>
		                  <input type="text" class="form-control" placeholder="请输入n的指定天数"  v-model='form.days'>
		                  <label style='color:red' v-if='formErrors["days"]'>[[ formErrors["days"][0] ]]</label>
		                </div>
		                <div class="form-group" v-if='form.type == 1 ||  form.type == 2 ||  form.type == 3'>
		                  <label>关联服务</label>
		                  <select class="form-control"  v-model='form.service_id'>
		                  		<option value="">请选择服务</option>
		                  		<option v-for='s in services' :value="s.id">[[ s.name ]]</option>
		                  </select>
		                  <label style='color:red' v-if='formErrors["service_id"]'>[[ formErrors["service_id"][0] ]]</label>
		                </div>
	                </template>
	                <div class="form-group">
	                  <label>状态</label>
	                  <select class="form-control"  v-model='form.status'>
	                  		<option v-for='(key, s) in status'  :value="key">[[ s ]]</option>
	                  </select>
	                  <label style='color:red' v-if='formErrors["status"]'>[[ formErrors["status"][0] ]]</label>
	                  <label>注：当选择启用后，点击保存当前设置，其他相同设置状态将被停用。</label>
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
</div>
<script type="text/javascript">
	new Vue({
		el: '#main-container',
		data: {
			list: [],
			search: {
				page: 1
			},
			readySearch: {
				type: '',
				tpl_id: '',
				product_id: '',
				service_id: '',
				status: ''
			},
			form: {
				id: null,
				name: null,
				type: '',
				tpl_id: '',
				product_id: '',
				service_id: '',
				days: null,
				status: ''
			},
			formErrors: {},
			tel: '',
			loading: false,
			submiting: false,
			checkData: null,
			products: {!! $products !!},
			tpls: {!! $tpls !!},
			services: {!! $services !!},
			types: {!! $types !!},
			status: {!! $status !!}
		},
		created: function(){
			this.doGetList();
		},
		methods: {
			// 获取列表数据
			doGetList: function(){
				var _this = this;
				$.ajax({
					url: "{{ url('admin/alidayuSendSetting')}}",
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
							url: "{{ url('admin/alidayuSendSetting/delete')}}",
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
							error: function(e){
								if(e.status == 400){
									appAlert({
										msg: e.responseJSON.message
									})
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
				this.form = {
					id: null,
					name: null,
					type: '',
					tpl_id: '',
					product_id: '',
					service_id: '',
					days: null,
					status: 0
				}
				$("#modal-form").modal({backdrop: 'static', keyboard: false});
			},
			// 修改modal
			doEdit:function(d){
				this.formErrors = {};
				this.form = {
						id: d.id,
						name:  d.name,
						type:  d.type,
						tpl_id:  d.tpl_id,
						product_id:  d.product_id,
						service_id:  d.service_id,
						days:  d.days,
						status:  d.status
					}
				$("#modal-form").modal({backdrop: 'static', keyboard: false});
			},
			// 提交数据
			doSubmit: function(){
				var _this = this;
				$.ajax({
					url: _this.form.id?"{{ url('admin/alidayuSendSetting/update')}}":"{{ url('admin/alidayuSendSetting/store')}}",
					type: 'post',
					dateType: 'json',
					data:_this.form,
					beforeSend: function(){
						_this.submiting = true;
					},
					success: function (json) {
						_this.doGetList();
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
			// 检索
			doSearch:function(){
				for(var i in this.readySearch){
					this.search[i] = this.readySearch[i];
				}
				this.doChangePage(1);
			},
			// 字段转换文本显示
			valueToText:function(type, value){
				var data =	eval('this.'+type);
				if (type == 'types' || type == 'status') {
					if (typeof data[value] !== 'undefined'){
						return data[value];
					}
				}else{
					for (var i in data) {
						if (data[i].id == value){
							return data[i].name;
						}
					}
				}
				return 'Null';
			}
		}
	})
</script>
@endsection



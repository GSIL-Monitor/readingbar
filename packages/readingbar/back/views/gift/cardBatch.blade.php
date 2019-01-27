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
<div class="wrapper wrapper-content animated fadeInRight" id="batchesList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  {{ trans('books.list_title') }} </h5>
                        <div class="ibox-tools">
                        	<a :href="a.create" class="btn btn-primary btn-xs" ><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                        	<a href="javascript:void(0)" v-on:click="doDelete()" class="btn btn-primary btn-xs"><i class="fa fa-trash"></i>   {{ trans('common.delete') }}</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th><input type="checkbox" :checked="(selected.length==batches.data.length)" name="selectedAll" v-on:click="selectedAll()"></th>
		                        <th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	批次
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	关联产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	价格
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	押金
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	描述
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	过期日期
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
		                    <tr class="footable-even" style="display: table-row;" v-for="b in batches.data">
		                        <td class="footable-visible footable-first-column"><input v-model="selected" type="checkbox" name="selected" :value="b.id"></td>
		                        <td class="footable-visible">[[b.id]]</td>
		                        <td class="footable-visible">[[b.name]]</td>
		                        <td class="footable-visible">[[b.product_name]]</td>
		                        <td class="footable-visible">[[b.price]]</td>
		                        <td class="footable-visible">[[b.deposit]]</td>
		                        <td class="footable-visible">[[b.desc]]</td>
		                        <td class="footable-visible">[[b.status]]</td>
		                        <td class="footable-visible">[[b.expired]]</td>
		                        <td class="footable-visible">[[b.created_at]]</td>
		                        <td class="footable-visible">[[b.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" :href="b.edit">编辑</a>
		                        	<a class="btn btn-primary" href="javascript:void(0)" v-on:click="showActiveModal(b)">激活礼品卡</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="batches && batches.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="batches.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in batches.last_page" v-if="Math.abs(batches.current_page-(p+1))<=3">
							    			<li v-if="batches.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="batches.current_page < batches.last_page" v-on:click="doChangePage(batches.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	<!-- 激活礼品卡Modal -->
        <div class="modal inmodal" id="ActiveModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
		   <div class="modal-dialog"> 
		    <div class="modal-content animated bounceInRight"> 
		     <div class="modal-header"> 
		      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
		     
		      <h4 class="modal-title">礼品卡激活</h4> 
		     </div> 
		     <div class="modal-body"> 
		     		<form id="FTForm">
					      <div class="input-daterange input-group" id="datepicker" style="margin:0 auto;">
			                  <input type="text" v-model="activeCard.from" class="input-sm form-control" name="from" value=""/>
			                  <span class="input-group-addon">to</span>
			                  <input type="text" v-model="activeCard.to" class="input-sm form-control" name="to" value="" />
			        	  </div>
		        	</form>
		     </div> 
		     <div class="modal-footer"> 
		      <button type="button" class="btn btn-white" data-dismiss="modal" v-on:click="doCancelFTForm()">取消</button> 
		      <button type="button" class="btn btn-primary" v-on:click="doActiveCards()">确认</button> 
		     </div> 
		    </div> 
		   </div> 
		  </div>
	<!-- /激活礼品卡Modal -->
</div>
<script type="text/javascript">
var batchesList=new Vue({
	el:"#batchesList",
	data:{
		batches:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false
		},
		a:{
			edit:"{{url('admin/gift/cardBatch/edit')}}",
			create:"{{url('admin/gift/cardBatch/form')}}"
		},
		selected:[],
		alert:null,
		activeCard:{
			ajaxStatus:false
		}
	},
	methods:{
		//获取批次数据
		doGetbatches:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/gift/cardBatch/getBatches') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.batches=json;
					_this.search.ajaxStatus=false;
				},
				error:function(){
					_this.search.ajaxStatus=false;
				}
			});
		},
		//选择所有复选框
		selectedAll:function(){
			if(this.selected.length==this.batches.data.length){
				this.selected=[];
			}else{
				s=[];
				for(i in this.batches.data){
					s[i]=this.batches.data[i].id;
				}
				this.selected=s;
			}
		},
		//删除按钮
		doDelete:function(){
			if(confirm('是否确认删除！')){
				var _this=this;
				$.ajax({
					url:"{{ url('admin/api/gift/cardBatch/delete') }}",
					data:{selected:_this.selected},
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doAlert('success',json.success);
							_this.doGetbatches();
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
			this.doGetbatches();
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
		//显示激活礼品卡的modal
		showActiveModal:function(b){
			this.activeCard.batch_id=b.id;
			$('#ActiveModal').modal({backdrop: 'static', keyboard: false});
		},
		doActiveCards:function(){
			var _this=this;
			if(_this.activeCard.ajaxStatus){
				return;
			}else{
				_this.activeCard.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/gift/cardBatch/activeCards') }}",
				data:_this.activeCard,
				dataType:"json",
				type:"POST",
				success:function(json){
					if(json.status){
						$('#ActiveModal').modal('hide');
						alert(json.success);
					}else{
						alert(json.error);
					}
					_this.activeCard.ajaxStatus=false;
				},
				error:function(){
					_this.activeCard.ajaxStatus=false;
				}
			});
		}
	}
});
batchesList.doGetbatches();
</script>
@endsection



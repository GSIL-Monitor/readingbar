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
<div class="wrapper wrapper-content animated fadeInRight" id="cardsList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<!-- 搜索 -->
	 <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>条件搜索</h5>
                    </div>
                    <form class="ibox-content form-inline" onsubmit="return false">
                    	  <select v-model="searchReady.batch_id" class="form-control">
                    	  		<option selected value=''>批次</option>
                          		<option v-for='b in batches' :value='b.id'>[[ b.name ]]</option>
                          </select>
                          <select v-model="searchReady.active_status" class="form-control">
                          		<option value=''>卡激活状态</option>
                          		<option value='1'>未激活</option>
                          		<option value='2'>已激活</option>
                          </select>   
                          <select v-model="searchReady.use_status" class="form-control">
                          		<option value=''>卡使用状态</option>
                          		<option value='1'>未使用</option>
                          		<option value='2'>已使用</option>
                          </select>   
                          <div class="input-daterange input-group" id="datepicker" style="margin:0 auto;">
			                  <input class="input-sm form-control" name="from" value="" type="text" placeholder='卡段' v-model='searchReady.from'>
			                  <span class="input-group-addon">to</span>
			                  <input class="input-sm form-control" name="to" value="" type="text" placeholder="卡段" v-model='searchReady.to'>
			        	  </div>
                          <button v-on:click="doSearch()" class="btn btn-white">搜索</button>
                    </form>
                </div>
            </div>
    </div>
	<!-- /搜索 -->
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">卡号</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	批次
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	关联产品
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	接收人
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	接收人联系方式
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	礼品寄送地址
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	礼品发放状态
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	备注
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
		                    <tr class="footable-even" style="display: table-row;" v-for="c in cards.data">
		                        <td class="footable-visible">[[c.card_id]]</td>
		                        <td class="footable-visible">[[c.batch_name]]</td>
		                        <td class="footable-visible">[[c.product_name]]</td>
		                        <td class="footable-visible">[[c.deliver_to]]</td>
		                        <td class="footable-visible">[[c.phone]]</td>
		                        <td class="footable-visible">[[c.address]]</td>
		                        <td class="footable-visible">[[c.sent]]</td>
		                        <td class="footable-visible">[[c.memo]]</td>
		                        <td class="footable-visible">[[c.created_at]]</td>
		                        <td class="footable-visible">[[c.updated_at]]</td>
		                        <td class="footable-visible text-right">
		                        	<a v-if='c.sendStatus' class="btn btn-primary" href="javascript:void(0)" v-on:click="showSentModal(c)">发送礼品</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="cards && cards.last_page>1">
		                    <tr>
		                        <td colspan="12" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="cards.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in cards.last_page" v-if="Math.abs(cards.current_page-(p+1))<=3">
							    			<li v-if="cards.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="cards.current_page < cards.last_page" v-on:click="doChangePage(cards.last_page)"><a>»</a></li>
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
        <div class="modal inmodal" id="SentModal" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
		   <div class="modal-dialog"> 
		    <div class="modal-content animated bounceInRight"> 
		     <div class="modal-header"> 
		      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
		     
		      <h4 class="modal-title">礼品发送</h4> 
		     </div> 
		     <div class="modal-body"> 
		     		<textarea rows="" placeholder="礼品发送备注信息" v-model="sentCard.memo" cols="" class="input-sm form-control"></textarea>
		     </div> 
		     <div class="modal-footer"> 
		      <button type="button" class="btn btn-white" data-dismiss="modal" >取消</button> 
		      <button type="button" class="btn btn-primary" v-on:click="doSent()">确认</button> 
		     </div> 
		    </div> 
		   </div> 
		  </div>
	<!-- /激活礼品卡Modal -->
</div>
<script type="text/javascript">
var cardsList=new Vue({
	el:"#cardsList",
	data:{
		cards:null,
		search:{
			page:1,
			limit:10,
			ajaxStatus:false,
			use_status:2,
			active_status:2,
		},
		batches:{!! $batches !!},
		searchReady:{
			use_status:2,
			active_status:2
		},
		sentCard:null
	},
	methods:{
		//获取批次数据
		doGetCards:function(){
			var _this=this;
			if(_this.search.ajaxStatus){
				return;
			}else{
				_this.search.ajaxStatus=true;
			}
			$.ajax({
				url:"{{ url('admin/api/gift/cards/getCards') }}",
				data:_this.search,
				dataType:"json",
				success:function(json){
					_this.cards=json;
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
			this.doGetCards();
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
		//显示发送礼品modal
		showSentModal:function(c){
			this.sentCard={
					card_id:c.card_id,
					memo:c.memo,
					ajaxStatus:false
				};
			$('#SentModal').modal({backdrop: 'static', keyboard: false});
		},
		//确认发送礼品
		doSent:function(){
			var _this=this;
			if(_this.sentCard && !_this.sentCard.ajaxStatus){
				_this.sentCard.statusAjax=true;
				$.ajax({
					url:"{{ url('admin/api/gift/cards/setSent') }}",
					data:_this.sentCard,
					dataType:"json",
					type:"POST",
					success:function(json){
						if(json.status){
							_this.doGetCards();
							$('#SentModal').modal('hide');
						}else{
							alert(json.error);
						}
						_this.sentCard.ajaxStatus=false;
					},
					error:function(){
						_this.sentCard.ajaxStatus=false;
					}
				});
			}
		},
		doSearch:function(){
			if(this.searchReady.active_status){
				this.search.active_status=this.searchReady.active_status;
			}else{
				this.search.active_status=null;
			}
			if(this.searchReady.use_status){
				this.search.use_status=this.searchReady.use_status;
			}else{
				this.search.use_status=null;
			}
			if(this.searchReady.from){
				this.search.from=this.searchReady.from;
			}else{
				this.search.from=null;
			}
			if(this.searchReady.to){
				this.search.to=this.searchReady.to;
			}else{
				this.search.to=null;
			}
			if(this.searchReady.batch_id){
				this.search.batch_id=this.searchReady.batch_id;
			}else{
				this.search.batch_id=null;
			}
			this.doGetCards();
		}
	}
});
cardsList.doGetCards();
</script>
@endsection



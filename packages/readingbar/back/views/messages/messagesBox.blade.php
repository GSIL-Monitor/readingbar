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
<div class="wrapper wrapper-content animated fadeInRight" id="messagesBox">
	<div class="row">
		<div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">
                <h2>
                 		   收件箱
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group pull-right">
                        <button class="btn btn-white btn-sm" v-on:click="doPrePage()"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm" v-on:click="doNextPage()"><i class="fa fa-arrow-right"></i></button>

                    </div>
                    <button class="btn btn-white btn-sm"   v-on:click="checkAll()"  data-toggle="tooltip" data-placement="top" title="全选">全选</button>
                   <button class="btn btn-white btn-sm" v-on:click="doDeleteMessages()" data-toggle="tooltip" data-placement="top" title="删除">删除 </button>
				   
				   <button class="btn btn-white btn-sm"   v-on:click="hasRed()"  data-toggle="tooltip" data-placement="top" title="标记已读">标记已读</button>
                </div>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>
	                <tr class="unread" v-for="m in messages.data">
	                    <td >
	                        <input type="checkbox" v-model="deleteMessages" name="selected" class="i-checks" value="[[m.id]]">
	                    </td>
	                    <td class="col-md-1">[[m.sender_name]]</td>
	                    <td class="col-md-1">
	                    	<template v-for="sa in m.star_accounts">
	                    		[[ sa.star_account ]]<br>
	                    	</template>
	                    </td>
	                    <td class="mail-subject">[[m.content]]</td>
	                    <td class="text-right mail-date col-md-2">[[m.created_at]]</td>
	                    <td class="text-right col-md-2"><a :href="'{{url('admin/messagesBox')}}/'+m.id+'/detail'">查看/回复<front v-if="m.unread>0" style="color:red">([[m.unread]])</front></a></td>
	                </tr>
                </tbody>
                </table>


                </div>
            </div>
	</div>
</div>
<script type="text/javascript">
var messagesBox=new Vue({
	el:"#messagesBox",
	data:{
		messages:null,
		search:{
			page:1,
			limit:10,
		},
		deleteMessages:[],
		ajaxUrls:{
			getMessages:"{{url('admin/api/messagesBox/getMessages')}}",
			deleteMessages:"{{url('admin/api/messagesBox/deleteMessages')}}",
			hasRed:"{{url('admin/api/messagesBox/hasRed')}}"
		},
		ajaxStatus:false
	},
	methods:{
		//获取数据
		doGetMessages:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return ;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxUrls.getMessages,	
				dataType:"json",
				data:_this.search,
				success:function(json){
					_this.deleteMessages=[];
					if(json.status){
						_this.messages=json;
					}else{
						alert(json.error);
					}
					_this.ajaxStatus=false;
				}	
			});
		},
		//删除数据
		doDeleteMessages:function(){
			var _this=this;
			if(!confirm('是否要删除？')){
				return ;
			}
			if(_this.ajaxStatus){
				return ;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxUrls.deleteMessages,	
				dataType:"json",
				data:{selected:_this.deleteMessages},
				success:function(json){
					_this.ajaxStatus=false;
					if(json.status){
						_this.doGetMessages();
						alert(json.success);
					}else{
						alert(json.error);
					}
				},
				error:function(){
					_this.ajaxStatus=false;
				}	
			});
		},
		//上一页
		doPrePage:function(){
			if(this.search.page>1){
				this.search.page--;
				this.doGetMessages();
			}
		},
		//下一页
		doNextPage:function(){
			if(this.search.page<this.messages.last_page){
				this.search.page++;
				this.doGetMessages();
			}
		},
		checkAll: function (){
			$('input[name=selected]').click();
		},
		hasRed: function () {
			var _this=this;
			if(!confirm('是否标记位已读？')){
				return ;
			}
			if(_this.ajaxStatus){
				return ;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxUrls.hasRed,	
				dataType:"json",
				data:{selected:_this.deleteMessages},
				success:function(json){
					_this.ajaxStatus=false;
					if(json.status){
						_this.doGetMessages();
						alert(json.success);
					}else{
						alert(json.error);
					}
				},
				error:function(){
					_this.ajaxStatus=false;
				}	
			});
		}
	}
});
messagesBox.doGetMessages();
</script>
@endsection



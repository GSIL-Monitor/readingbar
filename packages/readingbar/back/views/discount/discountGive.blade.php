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
<div class="wrapper wrapper-content animated fadeInRight" id="main">
	<div class="row">
		<div class="col-lg-12">
                  <div class="ibox float-e-margins">
			            <div class="ibox-content">
							<div class='row''>
								<div class='col-md-4'>
									<select class='form-control' v-model='give.search_type'  id="search_type">
										<option value=''>请选择用户群组</option>
										@foreach($search_types as $key=>$value)
											<option value='{{ $key }}'>{{ $value }}</option>
										@endforeach
									</select>
								</div>
								<div class='col-md-4'>
									<select class='form-control' v-model='give.discount_type' id="discount_type">
										<option value=''>请选择赠送的优惠券</option>
										@foreach($discount_types as $value)
											<option value='{{ $value->id }}'>{{ $value->name }}</option>
										@endforeach
									</select>
								</div>
								<div class='col-md-4'>
									<button class='btn btn-primary' v-on:click='doGive()'>赠送</button>
								</div>
							</div>
							<template  v-for='p in progresses' >
								<h5>[[ p.progress_name ]]</h5>
								<div class="progress progress-striped active" >
	                                <div :style="'width:'+p.progress+'%'" aria-valuemax="100" aria-valuemin="0"  aria-valuenow="100" role="progressbar" class="progress-bar progress-bar-[[ p.type ]]">
	                                    <span>[[ p.progress ]]%</span>
	                                </div>
	                            </div>
                            </template>
			            </div>
			     </div>
        </div>
     </div>
</div>

<script>
new Vue({
	 el:"#main",
	 data:{
		give:{
			'search_type':'',
			'discount_type':'',
			'ajax_status':false,
			'progress_id':'',
		},
		progresses:[]
	},
	methods:{
		//赠送优惠券
		doGive:function(){
			var _this=this;
			var progress_id=(new Date()).valueOf();
			if(_this.give.search_type==''){
				alert('请选择会员群体');
				return false;
			}
			if(_this.give.discount_type==''){
				alert('请选择优惠券');
				return false;
			}
			if(_this.give.ajax_status){
				alert('任务正在执行，请不要打断！');
				return false;
			}
			if(!confirm("是否确认赠送“"+$('#discount_type option[value='+_this.give.discount_type+']').text()+"”给“"+$('#search_type option[value='+_this.give.search_type+']').text()+"”？")){
				return false;
			}
			var progress_key=_this.progresses.length;
			_this.progresses.push({
				progress_id:progress_id,
				progress_name:"赠送优惠券“"+$('#discount_type option[value='+_this.give.discount_type+']').text()+"“给“"+$('#search_type option[value='+_this.give.search_type+']').text()+"”",
				progress:0,
				type:'danger'
			});
			_this.give.progress_id=progress_id;
			$.ajax({
				url:"{{ url('admin/DiscountGive/giveDiscount') }}",
				data:_this.give,
				dataType:'json',
				type:"GET",
				beforeSend:function(){
					_this.doGetProgress(progress_key);
					_this.give.ajax_status=true;
				},
				success:function(json){
					if(json.status){
						_this.progresses[progress_key].progress=100;
						_this.progresses[progress_key].type='success';
				   }else{
					    alert(json.error);
				   }
					_this.give.ajax_status=false;
				},
				error:function(){
					_this.give.ajax_status=false;
					_this.progress=100;
				}
			});
		},
		//获取执行进度
		doGetProgress:function(k){
			var _this=this;
			var key=k;
			setInterval(
				function(){
					if(_this.progresses[key].progress<100){
	 					$.ajax({
							url:"{{ url('admin/DiscountGive/getProgress') }}",
							dataType:'json',
							data:{progress_id:_this.progresses[key].progress_id},
							type:"GET",
							success:function(json){
							   if(json.status && _this.progresses[key].progress<100){
								   _this.progresses[key].progress=parseInt(json.progress);
							   }
							},
							error:function(){
							}
						});
					}else{
						_this.progresses[key].type='success';
						if(this){
							clearinterval(this);
						}
					}
				},
				1000
			);
		}
	}
});
</script>
@endsection



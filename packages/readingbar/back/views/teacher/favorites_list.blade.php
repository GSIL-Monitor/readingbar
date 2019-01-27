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
    <div class="row">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>  {{ trans('favorites.mycollection') }}</h5>
                    </div>
                    <form class="ibox-content form-inline"  onsubmit="return false">
                                <div class="form-group">
                                    <input type="text" v-model="search.book_name" placeholder="{{ trans('favorites.book_name') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="search.author" placeholder="{{ trans('favorites.author') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="search.ISBN" placeholder="{{ trans('favorites.isbn') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <button class="btn btn-white"  v-on:click="dosearch()">{{ trans('favorites.search') }}</button>
                                <button class="btn btn-white"  v-on:click="book_search()">{{ trans('favorites.book_search') }}</button>
                    </form>
                </div>
            </div>
    </div>
     <div class="row">
           <template v-for="r in result.data">
            <div class="col-lg-3 book_info" >
                <div class="contact-box center-version" >
                	<a  style="min-height: 250px;" class="info_detail_1">
                        <img alt="image" v-bind:src="r.image" style="max-height: 80px;min-height:80px;max-width:100%;width:auto !important" >
                        <h3 class="m-b-xs"><strong>[[r.book_name]]</strong></h3>
                        <div class="font-bold">[[r.author]]</div>
                        <div>[[r.summary]]</div>
                    </a>
                    <a  style="min-height: 250px;display:none" class="info_detail_2">
                       <div class="text-left">IL:<strong>[[r.IL]]</strong></div>
                       <div class="text-left">BL:<strong>[[r.BL]]</strong></div>
                       <div class="text-left">AR Pts:<strong>[[r.ARPts]]</strong></div>
                       <div class="text-left">AR Quiz Types:<strong>[[r.ARQuizType]]</strong></div>
                       <div class="text-left">Rating:<strong>[[r.rating]]</strong></div>
                    </a>
                    <div class="contact-box-footer">
                        <div class="m-t-xs btn-group">
                            <a class="btn btn-xs btn-white" v-if="!r.favorite" v-on:click="dofavorite($index,r.id)"><i class="fa fa-plus"></i>{{ trans('favorites.collect') }}</a>
                            <a class="btn btn-xs btn-white" v-else v-on:click="dounfavorite($index,r.id)"><i class="fa fa-minus"></i>{{ trans('favorites.cancel_collect') }}</a>
                            <a class="btn btn-xs btn-white" v-else v-on:click="setcomment($index,r)" data-toggle="modal" data-target="#commentModal">{{ trans('favorites.comment') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            </template>

        </div>
    <div>
    	<ul class="pagination" v-if="result && result.total_pages>1">
	    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
    		<template v-for="p in result.total_pages" v-if="Math.abs(result.current_page-(p+1))<=3">
    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
    		</template>
	     	<li v-if="result.current_page < result.total_pages" v-on:click="dochangepage(result.total_pages)"><a>»</a></li>
     	</ul>
     </div>
</div>
<!-- 备注弹出层 -->
<div class="modal inmodal" id="commentModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('favorites.comment') }}</h4> 
     </div> 
     <div class="modal-body"> 
     	<textarea v-model="comment.text" class="form-control" width="100%" height="100px"></textarea>
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('favorites.close') }}</button> 
      <button type="button" class="btn btn-primary" v-on:click="docomment">{{ trans('favorites.save') }}</button> 
     </div> 
    </div> 
   </div> 
  </div>
<!-- /备注弹出层 -->
<script type="text/javascript">
	_booklist=new Vue({
			el:"body",
			data:{
				ajaxurl:"{{url('admin/favorites/myfavorite')}}",
				search:{
					book_name:"",
					author:"",
					ISBN:"",
					page:1,
					limit:8
				},
				result:null,
				comment:{
					book_id:null,
					text:null
				}
			},
			methods:{
				showdata:function(){
					var _this=this;
					$.ajax({
						url:_this.ajaxurl,
						data:_this.search,
						dataType:'json',
						success:function(json){
								_this.result=json;
							}
						});
				},
				dosearch:function(){
					this.showdata();
				},
				dofavorite:function(index,id){
					var _this=this;
					$.ajax({
						url:"{{url('admin/favorites/dofavorite')}}",
						data:{book_id:id},
						dataType:'json',
						success:function(json){
							if(json.status){
								_this.result.data[index].favorite=true;
							}else{
								alert(json.msg);
							}
						}
					});
				},
				dounfavorite:function(index,id){
					var _this=this;
					$.ajax({
						url:"{{url('admin/favorites/dounfavorite')}}",
						data:{book_id:id},
						dataType:'json',
						success:function(json){
							if(json.status){
								_this.result.data[index].favorite=false;
								_this.showdata();
							}else{
								alert(json.msg);
							}
						}
					});
				},
				dochangepage:function(page){
					this.search.page=page;
					this.showdata();
				},
				book_search:function(){
					window.open("{{url('admin/favorites/books_search')}}");
				},
				setcomment:function(index,r){
					this.comment.book_id=r.id;
					this.comment.text=r.comment;
				},
				docomment:function(){
					var _this=this;
					$.ajax({
						url:"{{url('admin/favorites/docomment')}}",
						data:_this.comment,
						dataType:'json',
						success:function(json){
							if(json.status){
								$('#commentModal').modal('hide')
								_this.showdata();
							}else{
								alert(json.msg);
							}
						}
					});
				}
			}
		});
	 _booklist.showdata();
</script>
<script type="text/javascript">
$("body").on("mouseover mouseout",'.book_info',function(event){
	 if(event.type == "mouseover"){
	   $(this).children().find('.info_detail_1').hide();
	   $(this).children().find('.info_detail_2').show();
	 }else if(event.type == "mouseout"){
	   $(this).children().find('.info_detail_1').show();
	   $(this).children().find('.info_detail_2').hide();
	 }
});
</script>
@endsection



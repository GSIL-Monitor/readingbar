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
	<!-- 书籍查询 -->
	<div class="row">
			<div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{ trans('tstudents.read_plan_booksearch')}}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content form-inline" >
                        		<div class="form-group" v-model="">
                        			<select class="form-control">
                        				<option v-on:click="changeSearchType('all')">{{ trans('tstudents.read_plan_allbooks')}}</option>
                        				<option v-on:click="changeSearchType('myfavorites')">{{ trans('tstudents.read_plan_myfavorites')}}</option>
                        			</select>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="search.book_name" placeholder="{{ trans('favorites.book_name') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="search.author" placeholder="{{ trans('favorites.author') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="search.ISBN" placeholder="{{ trans('favorites.isbn') }}" id="exampleInputEmail2" class="form-control" data-form-un="1476083165683.326">
                                </div>
                                <button class="btn btn-white"  v-on:click="dosearch()" data-form-sbm="1476083165683.326" style="margin-bottom: 0px;">{{ trans('favorites.search') }}</button>
                        		<br><br>
                        		<div class="row">
	                        		<template v-for="r in result.data">
							            <div class="col-lg-3 book_info">
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
							                        	<a class="btn btn-xs btn-white" v-on:click="doaddBookIntoPlan(r.id)"><i class="fa fa-plus"></i>{{ trans('tstudents.addBookIntoReadPlan')}}</a>
							                        </div>
							                    </div>
							                </div>
							            </div>
							       </template>
                        	</div>
                        	<div>
						    	<ul class="pagination" v-if="result.total_pages>1">
							    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
						    		<template v-for="p in result.total_pages" v-if="Math.abs(result.current_page-(p+1))<=3">
						    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
						    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
						    		</template>
							     	<li v-if="result.current_page < result.total_pages" v-on:click="dochangepage(result.total_pages)"><a>»</a></li>
						     	</ul>
						   </div>
                        </div>
                    </div>
                </div>
	</div>
		
	<!-- 阅读计划   -->
	<div class="row animated fadeInRight">
	  <div class="col-lg-12">
	    <div class="ibox float-e-margins">
	      <div class="ibox-title">
	        <h5>{{ trans('tstudents.students_readplan')}}</h5>
	        <div class="ibox-tools">
	          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	            <i class="fa fa-wrench"></i>
	          </a>
	          <ul class="dropdown-menu dropdown-user">
	            <li>
	              <a data-toggle="modal" data-target="#newReadPlanModal">{{ trans('tstudents.read_plan_new')}}</a></li>
	            <li v-if="lastPlan.status==-1">
	              <a v-on:click="dosendPlan(lastPlan.id)">{{ trans('tstudents.read_plan_send')}}</a>
	            </li>
	            <li v-if="lastPlan.status==0">
	              <a v-on:click="dobackPlan(lastPlan.id)">{{ trans('tstudents.read_plan_back')}}</a>
	            </li>
	          </ul>
	        </div>
	      </div>
	      <div class="ibox-content inspinia-timeline">
	        
	        <div class="timeline-item" v-for="rp in readPlans">
	          <div class="row">
	            <div class="col-xs-3 date">
	              <i data-toggle="dropdown" class="fa fa-edit" v-if="rp.status==-1"></i>
		          <i class="fa fa-clock-o" v-if="rp.status==0"></i>
	              <i class="fa fa-check-square-o" v-if="rp.status!=-1 && rp.status!=0"></i>	
	              <small class="text-navy">[[ rp.created_at ]]</small>
	              </div>
	            <div class="col-xs-9 content">
	              <p class="m-b-xs">
	               <strong>[[ rp.plan_name ]]</strong>
	              </p>
	              <table class="table table-hover">
					  <tbody>
					    <tr v-for="d in rp.detail">
					      
					      <td class="project-title">
					        <a href="project_detail.html">[[ d.book_name ]]</a>
					        <br>
					        <small>[[ d.created_at ]]</small>
					      </td>
					      <td class="project-actions" v-if="rp.status==-1">
					        <a v-on:click="doremoveBookFromReadPlan(d.id)" class="btn btn-white btn-sm">
					          {{ trans('tstudents.removeBookFromReadPlan') }}
					        </a>
					      </td>
					    </tr>
					  </tbody>
					</table>
	            </div>
	          </div>
	        </div>
	        
	      </div>
	    </div>
	  </div>
	</div>
	
</div>
<!-- 新建阅读计划弹出层 -->
  <div class="modal inmodal" id="newReadPlanModal" tabindex="-1" role="dialog" aria-hidden="true"> 
   <div class="modal-dialog"> 
    <div class="modal-content animated fadeIn"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <i class="fa fa-pencil-square-o modal-icon"></i> 
      <h4 class="modal-title">{{ trans('tstudents.read_plan_new') }}</h4> 
     </div> 
     <div class="modal-body" id="data_5"> 
     	<label>{{ trans('tstudents.read_plan_name') }}</label>
     	<input v-model="newPlan.plan_name" class="form-control">
		
        <label>{{ trans('tstudents.read_plan_from_to') }}</label>
        <div class="input-daterange input-group" id="datepicker">
                  <input type="text" v-model="newPlan.from" class="input-sm form-control" name="start" value=""/>
                  <span class="input-group-addon">to</span>
                  <input type="text" v-model="newPlan.to" class="input-sm form-control" name="end" value="" />
        </div>
       	
     </div> 
     <div class="modal-footer"> 
      <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans('tstudents.close') }}</button> 
      <button v-on:click="donewReadPlan()" type="button" class="btn btn-primary" v-on:click="docomment">{{ trans('tstudents.save') }}</button> 
     </div> 
    </div> 
   </div> 
  </div>  
<!-- /新建阅读计划弹出层 -->
<script type="text/javascript">
var _readPlans=new Vue({
	el:"body",
	data:{
		student_id:{{ $student_id }},
		ajaxurls:{
			readPlans:"{{ url('admin/tstudents/readPlans')}}",
			newReadPlan:"{{ url('admin/tstudents/newReadPlan')}}",
			addBookIntoPlan:"{{ url('admin/tstudents/addBookIntoReadPlan')}}",
			removeBookFromPlan:"{{ url('admin/tstudents/removeBookFromReadPlan')}}",
			sendPlan:"{{ url('admin/tstudents/sendPlan')}}",
			backPlan:"{{ url('admin/tstudents/backPlan')}}",
			allBooksSearch:"{{url('admin/favorites/books_search_result')}}",
			myFavorites:"{{url('admin/favorites/myfavorite')}}",
		},
		lastPlan:{!! $lastPlan !!},
		readPlans:null,
		newPlan:{plan_name:null,from:null,to:null,student_id:{{ $student_id }}},
		//书籍检索
		searchType:"all",
		search:{
			book_name:"",
			author:"",
			ISBN:"",
			page:1,
			limit:4
		},
		result:null
	},
	methods:{
		//获取所有阅读计划
		getReadPlans:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.readPlans,
				type:"GET",
				data:{student_id:_this.student_id},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.readPlans=json.data;
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//新建阅读计划
		donewReadPlan:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.newReadPlan,
				type:"POST",
				data:_this.newPlan,
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.getReadPlans();
						$("#newReadPlanModal").modal('hide');
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//往计划里加入书籍
		doaddBookIntoPlan:function(book_id){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.addBookIntoPlan,
				type:"POST",
				data:{student_id:_this.student_id,book_id:book_id,plan_id:_this.lastPlan.id},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.getReadPlans();
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//移除阅读计划中的书籍
		doremoveBookFromReadPlan:function(did){
			if(!confirm("{{trans('tstudents.removeBookFromReadPlan_comfirm')}}")){
				return false;
			}
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.removeBookFromPlan,
				type:"POST",
				data:{did:did},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.getReadPlans();
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//发送计划给用户确认
		dosendPlan:function(pid){
			var　_this=this;
			$.ajax({
				url:_this.ajaxurls.sendPlan,
				type:"POST",
				data:{plan_id:pid},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.lastPlan.status=0;
						_this.getReadPlans();
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//撤回发送给用户确认的计划
		dobackPlan:function(pid){
			var　_this=this;
			$.ajax({
				url:_this.ajaxurls.backPlan,
				type:"POST",
				data:{plan_id:pid},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.lastPlan.status=-1;
						_this.getReadPlans();
					}else{
						alert(json.msg);
					}
				}
			});
		},
		//书籍检索
		showdata:function(){
			_this=this;
			switch(_this.searchType){
				case 'myfavorites':ajaxurl=_this.ajaxurls.myFavorites;break;
				default:ajaxurl=_this.ajaxurls.allBooksSearch;break;
			}
			$.ajax({
				url:ajaxurl,
				data:_this.search,
				dataType:'json',
				success:function(json){
						_this.result=json;
					}
				});
		},
		changeSearchType:function(type){
			this.searchType=type;
			this.search.page=1;
			this.showdata();
		},
		dosearch:function(){
			this.showdata();
		},
		dochangepage:function(page){
			this.search.page=page;
			this.showdata();
		}
	}
});
_readPlans.getReadPlans();

//日期控件
$('#data_5 .input-daterange').datepicker({
				format:"yyyy-mm-dd",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
});
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



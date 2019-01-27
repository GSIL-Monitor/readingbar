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
<div class="wrapper wrapper-content animated fadeInRight"  id="main">
 	<div class="row">
             <div class="col-lg-12">
	             <div class="ibox">
	                    <div class="ibox-content form-inline">
	             			<input class="datepicker form-control"  readonly name='s_date'>
	             			<button class="btn btn-default"  v-on:click="setDate()">{{ trans('ranking.btns.btn1') }}</button>
	             			<button class="btn btn-default"  v-on:click="addRecord()">{{ trans('ranking.btns.btn2') }}</button>
	             		</div>
	             </div>
             </div>
    </div>
 	<div class="row">
             <div class="col-lg-12">
 				<div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">{{ trans('ranking.tabs.books') }}</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">{{ trans('ranking.tabs.words') }}</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">{{ trans('ranking.tabs.books_improved') }}</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4">{{ trans('ranking.tabs.words_improved') }}</a></li>
<!--                             <li class=""><a data-toggle="tab" href="#tab-3">{{ trans('ranking.tabs.arp') }}</a></li> -->
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                
                                	<table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" >
						                <thead>
						                    <tr>
						                    	<th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.index') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.student') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.grade') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.dob') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.area') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.star_account') }}
						                        </th>
						                        
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.books') }}</th>
						                        
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.award_point') }}
						                        </th>	
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.operation') }}</th>
						                      </tr>
						                </thead>
						                <tbody>
						                    <tr class="footable-even" style="display: table-row;" v-for="r in rs.books">
						                        <td  class="footable-visible"> [[ $index+1 ]]</td>
						                        <td class="footable-visible">[[ r.name ]]</td>
						                        <td class="footable-visible">[[ r.grade ]]</td>
						                        <td class="footable-visible">[[ r.dob ]]</td>
						                        
						                        <td class="footable-visible">[[ r.area ]]</td>
						                        <td class="footable-visible">[[ r.star_account ]]</td>
						                        <td class="footable-visible">[[ r.books ]]</td>
						                        <td class="footable-visible">[[ r.award_point ]]</td>
						                        <td class="footable-visible">
						                        	<a class="btn btn-primary"  v-on:click='doAwardPoint(r.rid)'>{{ trans('ranking.btns.award') }}</a>
						                        	<a class="btn btn-primary"  v-on:click='doDelete(r.rid)'>{{ trans('ranking.btns.delete') }}</a>
						                        </td>
						                    </tr>
						                </tbody>
						            </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" >
						                <thead>
						                    <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.index') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.student') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.grade') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.dob') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.area') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.star_account') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.words') }}</th>
						                        
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.award_point') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.operation') }}</th>
						                      </tr>
						                </thead>
						                <tbody>
						                    <tr class="footable-even" style="display: table-row;" v-for="r in rs.words">
						                    	<td  class="footable-visible"> [[ $index+1 ]]</td>
						                        <td class="footable-visible">[[ r.name ]]</td>
						                        <td class="footable-visible">[[ r.grade ]]</td>
						                        <td class="footable-visible">[[ r.dob ]]</td>
						                        <td class="footable-visible">[[ r.area ]]</td>
						                        <td class="footable-visible">[[ r.star_account ]]</td>
						                        <td class="footable-visible">[[ r.words ]]</td>
						                        <td class="footable-visible">[[ r.award_point ]]</td>
						                        <td class="footable-visible">
						                        	<a class="btn btn-primary"  v-on:click='doAwardPoint(r.rid)'>{{ trans('ranking.btns.award') }}</a>
						                        	<a class="btn btn-primary"  v-on:click='doDelete(r.rid)'>{{ trans('ranking.btns.delete') }}</a>
						                        </td>
						                    </tr>
						                </tbody>
						            </table>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" >
						                <thead>
						                    <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.index') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.student') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.grade') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.dob') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.area') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.star_account') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.books_improved') }}</th>
						                        
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.award_point') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.operation') }}</th>
						                      </tr>
						                </thead>
						                <tbody>
						                    <tr class="footable-even" style="display: table-row;" v-for="r in rs.books_improved">
						                    	<td  class="footable-visible"> [[ $index+1 ]]</td>
						                        <td class="footable-visible">[[ r.name ]]</td>
						                        <td class="footable-visible">[[ r.grade ]]</td>
						                        <td class="footable-visible">[[ r.dob ]]</td>
						                        <td class="footable-visible">[[ r.area ]]</td>
						                        <td class="footable-visible">[[ r.star_account ]]</td>
						                        <td class="footable-visible">[[ r.books_improved ]]</td>
						                        <td class="footable-visible">[[ r.award_point ]]</td>
						                        <td class="footable-visible">
						                        	<a class="btn btn-primary"  v-on:click='doAwardPoint(r.rid)'>{{ trans('ranking.btns.award') }}</a>
						                        	<a class="btn btn-primary"  v-on:click='doDelete(r.rid)'>{{ trans('ranking.btns.delete') }}</a>
						                        </td>
						                    </tr>
						                </tbody>
						            </table>
                                </div>
                            </div>
                            <!-- /tab -->
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" >
						                <thead>
						                    <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.index') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.student') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.grade') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.dob') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.area') }}
						                        </th>
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.star_account') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.words_improved') }}</th>
						                        
						                        <th data-hide="phone" class="footable-visible footable-sortable">
						                        	{{ trans('ranking.columns.award_point') }}
						                        </th>
						                        <th class="footable-visible footable-sortable">{{ trans('ranking.columns.operation') }}</th>
						                      </tr>
						                </thead>
						                <tbody>
						                    <tr class="footable-even" style="display: table-row;" v-for="r in rs.words_improved">
						                    	<td  class="footable-visible"> [[ $index+1 ]]</td>
						                        <td class="footable-visible">[[ r.name ]]</td>
						                        <td class="footable-visible">[[ r.grade ]]</td>
						                        <td class="footable-visible">[[ r.dob ]]</td>
						                        <td class="footable-visible">[[ r.area ]]</td>
						                        <td class="footable-visible">[[ r.star_account ]]</td>
						                        <td class="footable-visible">[[ r.words_improved ]]</td>
						                        <td class="footable-visible">[[ r.award_point ]]</td>
						                        <td class="footable-visible">
						                        	<a class="btn btn-primary"  v-on:click='doAwardPoint(r.rid)'>{{ trans('ranking.btns.award') }}</a>
						                        	<a class="btn btn-primary"  v-on:click='doDelete(r.rid)'>{{ trans('ranking.btns.delete') }}</a>
						                        </td>
						                    </tr>
						                </tbody>
						            </table>
                                </div>
                            </div>
                            <!-- /tab -->
                        </div>


                    </div>
 		</div>
 	</div>
 	
 <!-- 新增 -->     
	  <div class="modal inmodal" id="AddModal" tabindex="-1" role="dialog" aria-hidden="true"> 
	   <div class="modal-dialog"> 
	    <div class="modal-content animated fadeIn"> 
	     <div class="modal-header"> 
	      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
	      <i class="fa fa-pencil-square-o modal-icon"></i> 
	      <h4 class="modal-title">{{ trans('ranking.btns.btn2') }}</h4> 
	     </div> 
	     <div class="modal-body"> 
	     		
	     		<div class="input-group clockpicker" data-autoclose="true">
	     					<span class="input-group-addon" onclick="newCaptcha()">
                                    <span class="fa fa-search"></span>
                           </span>
                           <input class="form-control"   v-model='star_account'  v-on:change="getStudents()"  placeholder="{{ trans('ranking.form.star_account') }}" >
                </div>
	     		<select class="form-control" v-model='form.student_id'>
	     				<option value='' selected>{{ trans('ranking.form.student') }}</option>
	     				<option v-for='s in students' :value='s.id'>[[ s.name ]]</option>
	     		</select>
	     	
	     		<div class="input-group clockpicker" data-autoclose="true">
                           <span class="input-group-addon" onclick="newCaptcha()">
                                    <select  v-model='form.type' style="border:0px" v-model='form.type'>
                                    		@foreach(trans('ranking.form.type') as $k=>$v)
                                    			<option value='{{ $k }}'>{{ $v }}</option>
                                    		@endforeach
						     		</select>
                           </span>
                           <input class="form-control"   v-model='form.type_v'  placeholder="{{ trans('ranking.form.type_v') }}">
                </div>
	     		<input class="datepicker form-control"  readonly v-model='form.date'  placeholder="{{ trans('ranking.form.date') }}">
	     </div> 
	     <div class="modal-footer"> 
	      <button type="button" class="btn btn-white" data-dismiss="modal">取消</button> 
	      <button type="button" class="btn btn-primary"  v-on:click="doSubmit()">确认</button> 
	     </div> 
	    </div> 
	   </div> 
	  </div> 
	<!-- /新增 -->
</div>
<script type="text/javascript">
	var main=new Vue({
		el:"#main",
		data:{
			date:null,
			rs:[],
			students:null,
			form:{
				student_id:null,
				type_v:null,
				type:'books',
				date:null
			},
			star_account:''
		},
		created:function(){
			this.getStudents();
		},
		methods:{
			setDate:function(){
				this.date=$('input[name=s_date]').val();
				this.form.date=$('input[name=s_date]').val();
				this.getRs();
			},
			getRs:function(){
				var _this=this;
				$.ajax({
						url:"{{url('admin/ranking/getRs')}}",
						type:"GET",
						dataType:"json",
						data:{date:_this.date},
						success:function(json){
							_this.rs=json;
						}
				});
			},
			addRecord:function(){
				$("#AddModal").modal('show');
			},
			getStudents:function(){
				var _this=this;
				$.ajax({
						url:"{{url('admin/ranking/getStudents')}}",
						type:"GET",
						dataType:"json",
						data:{star_account:_this.star_account},
						success:function(json){
							_this.students=json;
						}
				});
			},
			doSubmit:function(){
				var _this=this;
				$("#AddModal").modal('hide');
				$.ajax({
						url:"{{url('admin/ranking/create')}}",
						type:"Post",
						dataType:"json",
						data:_this.form,
						success:function(json){
							if(json.status){
								alert(json.success);
								_this.getRs();
							}else{
								alert(json.error);
							}
						}
				});
			},
			//进入排行授予积分
			doAwardPoint:function(rid){
				if(confirm("{{ trans('ranking.confirm.award_point') }}")){
					var _this=this;
					$.ajax({
						url:"{{url('admin/ranking/awardPoint')}}",
						type:"Post",
						dataType:"json",
						data:{id:rid},
						success:function(json){
							if(json.status){
								alert(json.success);
								_this.getRs();
							}else{
								alert(json.error);
							}
						}
					});
				}
			},
			//删除记录
			doDelete:function(rid){
				if(confirm("{{ trans('ranking.confirm.delete') }}")){
					var _this=this;
					$.ajax({
						url:"{{url('admin/ranking/delete')}}",
						type:"Post",
						dataType:"json",
						data:{id:rid},
						success:function(json){
							if(json.status){
								alert(json.success);
								_this.getRs();
							}else{
								alert(json.error);
							}
						}
					});
				}
			}
		}

	});
</script>
<script type="text/javascript">
//日期控件
$('.datepicker').datepicker({
				format:"yyyy-mm",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                startView:1,
                minViewMode:1,
});
</script>
@endsection



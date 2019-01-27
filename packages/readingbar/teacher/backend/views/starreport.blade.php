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
	
    <div class="row" v-if="type=='list'">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5><i class="fa fa-file-text-o"></i>{{ trans('starreport.head_title') }}</h5>
                         <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a v-on:click="setType('create')">{{ trans('starreport.ops_create_report') }}</a>
                                    </li>
                                </ul>
                         </div>
                    </div>
                    <div class="ibox-content form-inline">
                                <div class="form-group">
                                   <input v-model='search.student_name' v-on:keyup="doSearch()" value="{{ $student_name }}" class="form-control" placeholder="{{ trans('starreport.column_student_name') }}">
                                </div>
                    </div>
                </div>
            </div>
    </div>
	<div class="row" v-if="type=='list'">
		
		<div class="col-lg-12">
	    <div class="ibox">
	        <div class="ibox-content">
	            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
	                <thead>
	                    <tr>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('starreport.column_student_name') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('starreport.column_report_id') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('starreport.column_test_date') }}
	                        </th>
	                        <th data-hide="phone" class="footable-visible footable-sortable">
	                        	{{ trans('starreport.column_time_used') }}
	                        </th>
	                        <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">{{ trans('starreport.ops') }}</th></tr>
	                </thead>
	                <tbody>
		                <template v-for="r in result.data">
		                    <tr class="footable-even" style="display: table-row;">
		                        <td class="footable-visible">[[r.student_name]]</td>
		                        <td class="footable-visible">[[r.report_id ]]</td>
		                        <td class="footable-visible">[[r.test_date ]]</td>
		                        <td class="footable-visible">[[r.time_used ]]</td>
		                        <td class="text-right footable-visible footable-last-column">
		                            <div class="form-inline">
		                            	<button v-on:click="setEditForm('edit',r)" class="btn btn-primary">{{trans('starreport.ops_edit')}}</button>
		                            	<button v-on:click="doDeleteReport(r.id)" class="btn btn-primary">{{trans('starreport.ops_delete')}}</button>
		                            </div>
		                        </td>
		                    </tr>
		                </template>
	                </tbody>
	                <tfoot v-if="result && result.total_pages>1">
	                    <tr>
	                        <td colspan="5" class="footable-visible">
	                            <ul class="pagination pull-right" >
							    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
						    		<template v-for="p in result.total_pages" v-if="Math.abs(result.current_page-(p+1))<=3">
						    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
						    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
						    		</template>
							     	<li v-if="result.current_page < result.total_pages" v-on:click="dochangepage(result.total_pages)"><a>»</a></li>
						     	</ul>
	                        </td>
	                    </tr>
	                </tfoot>
	            </table>
	        </div>
	    </div>
		</div>
	</div>
	<!-- 报告编辑  -->
	<div class="row" v-if="type=='edit'">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5 v-if="type=='create'"><i class="fa fa-file-text-o"></i>{{ trans('starreport.text_create_report') }}</h5>  
                    	 <h5 v-if="type=='edit'"><i class="fa fa-file-text-o"></i>{{ trans('starreport.text_edit_report') }}</h5> 
                    </div>
                    <div class="ibox-content">
                            <form method="get" class="form-horizontal" enctype="multipart/form-data" action="{{ url('admin/starreport/editReport') }}">
                            	<div class="form-group" >
                            		<label class="col-sm-2 control-label">{{ trans('starreport.column_student_name') }}</label>
									<div class="col-sm-10">
										<input v-model="editReport.student_name" name="student_name" disabled type="text" class="form-control">
										<input v-model="editReport.student_id" name="student_id" type="hidden" class="form-control">
										<input v-model="editReport.id" name="id" type="hidden" class="form-control">
										<span class="help-block m-b-none" style="color:red" v-if='inputErrors.student_id'>[[inputErrors.student_id]]</span>
									</div>
                                	
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                	<label class="col-sm-2 control-label">{{ trans('starreport.column_report_id') }}</label>
									<div class="col-sm-10"><input v-model="editReport.report_id" name="report_id" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.report_id'>[[inputErrors.report_id]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_test_date') }}</label>
									<div class="col-sm-10"><input v-model="editReport.test_date" name="test_date" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.test_date'>[[inputErrors.test_date]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_time_used') }}</label>
									<div class="col-sm-10"><input v-model="editReport.time_used" name="time_used" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.time_used'>[[inputErrors.time_used]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_grade') }}</label>
									<div class="col-sm-10"><input v-model="editReport.grade" name="grade" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.grade'>[[inputErrors.grade]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_ss') }}</label>
									<div class="col-sm-10"><input v-model="editReport.ss" name="ss" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.ss'>[[inputErrors.ss]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pr') }}</label>
									<div class="col-sm-10"><input v-model="editReport.pr" name="pr" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.pr'>[[inputErrors.pr]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_estor') }}</label>
									<div class="col-sm-10"><input v-model="editReport.estor" name="estor" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.estor'>[[inputErrors.estor]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_ge') }}</label>
									<div class="col-sm-10"><input v-model="editReport.ge" name="ge" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.ge'>[[inputErrors.ge]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_irl') }}</label>
									<div class="col-sm-10"><input v-model="editReport.irl" name="irl" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.irl'>[[inputErrors.irl]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_zpd') }}</label>
									<div class="col-sm-10"><input v-model="editReport.zpd" name="zpd" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.zpd'>[[inputErrors.zpd]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_wks') }}</label>
									<div class="col-sm-10"><input v-model="editReport.wks" name="wks" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.wks'>[[inputErrors.wks]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_cscm') }}</label>
									<div class="col-sm-10"><input v-model="editReport.cscm" name="cscm" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.cscm'>[[inputErrors.cscm]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_alt') }}</label>
									<div class="col-sm-10"><input v-model="editReport.alt" name="alt" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.alt'>[[inputErrors.alt]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_uac') }}</label>
									<div class="col-sm-10"><input v-model="editReport.uac" name="uac" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.uac'>[[inputErrors.uac]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_aaet') }}</label>
									<div class="col-sm-10"><input v-model="editReport.aaet" name="aaet" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.aaet'>[[inputErrors.aaet]]</span></div>
                                </div>
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_result') }}</label> -->
<!-- 									<div class="col-sm-10"> -->
<!-- 									<input v-model="editReport.result" type="text" name="result" class="form-control"> -->
<!--                                 	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.result'>[[inputErrors.result]]</span> -->
<!--                                 	</div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_explain') }}</label> -->
<!-- 									<div class="col-sm-10"> -->
<!-- 									<input v-model="editReport.explain" name="explain" type="text" class="form-control"> -->
<!--                                 	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.explain'>[[inputErrors.explain]]</span> -->
<!--                                 	</div> -->
<!--                                 </div> -->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pdf_en') }}</label>
									<div class="col-sm-10">
									<input v-model="editReport.pdf_en" readonly type="text" name="pdf_en" class="form-control file-set" needType="pdf">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.pdf_en'>[[inputErrors.pdf_en]]</span>
                                	</div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pdf_zh') }}</label>
									<div class="col-sm-10">
									<input v-model="editReport.pdf_zh" readonly type="text" name="pdf_zh" class="form-control file-set" needType="pdf">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.pdf_zh'>[[inputErrors.pdf_zh]]</span>
                                	</div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" v-on:click="setType('list')">{{ trans('starreport.ops_cancel') }}</a>
                                        <button class="btn btn-primary" >{{ trans('starreport.ops_save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
    </div>
    <!-- 报告编辑  -->
    <!-- 创建报告  -->
	<div class="row" v-if="type=='create'">
             <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                         <h5 v-if="type=='create'"><i class="fa fa-file-text-o"></i>{{ trans('starreport.text_create_report') }}</h5>  
                    	 <h5 v-if="type=='edit'"><i class="fa fa-file-text-o"></i>{{ trans('starreport.text_edit_report') }}</h5> 
                    </div>
                    <div class="ibox-content">
                            <form method="get" class="form-horizontal" enctype="multipart/form-data" action="{{ url('admin/starreport/createReport') }}">
                            	<div class="form-group">
                            		<label class="col-sm-2 control-label">{{ trans('starreport.column_student_name') }}</label>
									<div class="col-sm-10" >
										<select v-model="createReport.student_id" name="student_id" class="form-control">
											<option v-for=" s in students" :value="s.student_id">[[s.student_name]]</option>
										</select>
										<span class="help-block m-b-none" style="color:red" v-if='inputErrors.student_id'>[[inputErrors.student_id]]</span>
									</div>
                                	
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                   <label class="col-sm-2 control-label">{{ trans('starreport.column_report_id') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.report_id" name="report_id" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.report_id'>[[inputErrors.report_id]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_test_date') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.test_date" name="test_date" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.test_date'>[[inputErrors.test_date]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_time_used') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.time_used" name="time_used" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.time_used'>[[inputErrors.time_used]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_grade') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.grade" name="grade" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.grade'>[[inputErrors.grade]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_ss') }}</label>
									<div class="col-sm-10"><input v-model="editReport.ss" name="ss" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.ss'>[[inputErrors.ss]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pr') }}</label>
									<div class="col-sm-10"><input v-model="editReport.pr" name="pr" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.pr'>[[inputErrors.pr]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_estor') }}</label>
									<div class="col-sm-10"><input v-model="editReport.estor" name="estor" type="text" class="form-control">
                                	<span class="help-block m-b-none" style="color:red" v-if='inputErrors.estor'>[[inputErrors.estor]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_ge') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.ge" name="ge" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.ge'>[[inputErrors.ge]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_irl') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.irl" name="irl" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.irl'>[[inputErrors.irl]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_zpd') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.zpd" name="zpd" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.zpd'>[[inputErrors.zpd]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_wks') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.wks" name="wks" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.wks'>[[inputErrors.wks]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_cscm') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.cscm" name="cscm" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.cscm'>[[inputErrors.cscm]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_alt') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.alt" name="alt" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.alt'>[[inputErrors.alt]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_uac') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.uac" name="uac" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.uac'>[[inputErrors.uac]]</span></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_aaet') }}</label>
                                                               <div class="col-sm-10"><input v-model="createReport.aaet" name="aaet" type="text" class="form-control">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.aaet'>[[inputErrors.aaet]]</span></div>
                                </div>
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_result') }}</label> -->
<!--                                                                <div class="col-sm-10"> -->
<!--                                                                <input v-model="createReport.result" type="text" name="result" class="form-control"> -->
<!--                                    <span class="help-block m-b-none" style="color:red" v-if='inputErrors.result'>[[inputErrors.result]]</span> -->
<!--                                    </div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_explain') }}</label> -->
<!--                                                                <div class="col-sm-10"> -->
<!--                                                                <input v-model="createReport.explain" name="explain" type="text" class="form-control"> -->
<!--                                    <span class="help-block m-b-none" style="color:red" v-if='inputErrors.explain'>[[inputErrors.explain]]</span> -->
<!--                                    </div> -->
<!--                                 </div> -->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pdf_en') }}</label>
                                                               <div class="col-sm-10">
                                                               <input readonly v-model="createReport.pdf_en" type="text" name="pdf_en" class="form-control file-set" needType="pdf">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.pdf_en'>[[inputErrors.pdf_en]]</span>
                                   </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">{{ trans('starreport.column_pdf_zh') }}</label>
                                                               <div class="col-sm-10">
                                                               <input readonly v-model="createReport.pdf_zh" type="text" name="pdf_zh" class="form-control file-set" needType="pdf">
                                   <span class="help-block m-b-none" style="color:red" v-if='inputErrors.pdf_zh'>[[inputErrors.pdf_zh]]</span>
                                   </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" v-on:click="setType('list')">{{ trans('starreport.ops_cancel') }}</a>
                                        <button class="btn btn-primary">{{ trans('starreport.ops_save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
    </div>
        <!-- 创建报告  -->
</div>
<script type="text/javascript">
var _accounts=new Vue({
	el:"body",
	data:{
		ajaxurls:{
			getReports:"{{ url('admin/starreport/getReports') }}",
			createReport:"{{ url('admin/starreport/createReport') }}",
			editReport:"{{ url('admin/starreport/editReport') }}",
			deleteReport:"{{ url('admin/starreport/deleteReport') }}",
			getStudents:"{{ url('admin/starreport/getStudents') }}",
		},
		search:{
			page:1,
			limit:10,
		},
		type:"{{ session('view')? session('view'):'list'}}",
		editReport:null,
		createReport:null,
		inputErrors:{!! session('inputErrors')?json_encode(session('inputErrors')):'null' !!},
		students:null,
		reports:null,
		result:null,
		ajaxStatus:false
	},
	methods:{
		doGetReports:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.getReports,
				type:"GET",
				data:_this.search,
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.result=json;
					}else{
						alert(json.error);
					}
				}
			});
		},
		doGetStudents:function(){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.getStudents,
				type:"GET",
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.students=json.data;
					}else{
						alert(json.error);
					}
				}
			});
		},
		doCreateReport:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxurls.createReport,
				type:"GET",
				data:_this.createReport,
				dataType:"json",
				success:function(json){
					if(json.status){
						alert(json.success);
						_this.doGetReports();
						_this.setType('list');
					}else{
						if(json.inputErrors){
							_this.inputErrors=json.inputErrors;
						}else{
							alert(json.error);
						}
					}
					_this.ajaxStatus=false;
				}
			});
		},
		doEditReport:function(){
			var _this=this;
			if(_this.ajaxStatus){
				return;
			}else{
				_this.ajaxStatus=true;
			}
			$.ajax({
				url:_this.ajaxurls.editReport,
				type:"GET",
				data:_this.editReport,
				dataType:"json",
				success:function(json){
					if(json.status){
						alert(json.success);
						_this.doGetReports();
						_this.setType('list');
					}else{
						if(json.inputErrors){
							_this.inputErrors=json.inputErrors;
						}else{
							alert(json.error);
						}
					}
					_this.ajaxStatus=false;
				}
			});
		},
		doDeleteReport:function(rid){
			var _this=this;
			$.ajax({
				url:_this.ajaxurls.deleteReport,
				type:"GET",
				data:{'report_id':rid},
				dataType:"json",
				success:function(json){
					if(json.status){
						_this.doGetReports();
					}else{
						alert(json.error);
					}
				}
			});
		},
		setEditForm:function(type,r){
			this.editReport=r;
			this.type=type;
		},
		setType:function(type){
			this.inputErrors=null;
			this.type=type;
		},
		dochangepage:function(page){
			this.search.page=page;
			this.doGetReports();
		},
		doSearch:function(){
			this.search.page=1;
			this.doGetReports();
		}
	}
});
_accounts.doGetReports();
_accounts.doGetStudents();
@if(session('errors'))
	alert("{{ session('errors')[0] }}");
@endif
</script>
@endsection



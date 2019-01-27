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
<div class="wrapper wrapper-content animated fadeInRight" id="reportsList">
	<div :class="alert.classes" role="alert" v-if="alert"> 
	   <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
	   <strong>[[ alert.msg ]]</strong> 
	  </div> 
	  <div class="row"> 
	   <div class="col-lg-12"> 
	    <div class="ibox"> 
	     <div class="ibox-title"> 
	      <h5><i class="fa fa-list-ul"></i>star报告书单 </h5> 
	      <div class="ibox-tools" v-show="isStarReport"> 
	      	<a  v-on:click="autoFillFormByText()" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i>上传txt填写star报告</a>
	      </div> 
	     </div> 
	     <div class="ibox-content"> 
	      <ul class="nav nav-tabs"> 
	      <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="false">报告表单</a></li> 
	       <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false" v-show="isStarReport">书单列表(已选[[ booklist?booklist.length:0 ]])</a></li> 
	       <li class=""><a href="#tab-3" data-toggle="tab" aria-expanded="true" v-show="isStarReport">书籍列表</a></li> 
	      </ul> 
	      <div id="myTabContent" class="tab-content"> 
	       <div class="tab-pane active" id="tab-1">
	       		<br>
	       		<form id="star-report-form" class="form-horizontal" onsubmit="return false">
                            	 <input type="hidden" v-model="report_id" name="id" v-if="report_id">
	       						 <div class="form-group"><label class="col-sm-2 control-label">学生筛选（star账号）</label>
                                    <div class="col-sm-10">
                                    	<div class="input-group">
	                                        <input name="table_search" class="form-control input-sm" placeholder="Search" type="text"  v-model="students.search.star_account">
	                                    	<span class="input-group-btn">
	                                    		<button type="submit" class="btn btn-sm btn-default" v-on:click="doGetStudents()"><i class="fa fa-search"></i></button>
	                                        </span>
	                                     </div>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">学生</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.student_id" name="student_id" class="form-control col-md-6">
                                    		<option v-for="s in students.data" :value="s.id">[[s.nick_name]]</option>
                                    	</select>
                                    	<label v-if="errors.student_id" class="error">[[ errors.student_id[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">报告类型</label>
                                    <div class="col-sm-10">
                                    	<select v-model="form.report_type" name="report_type"  class="form-control">
                                    			<option value="0">star报告</option>
                                    			<option value="1">阶段性报告</option>
                                    	</select>
                                    	<label v-if="errors.report_type" class="error">[[ errors.report_type[0] ]]</label>
                                    </div>
                                </div>
                              <template v-if="isStarReport">
                               		@include("back::teacher.starReportForm")
                               </template>
                               <template v-if="isStageReport">
                               		@include("back::teacher.StageReportForm")
                               </template>
	       		</form>
	       </div>
	       <div class="tab-pane" id="tab-2"> 
	        <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15"> 
	         <thead> 
	          <tr> 
	           <th data-hide="phone" class="footable-visible footable-sortable"> 书名 </th> 
	           <th data-hide="phone" class="footable-visible footable-sortable"> 作者 </th> 
	           <th data-hide="phone" class="footable-visible footable-sortable"> Book Level </th> 
	           <th data-hide="phone" class="footable-visible footable-sortable"> AR Quiz No </th> 
	           <th class="text-right footable-visible footable-last-column" data-sort-ignore="true">操作</th>
	          </tr> 
	         </thead> 
	         <tbody class="text-center" v-if="status.booklist"> 
	          <tr v-if="reports==null"> 
	           <td colspan="13" class="text-center"><i class="fa fa-spin fa-refresh"></i>数据加载中</td> 
	          </tr> 
	         </tbody> 
	         <tbody v-else=""> 
	          <tr class="footable-even" style="display: table-row;" v-for="r in booklist" v-else=""> 
	           <td class="footable-visible" :title="r.book_name" style="max-width:100px;overflow: hidden;text-overflow:ellipsis;white-space:nowrap;"> [[r.book_name]] </td> 
	           <td class="footable-visible">[[r.author]]</td> 
	           <td class="footable-visible">[[r.BL]]</td> 
	           <td class="footable-visible">[[r.ARQuizNo]]</td> 
	           <td class="footable-visible text-right"> <a v-if="r.deleting"><i class="fa fa-spin fa-refresh"></i></a> <a v-on:click="deleteBooklist(r)" v-else="">移除</a> </td> 
	          </tr> 
	         </tbody> 
	         <tfoot v-if="reports &amp;&amp; reports.last_page&gt;1"> 
	          <tr> 
	           <td colspan="14" class="footable-visible"> 
	            <ul class="pagination pull-right"> 
	             <li v-if="reports.current_page&gt;1" v-on:click="doChangePage(1)"><a>&laquo;</a></li> 
	             <template v-for="p in reports.last_page" v-if="Math.abs(reports.current_page-(p+1))&lt;=3"> 
	              <li v-if="reports.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li> 
	              <li v-else="" v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li> 
	             </template> 
	             <li v-if="reports.current_page &lt; reports.last_page" v-on:click="doChangePage(reports.last_page)"><a>&raquo;</a></li> 
	            </ul> </td> 
	          </tr> 
	         </tfoot> 
	        </table> 
	       </div> 
	       <div class="tab-pane" id="tab-3"> 
	        <div calss="row"> 
	         <div class="col-md-12" style="padding:10px;"> 
	          <form class="panel-body " style="padding: 0" onsubmit="return false;"> 
	           <div class="col-md-3"> 
	            <input class="form-control " placeholder="Book Level区间（例:1-2） " v-model="bookSearch.BL" /> 
	           </div> 
	           <div class="col-md-3" style="padding: 0;margin-right:-5px;"> 
	            <select class="form-control" style="width:98%" v-model="bookSearch.type"> <option selected="" value="">书籍类型</option> <option value="Fiction">Fiction</option> <option value="Nonfiction">Nonfiction</option> </select> 
	           </div> 
	           <div class="col-md-3"> 
	            <input class="form-control " placeholder="主题" v-model="bookSearch.topic" /> 
	           </div> 
	           <div class="col-md-3"> 
	            <button class="btn btn-primary" style="width:118% !important" v-on:click="doChangePage(1)">搜索</button> 
	           </div> 
	          </form> 
	         </div> 
	        </div> 
	        <div class="text-center" v-if="status.books"> 
	         <i class="fa fa-spin fa-refresh"></i>数据加载中 
	        </div> 
	        <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15" v-if="!status.books &amp;&amp; bookslist"> 
	         <tbody> 
	          <tr class="footable-even" style="display: table-row;" v-for="b in bookslist.data"> 
	           <td class="footable-visible col-md-1 text-center"> <img alt="书籍封面" :src="b.image" /> </td> 
	           <td class="footable-visible col-md-11"> <h3 class="text-navy">[[ b.book_name ]](￥[[ b.price_rmb ]])</h3> 
	            <table class="table small m-b-xs"> 
	             <tbody> 
	              <tr> 
	               <td class="col-md-9" colspan="3"> <strong>主题:</strong> [[ b.topic ]] </td> 
	               <td class="col-md-3"> <strong>库存:</strong> <span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="在库">[[ b.status1 ]]</span> <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="借出">[[ b.status23 ]]</span> <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="锁定">[[ b.status4 ]]</span> </td> 
	              </tr> 
	              <tr> 
	               <td class="col-md-3"> <strong>作者:</strong>[[ b.author ]] </td> 
	               <td class="col-md-3"> <strong>ISBN:</strong>[[ b.ISBN ]] </td> 
	               <td class="col-md-3"> <strong>出版社:</strong>[[ b.publisher ]] </td> 
	               <td class="col-md-3"> <strong>书籍类型:</strong>[[ b.type ]] </td> 
	              </tr> 
	              <tr> 
	               <td class="col-md-3"> <strong>BL:</strong>[[ b.BL ]] </td> 
	               <td class="col-md-3"> <strong>IL:</strong>[[ b.IL ]] </td> 
	               <td class="col-md-3"> <strong>ARQuizType:</strong>[[ b.ARQuizType ]] </td> 
	               <td class="col-md-3"> <strong>ARQuizNo:</strong>[[ b.ARQuizNo ]] </td> 
	              </tr> 
	              <tr> 
	               <td colspan="4"> 
	               	
	               		<a class="text-muted"  v-on:click="deleteBooklist(b)" v-if="inBooklist(b)"><i class="fa fa-trash"></i>移出书单</a> 
	               		<a class="text-muted"  v-on:click="addIntoBooklist(b)" v-else><i class="fa fa-plus"></i>加入书单</a> 
	               </td> 
	              </tr> 
	             </tbody> 
	            </table> </td> 
	          </tr> 
	         </tbody> 
	         <tfoot v-if="bookslist.last_page&gt;1"> 
	          <tr> 
	           <td colspan="14" class="footable-visible"> 
	            <ul class="pagination pull-right"> 
	             <li v-if="bookslist.current_page&gt;1" v-on:click="doChangePage(1)"><a>&laquo;</a></li> 
	             <template v-for="p in bookslist.last_page" v-if="Math.abs(bookslist.current_page-(p+1))&lt;=3"> 
	              <li v-if="bookslist.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li> 
	              <li v-else="" v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li> 
	             </template> 
	             <li v-if="bookslist.current_page &lt; bookslist.last_page" v-on:click="doChangePage(bookslist.last_page)"><a>&raquo;</a></li> 
	            </ul> </td> 
	          </tr> 
	         </tfoot> 
	        </table> 
	       </div> 
	      </div> 
	     	
		     <div class="row">
			     	<div class="col-sm-12 text-right">
		                <a class="btn btn-white" href="javascript:history.back()">取消</a>
		                <a class="btn btn-primary"  v-on:click="submitForm()">保存</a>
		          </div>
		     </div>
	     </div> 
	    </div> 
	   </div> 
	  </div> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	   <div class="modal-dialog"> 
	    <div class="modal-content"> 
	     <div class="modal-header"> 
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> 
	      <h4 class="modal-title" id="myModalLabel">加入书单</h4> 
	     </div> 
	     <div class="modal-body"> 
	      <form role="form"> 
	       <div class="form-group">
	        <label>推荐理由</label> 
	        <textarea rows="" cols="" class="form-control" v-model="reason"></textarea> 
	       </div> 
	      </form> 
	     </div> 
	     <div class="modal-footer"> 
	      <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
	      <button type="button" class="btn btn-primary" v-if="status.storeBooklist"> <i class="fa fa-spin fa-refresh"></i></button> 
	      <button type="button" class="btn btn-primary" v-on:click="submitData()" v-else="">确定</button> 
	     </div> 
	    </div>
	    <!-- /.modal-content --> 
	   </div>
	   <!-- /.modal --> 
	  </div>
	  <!--  提交提示 -->
       	<div class="modal" id="modal-upload-progress" tabindex="-1" role="dialog" aria-hidden="true" style="display:none; padding-right: 17px;"> 
		   <div class="modal-dialog"> 
		    <div class="modal-content  "> 
		     <div class="modal-header"> 
		      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
		      <h4 class="modal-title" id="title">数据正在提交...</h4> 
		     </div> 
		     <div class="modal-body text-center" id="msg"> 
		    	<div class="progress">
                        <div class="progress-bar"  :style="'width: '+progress+'%'" role="progressbar"  :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">[[ progress ]]%</span>
                        </div>
                 </div>
                 <div v-if="progress==100">数据正在处理！</div>
		     </div> 
		     <div class="modal-footer"> 
		      	   <button type="button" class="btn btn-white" data-dismiss="modal"  v-on:click="cancelSubmit()">取消</button> 
		     </div> 
		    </div> 
		   </div> 
		  </div>
		 <!--  提交提示 -->
</div>
<script type="text/javascript">
var reportsList=new Vue({
	el:"#reportsList",
	data: {
		form:{
			ajaxStatus:false,
			report_type: '',
			callback:"reportsList.callback",
			star_account: '',
			test_date: '',
			time_used: '',
			grade: '',
			ss: '',
			pr: '',
			ge: '',
			lm: '',
			irl: '',
			estor: '',
			wks: '',
			cscm: '',
			alt: '',
			uac: '',
			aaet:'',
			zpd: '',
			vo: '',
			ui: '',
			er: '',
			wr: '',
			pdf_en:null,
			pdf_zh:null,
			pdf_stage: null
		},
		students:{
			data:null,
			ajaxStatus:false,
			search:null
		},
		errors:null,
		progress: 0,
		booklist: [],
		bookslist: null,
		bookSearch: {},
		report_id: {{$report_id?$report_id:'null'}},
		urls:{
			books: '{{url("admin/api/readplan/seachBooks")}}',
			booklist: '{{ url("admin/teacher/starreport/booklist/getBooklist") }}',
			storeBooklist:  '{{ url("admin/teacher/starreport/booklist") }}',
			deleteBooklist:  '{{ url("admin/teacher/starreport/booklist") }}',
		},
		status: {
			books: false,
			booklist: false,
			storeBooklist:false,
			deleteBooklist:false
		},
		selectBook: {},
		reason: ''
	},
	computed:{
		isStarReport: function () {
			return parseInt(this.form.report_type)===0;
		},
		isStageReport: function () {
			return parseInt(this.form.report_type)===1;
		}
	},
	created: function () {
		this.doGetStudents();
		this.doGetreport();
	},
	methods: {
		//获取报告数据
		doGetreport:function(){
			var _this=this;
			if(_this.report_id){
				$.ajax({
					url:"{{ url('admin/api/teacher/starreport/getStarReport') }}",
					data:{report_id:_this.report_id},
					dataType:"json",
					success:function(json){
						_this.form = json;
						_this.booklist = json.booklist;
						_this.form.ajaxStatus=false;
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						console.log(XMLHttpRequest.status);
						console.log(XMLHttpRequest.readyState);
						console.log(textStatus);
					}
				});
			}
		},
		//获取学生信息
		doGetStudents:function(){
			var _this=this;
			if(_this.students.ajaxStatus){
				return;
			}else{
				_this.students.ajaxStatus=true;
			}
			_this.ajaxUpload=$.ajax({
				url:"{{ url('admin/api/teacher/starreport/getStudents') }}",
				data:_this.students.search,
				dataType:"json",
				success:function(json){
					_this.students.data=json;
					_this.students.ajaxStatus=false;
				},
				error:function(){
					_this.students.ajaxStatus=false;
				}
			});
		},
		// 显示选择的文件名
		showFile: function (e,type) {
			if(e.target.files[0]) {
				switch(type){
					case 'pdf_en': this.form.pdf_en = e.target.files[0].name; break;
					case 'pdf_stage': this.form.pdf_stage = e.target.files[0].name; break;
				}
			}else{
				switch(type){
					case 'pdf_en': this.form.pdf_en = null; break;
					case 'pdf_stage': this.form.pdf_stage = null; break;
				}
			}
		},
		// 上传txt填写表单
		autoFillFormByText: function () {
			var _this = this;
			var input = document.createElement('input');
			input.setAttribute('type','file');
			input.onchange=function(){
				if (input.files[0] && input.files[0].type == 'text/plain'){
					var formdata = new FormData();
					formdata.append('file',input.files[0])
					$.ajax({
						url: "{{ url('admin/teacher/starreport/analysisTXT') }}",
						type: 'POST',
						datatype:"json",
						data: formdata,
						processData: false,
						contentType: false,
						beforeSend: function (){
							_this.form.ajaxStatus=true;
							_this.errors=null;
							$("#modal-upload-progress").modal({backdrop: 'static', keyboard: false});
						},
						success: function (json) {
							for (var i in json.data) {
								_this.form[i] = json.data[i]
							}
						},
						error: function () {
							appAlert({
								title: '提示',
								msg: '数据上传失败'
							});
						},
						xhr: function () {
					          var myXhr = $.ajaxSettings.xhr()
					          if (myXhr.upload) {
					            myXhr.upload.addEventListener('progress', function (e) {
					            	_this.progress = e.loaded / e.total * 100
					            }, false)
					          }
					          return myXhr
					    },
					    complete: function (){
					    	_this.form.ajaxStatus=false;
					    	$("#modal-upload-progress").modal('hide');
					    	_this.ajaxUpload = null;
							_this.progress = 0;
						}
					})
				}else{
					appAlert({
						msg: '请选择txt文件！'
					})
				}
			}
			input.click();
		},
		//提交表单
		submitForm:function(){
			var _this=this;
			if(_this.form.ajaxStatus){
				return false;
			}else{
				if(_this.report_id){
					url="{{ url('admin/api/teacher/starreport/editStarReport') }}";
				}else{
					url="{{ url('admin/api/teacher/starreport/createStarReport') }}";
				}
				var formdata = new FormData($('#star-report-form')[0]);
				for(var i in _this.booklist) {
					formdata.append('booklist[]',_this.booklist[i].id);
				}
				$.ajax({
					url: url,
					type: 'POST',
					datatype:"json",
					data:formdata ,
					processData: false,
					contentType: false,
					beforeSend: function (){
						_this.form.ajaxStatus=true;
						_this.errors=null;
						$("#modal-upload-progress").modal({backdrop: 'static', keyboard: false});
					},
					success: function (json) {
						if(json.status){
							appAlert({
								title: '提示',
								msg: json.success
							});
							window.location.href="{{ url('admin/teacher/starreport') }}";
						}else{
							if(json.error){
								appAlert({
									title: '提示',
									msg: json.error
								});
							}
							_this.errors=json.errors;
						}
					},
					error: function () {
						appAlert({
							title: '提示',
							msg: '数据上传失败'
						});
					},
					xhr: function () {
				          var myXhr = $.ajaxSettings.xhr()
				          if (myXhr.upload) {
				            myXhr.upload.addEventListener('progress', function (e) {
				            	_this.progress = e.loaded / e.total * 100
				            }, false)
				          }
				          return myXhr
				    },
				    complete: function (){
				    	_this.form.ajaxStatus=false;
				    	$("#modal-upload-progress").modal('hide');
				    	_this.ajaxUpload = null;
						_this.progress = 0;
					}
				})
			}
		},
		// 搜索书籍
		searchBooks: function () {
			var _this = this
			$.ajax({
				url: _this.urls.books,
				data: _this.bookSearch,
				dataType: 'json',
				type: 'get',
				beforeSend: function (){
					_this.status.books = true
				},
				success: function (json) {
					_this.bookslist = json;
				},
				complete: function (){
					_this.status.books = false
				}
			});
		},
		// 书籍换页
		doChangePage (page) {
			this.bookSearch.page = page
			this.searchBooks()
		},
		// 提交书单书籍
		addIntoBooklist:function (b) {
			if(this.booklist.length<20){
				for(var i in this.booklist){
					if (this.booklist[i].id == b.id) {
						appAlert({
							msg: '该书籍以添加！'
						});
						return;
					}
				}
				this.booklist.push(b);
			}else{
				appAlert({
					msg: '书单上限为20本！'
				});
				return;
			}
		},
		// 移除书单书籍
		deleteBooklist:function(b){
			for(var i in this.booklist){
				if (this.booklist[i].id == b.id) {
					this.booklist.splice(i,1);
					return;
				}
			}
		},
		// 判断书籍是否在书单内
		inBooklist (b){
			for(var i in this.booklist){
				if (this.booklist[i].id == b.id) {
					return true;
				}
			}
			return false;
		}
	}
});
</script>
@endsection



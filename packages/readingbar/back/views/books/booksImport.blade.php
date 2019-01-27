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
<div class="wrapper wrapper-content animated fadeInRight" id="booksList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>书籍上出及处理 </h5>
                        <div class="ibox-tools">
                        	<a :href="a.create" class="btn btn-primary btn-xs" v-on:click="uploadFile()"><i class="fa fa-upload"></i>上传书籍</a>
                        	
                        	<a href="javascript:void(0)" v-on:click="doAutoDell()" class="btn btn-primary btn-xs">
		                        	<i class="fa fa-refresh fa-spin" v-if='autoDell'></i>
		                        	<i class="fa fa-toggle-right" v-else></i>自动处理
                        	</a>
                		</div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr >
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	书名
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	作者
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	出版社
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	ISBN
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	ARQuizNo
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-4">
		                        	摘要
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable col-md-1">
		                        	价格
		                        </th>
		                        <th class="text-right footable-visible footable-last-column col-md-2" data-sort-ignore="true">操作</th></tr>
		                </thead>
		                <tbody v-if='books'>
		                	<tr><td colspan="8" class="text-center">在库书籍信息</td></tr>
		                	<tr class="footable-even" style="display: table-row;" v-for="r in books.existsBooks">
		                        <td class="footable-visible">[[r.book_name]]</td>
		                        <td class="footable-visible">[[r.author]]</td>
		                        <td class="footable-visible">[[r.publisher]]</td>
		                        <td class="footable-visible">[[r.ISBN]]</td>
		                        <td class="footable-visible">[[r.ARQuizNo]]</td>
		                        <td class="footable-visible">[[r.summary]]</td>
		                        <td class="footable-visible">[[r.price_rmb]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" v-on:click="doManualHandling('update',books.importBooks.id,r.id)">合并到该书籍</a>
		                        </td>
		                    </tr>
		                	<tr><td colspan="8" class="text-center">上传书籍信息</td></tr>
		                    <tr class="footable-even" style="display: table-row;">
		                        <td class="footable-visible">[[books.importBooks.book_name]]</td>
		                        <td class="footable-visible">[[books.importBooks.author]]</td>
		                        <td class="footable-visible">[[books.importBooks.publisher]]</td>
		                        <td class="footable-visible">[[books.importBooks.ISBN]]</td>
		                        <td class="footable-visible">[[books.importBooks.ARQuizNo]]</td>
		                        <td class="footable-visible">[[books.importBooks.summary]]</td>
		                        <td class="footable-visible">[[books.importBooks.price_rmb]]</td>
		                        <td class="footable-visible text-right">
		                        	<a class="btn btn-primary" v-on:click="doManualHandling('create',books.importBooks.id)">作为新书籍</a>
		                        	<a class="btn btn-primary" v-on:click="doManualHandling('delay',books.importBooks.id)">暂不处理</a>
		                        </td>
		                    </tr>
		                </tbody>
		                <tbody v-else>
		                	<tr><td colspan="8" class="text-center">暂无需要人工处理的数据！</td></tr>
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
	 <!-- 文件上传进度 -->
    <div class="modal" id="modal-xls-upload-progress" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
           <div class="progress progress-striped" style="margin-bottom:0px">
              <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" 
                  aria-valuemin="0" aria-valuemax="100" :style="'width:' + upload.progress + '%'">
              </div>
          </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /文件上传进度 -->
</div>

<script type="text/javascript">
var booksList=new Vue({
	el:"Body",
	data:{
		books:null,
		MHStatus:false,
		autoDell: false,
		upload: {
			status: false,
			progress: 0
		}
	},
	methods:{
		/* 上传文件 */
	    uploadFile () {
	      if (this.upload.status === false) {
	        var _this = this;
	        var input = document.createElement('input');
	        input.setAttribute('type', 'file');
	        input.onchange = function () {
	          _this.uploadProgress = 0;
	          var formData = new FormData();
	          formData.append('file', input.files[0]);
	          
	          $('#modal-xls-upload-progress').modal({backdrop: 'static', keyboard: false});
	          $.ajax({
	        	 url:"{{ url('admin/api/booksManage/doImport') }}",
	            type: 'POST',
	            data: formData,
	            processData: false,
	            contentType: false,
	            success: function (json) {
					appAlert({
						msg: json.message
					});
					_this.doGetUntreatedBooks();
			    },
	            headers: {
            		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            	},
	            xhr: function () {
	              var myXhr = $.ajaxSettings.xhr()
	              if (myXhr.upload) {
	                myXhr.upload.addEventListener('progress', function (e) {
	                  _this.upload.progress = e.loaded / e.total * 100;
	                }, false);
	              }
	              return myXhr;
	            },
	            error: function (e) {
		            if (typeof(e.responseJSON) == 'object') {
		            	appAlert({
							msg: e.responseJSON.message
						});
			        }else{
			        	appAlert({
							msg: '文件格式有误，请确认后上传！'
						});
				    }
	            },
	            complete: function () {
	              $('#modal-xls-upload-progress').modal('hide');
	              _this.upload.progress = 0
	            }
	          })
	        }
	        input.click();
	      }
	    },
		//获取未处理的书籍信息
		doGetUntreatedBooks:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/booksManage/untreatedBooks') }}",
				dataType:'json',
				success:function(json){
					if(json.status){
						_this.books=json.data;
					}else{
						_this.books=null;
					}
				}
			});
		},
		//人工处理上传书籍信息
		doManualHandling:function(){
			var _this=this;
			if(_this.MHStatus){
				return;
			}else{
				_this.MHStatus=true;
			}
			switch(arguments[0]){
				case 'create': 
					data={
						new_id:arguments[1],
						dell_type:arguments[0]
					}
					break;
				case 'update': 
					data={
						new_id:arguments[1],
						old_id:arguments[2],
						dell_type:arguments[0]
					}
					break;
				case 'delay': 
					data={
						new_id:arguments[1],
						dell_type:arguments[0]
					}
					break;
				default:alert('处理方式不存在');_this.MHStatus=false;return;
			}
			$.ajax({
				url:"{{ url('admin/api/booksManage/manualHandling') }}",
				dataType:'json',
				type:"POST",
				data:data,
				success:function(json){
					if(json.status){
						appAlert({
							msg: json.success
						});
					}else{
						appAlert({
							msg: json.error
						});
					}
					_this.doGetUntreatedBooks();
					_this.MHStatus=false;
				},
				error:function(){
					_this.MHStatus=false;
				}
			});
		},
		//自动处理部分上传书籍信息
		doAutoDell:function(){
			var _this=this;
			if(_this.autoDell){
				return;
			}else{
				_this.autoDell=true;
			}
			$.ajax({
				url:"{{ url('admin/api/booksManage/dellBooks') }}",
				dataType:'json',
				type:"POST",
				success:function(json){
					if(json.status){
						appAlert({
							msg: json.success
						});
					}else{
						appAlert({
							msg: json.error
						});
					}
					_this.doGetUntreatedBooks();
				},
				complete: function () {
					_this.autoDell = false;
				}
			});
		}
	}
});
booksList.doGetUntreatedBooks();
</script>
@endsection



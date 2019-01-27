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
 	@if($success!='')
    <div class="alert alert-success" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>{{$success}}</strong>
	</div>
	@endif
	@if($error!='')
	<div class="alert alert-danger" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>{{$error}}</strong>
	</div>
	@endif
    <div class="row">
             <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>  {{ trans('books.list_title') }} </h5>
                        <div class="ibox-tools">
                        	<a href="{{url('admin/books/export')}}" class="btn btn-primary btn-xs"><i class="fa fa-download"></i>导出</a>
                        	<a data-target="#booksCreateModal" data-toggle="modal" class="btn btn-primary btn-xs"><i class="fa fa-plus-square-o"></i>   {{ trans('common.add') }}</a>
                     </div>
                     <div class="row">
	                     <ul class="nav nav-tabs">
							<li><a href="#quickSearch" class="active" data-toggle="tab">快速搜索</a></li>
							<li><a href="#multipleSearch" data-toggle="tab">高等搜索</a></li>
						 </ul>
						 <div class="tab-content">
							<div class="tab-pane fade in active" id="quickSearch">
								<div class="panel-body">
									 <form onsubmit="return false" role="form" class="form-inline col-md-12">
									 	<select class="form-control" name="search_column" v-model="keyword_search.search_column">
									 		<option value="all">全部</option>
									 		<option value="book_name">书名</option>
									 		<option value="author">作者</option>
									 		<option value="publisher">出版社</option>
									 		<option value="ARQuizType">ARQuizType</option>
									 		<option value="series">系列</option>
									 	</select>
				                     	<input class="form-control" name="search" placeholder="关键字" value="{{$search or ''}}"  v-model="keyword_search.keyword">
				                     	<select class="form-control" name="search_column" v-model="keyword_search.status">
									 		<option value="all">状态</option>
									 		<option value="1">在库</option>
									 		<option value="3">已借出</option>
									 		<option value="4">锁定</option>
									 		<option value="5">报废</option>
									 	</select>
				                     	<button class="btn btn-primary" style="margin-bottom:0px" v-on:click="doSearch(1)">搜索</button>
				                     </form>
			                   </div>
							</div>
							<div class="tab-pane fade" id="multipleSearch">
							   <div class="panel-body">
									 <form onsubmit="return false"   role="form" class="form-inline col-md-12">
				                     	<input class="form-control" name="book_name" placeholder="标题" value="{{$book_name or ''}}" v-model="advanced_search.book_name">
				                     	<input class="form-control" name="author" placeholder="作者" value="{{$author or ''}}" v-model="advanced_search.author">
				                     	<input class="form-control" name="publisher" placeholder="出版社" value="{{$publisher or ''}}" v-model="advanced_search.publisher">
				                     	<input class="form-control" name="ISBN" placeholder="ISBN" value="{{$ISBN or ''}}" v-model="advanced_search.ISBN">
				                     	<input class="form-control" name="ARQuizNo" placeholder="ARQuizNo" value="{{$ARQuizNo or ''}}"  v-model="advanced_search.ARQuizNo">
				                     	<select class="form-control" name="ARQuizType" v-model="advanced_search.ARQuizType">
				                     		<option value="">Quiz 类型</option>
				                     		<option value="阅读">阅读</option>
				                     		<option value="阅读;词汇">阅读;词汇</option>
				                     		<option value="阅读;听力">阅读;听力</option>
				                     		<option value="阅读;读写">阅读;读写</option>
				                     		<option value="阅读;听力;词汇">阅读;听力;词汇</option>
				                     		<option value="阅读;读写;词汇">阅读;读写;词汇</option>
				                     		<option value="阅读;听力;读写">阅读;听力;读写</option>
				                     		<option value="阅读;听力;读写;词汇">阅读;听力;读写;词汇</option>
				                     	</select>
				                     	<select class="form-control" name="in_book_list"  v-model="advanced_search.in_book_list">
				                     		<option value="">书单状态</option>
				                     		<option value="0">未加入书单</option>
				                     		<option value="1">已加入书单</option>
				                     	</select>
				                     	<select class="form-control" name="search_column" v-model="advanced_search.status">
									 		<option value="all">状态</option>
									 		<option value="1">在库</option>
									 		<option value="3">已借出</option>
									 		<option value="4">锁定</option>
									 		<option value="5">报废</option>
									 	</select>
				                     	<button class="btn btn-primary" style="margin-bottom:0px"v-on:click="doSearch(2)">搜索</button>
				                     </form>
			                   </div>
							</div>
						</div>
                     </div>
                    </div>
                    	<div id="book-list">
                    		 @foreach ($bookList as $book)
                        	<div class="book-item">
                        		<div class="book-image">
                        			<img src="{{$book->image}}" alt=''>
                        		</div>
                        		<div class="book-info">
                        			<div class="book-name">
                        					{{$book->book_name}}
                        					<small>(￥{{$book->price_rmb}})</small>
                        			</div>
                        			<div class="book-info-in">
                        					<div>
		                        				<div class="book-author">
		                        					{{$book->author}}
			                        			</div>
			                        			<div class="book-ar">
			                        					<strong>Quiz No.</strong> :{{$book->ARQuizNo}}
			                        			</div>
			                        			<div class="book-summary">
			                        					{{$book->summary}}
			                        			</div>
			                        			<div>
			                        				  <strong>IL</strong> :{{$book->IL}}  
			                        				  <strong>BL</strong> :{{$book->BL}}
			                        				  <strong>NF/F</strong> :{{$book->type}}
			                        				  <strong>ISBN</strong> :{{$book->ISBN}}
			                        			</div>
		                        			</div>
		                        			@if(isset($book->storages) && $book->storages->count()>0)
			                        		<div class="storage-detail">
			                        				<div id="carousel-example-generic-{{  $book->id }}" class="carousel slide" data-ride="carousel" >
														  <!-- Wrapper for slides -->
														  <div class="carousel-inner" role="listbox">
														  @foreach ($book->storages as $k=>$s)
														  	@if($k==0)
														    	<div class="item active">
														    @else
														    	<div class="item">
														    @endif
														    	@if($s->status == 3)
															      <div class="torage-detail-3">
															      		<div><span class="pre">书籍库存编号：</span>{{ $s->serial }}</div>
															      		<div>
															      			<span class="pre">借出时间:</span>
															      			{{ $s->relates['lended_time'] }}
															      		</div>
															      		<div>
															      			<span class="pre">计划归还:</span>
															      			{{ $s->relates['plan_end'] }}
															      		</div>
															      		<div>
															      			<span class="pre">star账号:</span>
															      			{{ $s->relates['star_account'] }}
															      		</div>
															      		<div>
															      			<span class="pre">指导老师:</span>
															      			{{ $s->relates['teacher_name'] }}
															      		</div>
															      </div>
															     @endif
															     @if($s->status == 4)
															      <div class="torage-detail-4">
															      		<div><span class="pre">书籍库存编号：</span>{{ $s->serial }}</div>
															      		<div>
															      			<span class="pre">锁定时间:</span>
															      			{{ $s->relates['locked_time'] }}
															      		</div>
															      		<div>
															      			<span class="pre">指导老师:</span>
															      			{{ $s->relates['teacher_name'] }}
															      		</div>
															      </div>
															     @endif
															     @if($s->status == 5)
															      <div class="torage-detail-5">
															      		<div><span class="pre">书籍库存编号：</span>{{ $s->serial }}</div>
															      		<div>
															      			<span class="pre">报废时间:</span>
															      			{{ $s->relates['lossed_time'] }}
															      		</div>
															      </div>
															     @endif
															    </div>
														    @endforeach
														  </div>
														  <!-- Controls -->
														  <a class="left carousel-control" href="#carousel-example-generic-{{  $book->id }}" role="button" data-slide="prev">
														    <span class="pacc-chevron-left" aria-hidden="true"></span>
														  </a>
														  <a class="right carousel-control" href="#carousel-example-generic-{{  $book->id }}" role="button" data-slide="next">
														    <span class="pacc-chevron-right" aria-hidden="true"></span>
														  </a>
														</div>
			                        		</div>
			                        		@endif
                        			</div>
                        		</div>
                        		<div class="storage">
                        			库存：{{$book->storage}}
                        		</div>
                        		<div  class="operation">
                        			<a href="{{url('admin/books/'.$book->id.'/edit')}}" class="text-muted"><i class="fa fa-edit"></i> {{ trans('common.edit') }}</a>
                                                <a v-on:click="setDeleteId({{ $book->id }})" data-target="#booksDeleteModal" data-toggle="modal" class="text-muted"><i class="fa fa-trash"></i> {{ trans('common.delete') }}</a>
                                            	<a href="{{url('admin/books/'.$book->id.'/viewImages')}}" target='_blank' class="text-muted"><i class="fa fa-eye"></i>图片预览</a>
                                            	<a href="javascript:void(0)" v-on:click="changeInBookList({{ $book->id }},{{ $book->in_book_list }})"  class="text-muted">
                                            		@if($book->in_book_list)
                                            			<i class="fa fa-minus"></i>移出书单
                                            		@else
                                            			<i class="fa fa-plus"></i>加入书单
                                            		@endif
                                            	</a>
                        		</div>
                        	</div>
                        	@endForeach
                        </div>
                        <div >
							{!! $bookList->appends(Request::all())->links() !!}
						</div>
                </div>
            </div>
    </div>
</div>
<!-- 删除确认 -->
<div class="modal inmodal fade" id="booksDeleteModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header" style="padding:5px">
					
             </div>
	         <div class="modal-body">
	         	<p><strong>{{ trans("common.text_delete?")}}</strong></p>
	         </div>
	         <div class="modal-footer">
	              <button type="button" class="btn btn-white" data-dismiss="modal">{{ trans("common.text_no")}}</button>
	              <button type="button" class="btn btn-primary" v-on:click="doDelete()">{{ trans("common.text_yes")}}</button>
	         </div>
    	 </div>
	</div>
</div>
<!-- /删除确认 -->
<!-- 新增查询  -->
<div class="modal inmodal fade" id="booksCreateModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header" style="padding:5px">
					<h1>新增</h1>
             </div>
	         <div class="modal-body">
	         	<div class="form-group">
	         		<input class="form-control" v-model="createForm.ISBN" name="ISBN" placeholder="ISBN" value="">
				    <input class="form-control" v-model="createForm.ARQuizNo" name="ARQuizNo" placeholder="ARQuizNo" value="">                  	
	         	</div>
	         </div>
	         <div class="modal-footer">
	              <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
	              <button type="button" class="btn btn-primary" v-on:click="doCreate()">查询</button>
	         </div>
    	 </div>
	</div>
</div>
<!-- 新增查询  -->
<script type="text/javascript">
	new Vue({
		el:"body",
		data:{
			id:null,
			createForm:null,
			keyword_search: {
				search_mode: 'keyword_search',
				page: 1
			},
			advanced_search: {
				search_mode: 'advanced_search',
				page: 1
			}
		},
		methods:{
				setDeleteId:function(id){
					this.id=id;
				},
				doDelete:function(){
					if(this.id!=null){
						window.location.href="{{url('admin/books')}}/"+this.id+"/delete";
					}
				},
				doCreate:function(){
					window.location.href="{{url('admin/books/create')}}?ISBN="+this.createForm.ISBN+"&ARQuizNo="+this.createForm.ARQuizNo;
				},
				changeInBookList:function(id,ibl){
					if(ibl){
						ibl=0;
					}else{
						ibl=1;
					}
					window.location.href="{{url('admin/books/changeInBookList')}}?id="+id+"&in_book_list="+ibl;
				},
				doSearch: function (t) {
					if(t == 1) {
						window.location.href="{{url('admin/books')}}?"+$.param(this.keyword_search);
					}
					if(t == 2) {
						window.location.href="{{url('admin/books')}}?"+$.param(this.advanced_search);
					}
				}
			}
	});
</script>
@endsection



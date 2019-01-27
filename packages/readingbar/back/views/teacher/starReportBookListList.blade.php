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
      <div class="ibox-tools"> 
       <a href="{{ url('files/starReport/booklist/'.$report_id.'.docx') }}" class="btn btn-primary btn-xs"><i class="fa fa-download"></i>下载书单</a> 
      </div> 
     </div> 
     <div class="ibox-content"> 
      <ul class="nav nav-tabs"> 
       <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="false">书单列表</a></li> 
       <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="true">书籍列表</a></li> 
      </ul> 
      <div id="myTabContent" class="tab-content"> 
       <div class="tab-pane active" id="tab-1"> 
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
          <tr class="footable-even" style="display: table-row;" v-for="r in data" v-else=""> 
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
       <div class="tab-pane" id="tab-2"> 
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
               <td colspan="4"> <a class="text-muted" v-on:click="submitData(b)"><i class="fa fa-edit"></i>加入书单</a> </td> 
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
</div>
<script type="text/javascript">
var reportsList=new Vue({
	el:"#reportsList",
	data: {
		data: [],
		bookslist: null,
		bookSearch: {},
		reportId: {{$report_id}},
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
	created: function () {
		this.getBooklist();
		this.searchBooks();
	},
	methods: {
		getBooklist: function () {
			var _this = this
			$.ajax({
				url: _this.urls.booklist,
				data: {
					'report_id': _this.reportId
				},
				dataType: 'json',
				type: 'get',
				beforeSend: function (){
					_this.status.booklist = true
				},
				success: function (json) {
					for (var i in json){
						json[i].deleting = false
					}
					_this.data = json;
				},
				complete: function (){
					_this.status.booklist = false
				}
			});
		},
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
		doChangePage (page) {
			this.bookSearch.page = page
			this.searchBooks()
		},
		addIntoBooklist (b) {
			this.selectBook  = b;
			this.reason = '';
			$("#myModal").modal();
		},
		submitData:function (b) {
			this.selectBook  = b;
			var _this = this
			$.ajax({
				url: _this.urls.storeBooklist,
				data: {
					'report_id': _this.reportId,
					'book_id': _this.selectBook.id
					//'reason': _this.reason
				},
				dataType: 'json',
				type: 'post',
				beforeSend: function (){
					_this.status.storeBooklist = true
				},
				success: function (json) {
					_this.getBooklist()
					appAlert({
						msg: json.message
					})
				},
				error:function(e){
					if(e.status == 400) {
						appAlert({
							msg: e.responseJSON.message
						})
					}
				},
				complete: function (){
					_this.status.storeBooklist = false
					$("#myModal").modal('hide');
				}
			});
		},
		deleteBooklist:function(r){
			var _this = this
			$.ajax({
				url: _this.urls.deleteBooklist,
				data: {
					'id': r.id
				},
				dataType: 'json',
				type: 'delete',
				beforeSend: function (){
					r.deleting = true
				},
				success: function (json) {
					for(var i in _this.data) {
						if (_this.data[i].id == r.id) {
							_this.data.splice(i,1);
						}
					}
				},
				error:function(e){
					if(e.status == 400) {
						appAlert({
							msg: e.responseJSON.message
						})
					}
				},
				complete: function (){
					r.deleting = false
				}
			});
		}
	}
});
</script>
@endsection



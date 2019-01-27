
  <div class="modal inmodal fade in" id="booksSearchModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none; padding-right: 17px;"> 
   <div class="modal-dialog modal-lg"> 
    <div class="modal-content"> 
     <div class="modal-header"> 
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
      <h4 class="modal-title">书籍搜索</h4> 
     </div> 
     <div class="modal-body form-inline"> 
     		<form class="panel-body " style="padding: 0" onsubmit="return false;">
				 		<input class="form-control col-md-3" v-model="bookSearch.book_name" placeholder="书籍名称 ">  
                    	  <input class="form-control col-md-3" v-model="bookSearch.author" placeholder="作者 ">  
                    	  <input class="form-control col-md-3" v-model="bookSearch.publisher" placeholder="出版社 ">
                    	  <input class="form-control col-md-3" v-model="bookSearch.ISBN" placeholder="ISBN "> 
                    	   <input class="form-control col-md-3" v-model="bookSearch.series" placeholder="系列 "> 
                    	  <input class="form-control col-md-3" v-model="bookSearch.BL" placeholder="Book Level区间（例:1-2） "> 
                    	  <div class='col-md-3' style="padding: 0;margin-right:-5px;">
                    	  	 <select v-model="bookSearch.type" class="form-control" style="width:98%">
	                          	<option selected value=''>书籍类型</option>
	                          	<option value="Fiction">Fiction</option>
	                          	<option value="Nonfiction">Nonfiction</option>
	                          </select>
                    	  </div>
                    	 <div class='col-md-3' style="padding: 0;margin-right:-5px;">
                    	  <select v-model="bookSearch.IL" class="form-control" style="width:98%">
	                          	<option selected value=''>IL类型 </option>
	                          	<option value="LG">LG</option>
	                          	<option value="MG">MG</option>
	                          	<option value="UG">UG</option>
	                          	<option value="MG+">MG+</option>
                          </select>
                         </div>
                    	 <div class='col-md-3' style="padding: 0;margin-right:-5px;">
                    	  <select class="form-control" name="ARQuizType" v-model="bookSearch.ARQuizType" style="width:98%;">
				                     		<option selected value="">Quiz 类型</option>
				                     		<option value="阅读">阅读</option>
				                     		<option value="阅读;词汇">阅读;词汇</option>
				                     		<option value="阅读;听力">阅读;听力</option>
				                     		<option value="阅读;读写">阅读;读写</option>
				                     		<option value="阅读;听力;词汇">阅读;听力;词汇</option>
				                     		<option value="阅读;读写;词汇">阅读;读写;词汇</option>
				                     		<option value="阅读;听力;读写">阅读;听力;读写</option>
				                     		<option value="阅读;听力;读写;词汇">阅读;听力;读写;词汇</option>
				          </select>
				          </div>
                    	  <input class="form-control col-md-3" v-model="bookSearch.ARQuizNo" placeholder="Quiz No."> 
                    	  <input class="form-control col-md-3" v-model="bookSearch.topic" placeholder="主题">
				 		
				 		<div class="col-md-3">
				 			<button class="btn btn-primary" style="width:118% !important" v-on:click="doGetBooksSearch()" style="margin-bottom:0px">搜索</button>
				 		</div>
           </form>
           <div class="panel-body " style="overflow-y: scroll;height:200px !important;">
           	 <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		             
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in books.data">
		                    	<td class="footable-visible col-md-1 text-center">
		                    		<img alt="书籍封面" :src="n.image">
		                    	</td>
		                    	<td class="footable-visible col-md-11">
		                    		<h3 class='text-navy'>[[n.book_name]](￥[[n.price_rmb]])</h3>
		                    		<table class="table small m-b-xs">
				                        <tbody>
				                        	<tr>
					                            <td class="col-md-9" colspan="3">
					                                <strong>主题:</strong>[[n.topic]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>库存:</strong>
					                                <span class="badge badge-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="在库">[[ n.status1 ]]</span>
													<span class="badge badge-danger"  data-toggle="tooltip" data-placement="top" title="" data-original-title="借出">[[ n.status23 ]]</span>
													<span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="锁定">[[ n.status4 ]]</span>
					                            </td>
					                        </tr>
					                        <tr>
					                            <td class="col-md-3">
					                                <strong>作者:</strong>[[n.author]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ISBN:</strong>[[n.ISBN]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>出版社:</strong>[[n.publisher]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>书籍类型:</strong>[[n.type]]
					                            </td>
					                        </tr>
					                        <tr>
					                            <td class="col-md-3">
					                                <strong>BL:</strong>[[n.BL]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>IL:</strong>[[n.IL]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ARQuizType:</strong>[[n.ARQuizType]]
					                            </td>
					                            <td class="col-md-3">
					                                <strong>ARQuizNo:</strong>[[n.ARQuizNo]]
					                            </td>
					                        </tr>
					                        <tr>
					                        	<td colspan="4">
					                        		<a class="text-muted"  v-on:click="doAddBookIntoPlan(n)"><i class="fa fa-edit"></i>加入阅读计划</a> 
					                        		<label v-if="hasRead(n)" class="label label-danger">已读</label>
					                        		
					                        	</td>
					                        </tr>
				                        </tbody>
				                    </table>
		                    	</td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="list && list.last_page>1">
		                    <tr>
		                    	<td>
		                    		<span class='row'>
		                    			[[ list.from ]]-[[ list.to ]]/[[ list.total ]]
		                    		</span>
		                    	</td>
		                        <td colspan="15" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="list.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in list.last_page" v-if="Math.abs(list.current_page-(p+1))<=3">
							    			<li v-if="list.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="list.current_page < list.last_page" v-on:click="doChangePage(list.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>	
           
     		 
			  
           </div>
         
     </div> 
     <div class="modal-footer"> 
     <ul class="pagination" style="float:left;margin:0" v-if="books.last_page>1">
				    <li><a v-if="1!=books.current_page" v-on:click="doChangePageOfBS(1)">&laquo;</a></li>
				    <template  v-for="p in books.last_page" v-if="Math.abs(p+1-books.current_page,0)<4">
				    	<li v-if="books.current_page==p+1" class="active"><a href="javascript:void(0)" v-on:click="doChangePageOfBS(p+1,0)">[[ p+1 ]]</a></li>
				    	<li v-else><a href="javascript:void(0)" v-on:click="doChangePageOfBS(p+1,0)">[[ p+1 ]]</a></li>
				    </template>
				    <li><a v-if="books.last_page!=books.current_page" v-on:click="doChangePageOfBS(books.last_page)">&raquo;</a></li>
	  </ul>
      <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button> 
     </div> 
    </div> 
   </div> 
  </div>
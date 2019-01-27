<div class="row" v-if="listType=='members'">
		<div class="col-lg-12">
		    <div class="ibox">
		    	<div class="ibox-title">
                        <h5><i class="fa fa-list-ul"></i>会员列表 </h5>
                        <div class="ibox-tools">
<!--                         	<a class="btn btn-primary btn-xs" v-on:click="exportdataList()" href="javascript:void(0)"><i class="fa fa-download"></i>导出</a> -->
                        </div>
                </div>
		        <div class="ibox-content">
		            <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded" data-page-size="15">
		                <thead>
		                    <tr>
		                    	<th data-toggle="true" class="footable-visible footable-first-column footable-sortable footable-sorted">#ID</th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	注册日期
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	会员昵称
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	手机
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	邮箱
		                        </th>
		                        <th data-hide="phone" class="footable-visible footable-sortable">
		                        	孩子数量
		                        </th>
		                </thead>
		                <tbody>
		                    <tr class="footable-even" style="display: table-row;" v-for="n in dataList.data">
		                        <td class="footable-visible">[[n.id]]</td>
		                        <td class="footable-visible">[[n.created_at]]</td>
		                        <td class="footable-visible">[[n.nickname]]</td>
		                        <td class="footable-visible">[[n.cellphone]]</td>
		                        <td class="footable-visible">[[n.email]]</td>
		                       	<td class="footable-visible">[[n.children]]</td>
		                    </tr>
		                </tbody>
		                <tfoot v-if="dataList && dataList.last_page>1">
		                    <tr>
		                        <td colspan="6" class="footable-visible">
		                            <ul class="pagination pull-right" >
								    	<li v-if="dataList.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
							    		<template v-for="p in dataList.last_page" v-if="Math.abs(dataList.current_page-(p+1))<=3">
							    			<li v-if="dataList.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
							    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
							    		</template>
								     	<li v-if="dataList.current_page < dataList.last_page" v-on:click="doChangePage(dataList.last_page)"><a>»</a></li>
							     	</ul>
		                        </td>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
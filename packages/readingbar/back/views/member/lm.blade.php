<div class="row" >
				<div class="col-md-12"> 
					<form class="form-inline" onsubmit="return false">
						<div class="input-daterange input-group" id="members">
                               <input type="text" class="input-sm form-control" name="fromDate">
                               <span class="input-group-addon">至</span>
                               <input type="text" class="input-sm form-control" name="toDate">
				        </div>
				        <div class="input-group">
				        	<input type="text" class="form-control"  v-model="search.email" placeholder="邮箱">
				        </div>
				        <div class="input-group">
				        	<input type="text" class="form-control"  v-model="search.cellphone" placeholder="手机">
				        </div>
				        <div class="input-group">
					        <select  v-model="search.area" class="form-control">
					        	<option value="">请选择地区</option>
					        	<option v-for="a in areas" :value="a.name">[[ a.name ]]</option>
					        </select>
				        </div>
				        <button class="btn btn-white" v-on:click="doSearch()" >查询</button>
					</form>
					
					<br>
				</div>
				<div class="col-md-12"> 
					<div class="table-responsive">
                                <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                                    <tbody>
                                    <tr v-for="m in members.data">
                                        <td width="90px">
                                            <div class="cart-product-imitation" style="padding-top: 0px">
                                            	<img alt="" :src="m.avatar" style="width:80ox;height:80px;">
                                            </div>
                                        </td>
                                        <td class="desc">
                                            <h3>
                                            <a href="#" class="text-navy">
                                               [[m.nickname]]
                                            </a>([[ m.created_at ]])
                                            </h3>
                                            <div class="inline col-md-3">
                                            	<label>{{trans('members.column_email')}}:<em>[[m.email]]</em></label>
                                            </div>
                                            <div class="inline col-md-3">
                                            	<label>{{trans('members.column_cellphone')}}:<em>[[m.cellphone]]</em></label>
                                            </div>
                                            <div class="m-t-sm" style="clear:both">
                                                <a :href="m.editurl" class="text-muted"><i class="fa fa-edit"></i>{{trans('common.edit')}}</a>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                    <tfoot v-if="members.last_page >1">
                                    	<tr>
                                    		<td colspan='3' class="footable-visible">
                                    			<div class="col-sm-5">
                                    				<lable class="pagination">[[ members.from ]]-[[ members.to ]]/[[ members.total ]]</lable>
                                    			</div>
                                    			<div class="col-sm-7">
                                    				<ul class="pagination pull-right" >
												    	<li v-if="members.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
											    		<template v-for="p in members.last_page" v-if="Math.abs(members.current_page-(p+1))<=3">
											    			<li v-if="members.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
											    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
											    		</template>
												     	<li v-if="members.current_page < members.last_page" v-on:click="doChangePage(members.last_page)"><a>»</a></li>
											     	</ul>
                                    			</div>
                                    		</td>
                                    	</tr>
                                    </tfoot>
                                </table>
                            </div>
				</div>
</div>
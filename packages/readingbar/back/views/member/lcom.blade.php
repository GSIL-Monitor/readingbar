							<div class="row">
                        		<form  class="col-md-12 form-inline" onsubmit="return false">
                        			<div class="input-daterange input-group" id="lcom">
				                               <input type="text" class="input-sm form-control" name="fromDate">
				                               <span class="input-group-addon">至</span>
				                               <input type="text" class="input-sm form-control" name="toDate">
				               	 	</div>
				               	 	<a v-if="lcom.type=='year'" class="btn btn-primary" >年</a>
				               	 	<a v-else class="btn btn-default" v-on:click="setLcomType('year')">年</a>
				               	 	
									<a v-if="lcom.type=='month'" class="btn btn-primary" >月</a>
				               	 	<a v-else class="btn btn-default" v-on:click="setLcomType('month')">月</a>
				               	 	
				               	 	<a v-if="lcom.type=='day'" class="btn btn-primary">日</a>
				               	 	<a v-else class="btn btn-default" v-on:click="setLcomType('day')">日</a>
				               	 	
				               	 	<button class="btn btn-default" v-on:click="doGetLcorm()">查询</button>
                        		</form>
                        	</div>
                            <div class="">
                                <div id="lcorm" ></div>
                            </div>
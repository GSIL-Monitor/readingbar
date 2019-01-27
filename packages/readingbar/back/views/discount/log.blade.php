							<div class="row">
                        		<div class="col-md-12 form-inline">
                        			<div class="input-daterange input-group" id="lc-daterange">
				                               <input type="text" class="input-sm form-control" name="fromDate">
				                               <span class="input-group-addon">至</span>
				                               <input type="text" class="input-sm form-control" name="toDate">
				               	 	</div>
				               	 	<button v-if="lc.type=='year'" class="btn btn-primary" >年</button>
				               	 	<button v-else class="btn btn-default" v-on:click="setlcType('year')">年</button>
				               	 	
									<button v-if="lc.type=='month'" class="btn btn-primary" >月</button>
				               	 	<button v-else class="btn btn-default" v-on:click="setlcType('month')">月</button>
				               	 	
				               	 	<button v-if="lc.type=='day'" class="btn btn-primary">日</button>
				               	 	<button v-else class="btn btn-default" v-on:click="setlcType('day')">日</button>
				               	 	
				               	 	<button class="btn btn-default" v-on:click="doGetLc()">查询</button>
                        		</div>
                        	</div>
                            <div class="">
                                <div id="lc" ></div>
                            </div>
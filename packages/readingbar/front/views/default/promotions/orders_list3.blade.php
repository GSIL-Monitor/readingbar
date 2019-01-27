<!--/promotion-->
<template id="orderslist" v-if="showList=='ordersList'">
				<div class="promotion">
					<ul class="infor-list">       
						<li class="col-md-3">会员昵称</li>           
						<li class="col-md-3">孩子姓名 </li>           
						<li class="col-md-3">产品名称 </li>         
						<li class="col-md-3">购买日期</li>
					</ul>
					<ul class="infor-list2 bgffff" v-for="o in ordersData.data">
						<li class="col-md-3">[[o.parent]]</li>             
						<li class="col-md-3">[[o.child]] </li>           
						<li class="col-md-3">[[o.product_name]] </li>         
						<li class="col-md-3">[[o.completed_at]]</li>
					</ul>
					<!--page-->
					<ul class="pagination pull-right margrt5" v-if="ordersData.last_page > 1">
			    	<li v-if="ordersData.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
		    		<template v-for="p in ordersData.last_page" v-if="Math.abs(ordersData.current_page-(p+1))<=3">
		    			<li v-if="ordersData.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
		    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
		    		</template>
			     	<li v-if="ordersData.current_page < ordersData.last_page" v-on:click="doChangePage(ordersData.last_page)"><a>»</a></li>
		     	    </ul>
				</div>
</template>
				<!--/promotion-->
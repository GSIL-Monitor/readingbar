<!--/promotion-->
<template id="memberslist" v-if="showList=='membersList'">
		<div class="margintop30" style="font-size: 16px;line-height: 40px;">会员列表</div>
		<div class="promotion">
			<ul class="infor-list">
				<li class="col-md-1">序号  </li>            
				<li class="col-md-4">注册日期 </li>           
				<li class="col-md-4">会员昵称</li>           
				<li class="col-md-3">孩子数量 </li> 
			</ul>
			<!--/-->
			<ul class="infor-list2 bgffff" v-for="m in membersData.data">
				<li class="col-md-1">[[m.id]]</li>          
				<li class="col-md-4">[[m.created_at]]</li>           
				<li class="col-md-4">[[m.nickname]]</li>          
				<li class="col-md-3">[[m.children]]</li>
			</ul>
			<!--page-->
			<ul class="pagination pull-right margrt5" v-if="membersData.last_page > 1">
	    	<li v-if="membersData.current_page>1" v-on:click="doChangePage(1)"><a>«</a></li>
    		<template v-for="p in membersData.last_page" v-if="Math.abs(membersData.current_page-(p+1))<=3">
    			<li v-if="membersData.current_page==p+1" class="active" v-on:click="doChangePage(p+1)"><span>[[ p+1 ]]</span></li>
    			<li v-else v-on:click="doChangePage(p+1)"><a>[[ p+1 ]]</a></li>
    		</template>
	     	<li v-if="membersData.current_page < membersData.last_page" v-on:click="doChangePage(membersData.last_page)"><a>»</a></li>
     	    </ul>
		</div>
		<!--/promotion-->
</template>
<div class="content-title">
	给孩子的阅读进行专业定级<br> 
实现全年阅读能力成长监控
</div>
 <br><br>
			   <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon7.png') }}" class="product-icon-300 margin10">
			    <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon6.png') }}" class="product-icon-300 margin10">
			     <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon5.png') }}" class="product-icon-300 margin10">
<br><br> 
   <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div>
			     			<p>价值998元/年  现价398元/年</p>
						</div>
						<em class="btn-img">
							<img src="{{ asset('home/pc/images/customread_11.png') }}">
						</em>
			     	</div>
			   </div>  
			   
			   <br>
			    <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div class="am-text-left">
			     			<p class="font_content_u">
			     				<strog>适合年龄:</strog>
			     				<span>K-12（学龄前至高中三年级）</span>
			     			</p>
			     			<p class="font_content_u">
			     				<strog>服务年限:</strog>
			     				<span>1年</span>
			     			</p>
			     			<p class="font_content_u">
			     				<strog>服务地区:</strog>
			     				<span>全国（除港澳台地区）</span>
			     			</p>
						</div>
			     	</div>
			   </div>  
		       <br>
			  <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div>
			     			<p>服务内容</p>
						</div>
						<em class="btn-img">
							<img src="{{ asset('home/pc/images/customread_11.png') }}">
						</em>
			     	</div>
			   </div> 
			   <div class="product-table row">
					  	 		<div class="col-xs-3">
					  	 			<div class="product-table-header">
					  	 				<span>服务项目</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col1.png') }}">
					  	 			</div>
									<ul>
										<li> 1对1专属导师</li>
										<li>STAR测评系统使用</li>
									</ul>
								</div>
						  	 	<div class="col-xs-2">
						  	 		<div class="product-table-header">
						  	 			<span>服务频次</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col2.png') }}">
					  	 			</div>
									<ul>
										<li>工作日<br>9:00-18:00</li>
										<li>1年3次</li>
									</ul>
								</div>
						  	 	<div class="col-xs-5">
						  	 		<div class="product-table-header">
						  	 			<span>具体内容</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col3.png') }}">
					  	 			</div>
									<ul>
										<li>服务期内有任何问题，直接向专属导师咨询。</li>
										<li>每次测试完成后，1个工作日内，专属导师上传中英文解读报告至官网【个人中心】</li>
									</ul>
								</div>
						  	 	<div class="col-xs-2">
						  	 		<div class="product-table-header">
						  	 			<span>备注</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col4.png') }}">
					  	 			</div>
									<ul>
										<li></li>
										<li>建议每半年做一次测评。<a href="{{ url('files/sample/StarEnglishReport.pdf') }}" target="_blank">【查看样例】</a></li>
										
									</ul>
								</div>
					  	 	</div>
			      <br style="clear:both"><br>
			   		@if(auth('member')->isLoged())
			   			<a href="javascript:void(0)" class="btn-local"  data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}" v-on:click="setProduct(10)">
				   			<em class="circle-left"></em>
				   			点击购买
				   			<em class="circle-right"></em>
				   		</a>
					@else
						<a href="javascript:void(0)" class="btn-local" v-on:click="alertLogin()">
				   			<em class="circle-left"></em>
				   			点击购买
				   			<em class="circle-right"></em>
				   		</a>
					@endif	
			   		
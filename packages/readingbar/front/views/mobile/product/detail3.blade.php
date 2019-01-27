<div class="content-title">
	选择适合自己的原版书，让阅读不再盲目<br> 
	18万本原版书阅读理解测试，让阅读明明白白
</div>

			   <br><br>
			   <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon7.png') }}" class="product-icon-300 margin10">
			    <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon6.png') }}" class="product-icon-300 margin10">
			     <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon5.png') }}" class="product-icon-300 margin10">
			      <img src="{{ asset('home/wap/images/wap20170523/product/detail-icon2.png') }}" class="product-icon-300 margin10">
<br><br> 
   <div class="component-green-tbox font_content_g">
			     	<div class="box">
			     		<div>
			     			<p>价值2988元/年  现价1298元/年</p>
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
										<li>AR测试系统使用</li>
										<li>STAR测评系统使用</li>
										<li>阶段成长分析报告</li>
										<li>AR书单搜索</li>
										<li>其他升级服务</li>
									</ul>
								</div>
						  	 	<div class="col-xs-2">
						  	 		<div class="product-table-header">
						  	 			<span>服务频次</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col2.png') }}">
					  	 			</div>
									<ul>
										<li>工作日<br>9:00-18:00</li>
										<li>无限次</li>
										<li>1年3次</li>
										<li>1年2次</li>
										<li>随时</li>
										<li>随时</li>
									</ul>
								</div>
						  	 	<div class="col-xs-5">
						  	 		<div class="product-table-header">
						  	 			<span>具体内容</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col3.png') }}">
					  	 			</div>
									<ul>
										<li>服务期内有任何问题，直接向专属导师咨询。</li>
										<li>每本AR分级读物都会配套一份或多份测试题目，每读完一本书都可随时进行测试，测试完成后可自行查看英文报告，书籍需自行购买。</li>
										<li>每次测试完成后，1个工作日内，专属导师上传中英文解读报告至官网【个人中心】</li>
										<li>报告内容含：测试系统原始报告&相关数据分析及英文阅读建议</li>
										<li>书单经导师们亲自一本一本阅读后定期更新。</li>
										<li>Reading Camp，家长微课等。</li>
									</ul>
								</div>
						  	 	<div class="col-xs-2">
						  	 		<div class="product-table-header">
						  	 			<span>备注</span>
					  	 				<img alt="" src="{{ asset('home/pc/images/products/tableHead/col4.png') }}">
					  	 			</div>
									<ul>
										<li></li>
										<li>AR在库图书约18万册。<a href="{{ url('files/sample/ArTest.pdf') }}"  target="_blank">【查看样例】</a></li>
										<li><a href="{{ url('files/sample/StarEnglishReport.pdf') }}" target="_blank">【查看样例】</a></li>
										<li><a href="{{ url('files/sample/PhaseAnalysisReport.pdf') }}"  target="_blank">【查看样例】</a></li>
										<li>在官网【个人中心】使用此功能。</li>
										<li>部分收费</li>
										
									</ul>
								</div>
					  	 	</div>
			     <br style="clear:both"><br>
			   		@if(auth('member')->isLoged())
			   			<a href="javascript:void(0)" class="btn-local"  data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0}" v-on:click="setProduct(3)">
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
			   		
<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
<style>
body{background-color:#f5f5f5;}
</style>
<section id="index">
	<div id="banner" >
		<div id="myCarousel" class="carousel slide">
			  <!-- 轮播（Carousel）指标 -->
			  <ol class="carousel-indicators"> 
		    	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
<!-- 		    	<li data-target="#myCarousel" data-slide-to="1" ></li> -->
			  </ol> 
			  <!-- 轮播（Carousel）项目 -->
			  <div class="carousel-inner">
			  		<div class="item active">
			  			<a href="javascript:void(0)"><img src="{{url('home/pc/images/banner/20181107.jpg')}}"  class="am-img-responsive"></a>
			  			<div class="banner-info">
			  				<div class="title">英文分级阅读服务专家</div>
			  				<div class="content">
				  				您想了解孩子的英文阅读水平吗？<br/>
								您想了解孩子当前适合阅读什么原版书吗？<br/>
								您想了解孩子阅读的书到底理解多少吗？
							</div>
			  				<div class="btn">
			  					<a href="#AR">Go</a>
			  				</div>
			  			</div>
			  		</div>
<!-- 			  		<div class="item"> -->
<!-- 			  			<a href="{{ url('activity/50FamousWriters') }}"><img src="{{url('home/pc/images/banner/20181107.jpg')}}"  class="am-img-responsive"></a> -->
<!-- 			  			<div class="banner-info"> -->
<!-- 			  				<div class="title">5-18岁英语分级阅读服务专家</div> -->
<!-- 			  				<div class="content">蕊丁吧提供专业的少儿英文阅读服务，致力于5-18岁孩子英文阅读兴趣和阅读培养，是国内第一家基于大数据应用的少儿英文分级阅读在线定制服务平台。</div> -->
<!-- 			  				<div class="btn"> -->
<!-- 			  					<a href="javascript:void(0)">Go</a> -->
<!-- 			  				</div> -->
<!-- 			  			</div> -->
<!-- 			  		</div> -->
			  </div>
			  <!-- 轮播（Carousel）导航 -->
		</div>
		<div id="pendant" >
				<a href="https://hosted14.renlearn.com/5561679/Public/RPM/Login/Login.aspx?srcID=s" class="btn">测试系统入口</a>
				<a href="{{ url('introduce/userGuide') }}" class="btn">测试系统指南</a>
		</div>
		<div id="login-register-form" v-if="!logged">
			<components :is="currentLRForm"/>
		</div>
	</div>
	<script>
		$('#myCarousel').carousel({
			interval:4000
		});
	</script>
	<div id="index-buttons">
		<a href="{{ url('/ranking') }}">
			<img class="img" src="{{ asset('home/pc/images/home/ranking.png') }}"/><div class="title">小达人排行</div>
		</a>
		<a href="{{ url('/activity/PublicBenefitActivities') }}">
			<img class="img" src="{{ asset('home/pc/images/home/angel.png') }}"/><div class="title">阅读小天使</div>
		</a>
		<a href="{{ url('/introduce/RDMessenger') }}">
			<img class="img" src="{{ asset('home/pc/images/home/recruit.png') }}"/><div class="title">蕊丁吧招募</div>
		</a>
	</div>
	<div id="ARZ">
		<div class="info">
			<div class="title">
						<div>Raz-Kids在线阅读</div>
						<div><hr/></div>
			</div>
			<div class="suit"><span class="fc">适合年龄：</span>幼儿园中班到小学3年级</div>
			<div class="recommend_crowd"><span class="fc">推荐人群：</span><span class="recommend">处于英文阅读启蒙阶段的小朋友</span></div>
			<div class="qrcode">
				<img src="{{ asset('home/pc/images/home/qrcode/qrcode-raz-teacher.jpg') }}"/>
				<div class="memo">
					<div>请扫描二维码</div><div>添加老师微信</div>
				</div>
			</div>
		</div>
		<div class="img">
			<img src="{{ asset('home/pc/images/home/raz-kids.jpg') }}"/>
		</div>
	</div>
	<div style="clear:both"></div>
	<div id="AR">
		<div>
			<div>
				<a  href="javascript:void(0)"  :class="ar_tab=='test-service'?'btn-service active':'btn-service'" v-on:click="changeArTab('test-service')">测试系统服务</a>
				<div class="btn-service-sub" v-if="ar_tab=='test-service'">
					<a  href="javascript:void(0)" :class="test_tab=='experience-service'?'active':''" v-on:click="changeTestTab('experience-service')">体验版</a>
					<a  href="javascript:void(0)" :class="test_tab=='year-service'?'active':''" v-on:click="changeTestTab('year-service')">年服务</a>
				</div>
			</div>
			<div>
				<a href="javascript:void(0)"  :class="ar_tab=='ar-service'?'btn-service active':'btn-service'" v-on:click="changeArTab('ar-service')">AR图书借阅</a>
			</div>
			
		</div>
		<div style="clear:both"></div>
		<div v-if="ar_tab=='test-service' && test_tab=='experience-service'">
			<!--/ 测试系统服务-体验版  -->
			<div>
				<div class="product-panel product-ee">
					<div class="title">
						<div>单次STAR测评</div>
						<div><hr/></div>
						<div>150元/次</div>
					</div>
					<div class="info  info-single-start">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div><strong>推荐人群</strong>：首次体验测试系统<br/><span style="padding-left:80px;">或想了解孩子当前英文阅读能力水平的家长</span></div>
						<div><strong>服务有效期</strong>：15天</div>
						<div><strong>服务包含</strong>：测试后一个工作日，提供中、英文STAR测试报告<br/><span style="padding-left:80px;">以及20本个性化推荐书单</span></div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy(8)" >立即购买</a>
					</div>
				</div>
				<div class="product-panel product-ee">
					<div class="title">
						<div>综合系统月体验</div>
						<div><hr/></div>
						<div>366元</div>
					</div>
					<div class="info info-integrated-month">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div><strong>推荐人群</strong>：想全面体验测试服务和借阅服务的家长</div>
						<div><strong>服务有效期</strong>：30天</div>
						<div><strong>服务包含</strong>：</div>
						<div>（1）单次STAR测评</div>
						<div>（2）一个月书籍测试Plus服务</div>
						<div>（3）一次6本AR图书免费借阅，借阅期40天</div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy(13)">立即购买</a> 
					</div>
				</div>
			</div>
			<!--/测试系统服务-体验版  -->
		</div>
		<!--/ 测试系统服务-年服务  -->
		<div v-if="ar_tab=='test-service' && test_tab=='year-service'">
				<div class="product-panel product-y">
					<div class="title">
						<div>
							书籍测试Plus
						</div>
						<div><hr/></div>
						<div>999元/年</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：小学三年级到高三</div>
						<div><strong>推荐人群</strong>：想了解孩子平时阅读书籍的理解程度、<br/><span style="padding-left:60px;">加强nonfiction文章阅读的家长</span></div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div>（1）书籍测试（不限次数）</div>
						<div>（2）nonfiction文章在线阅读及评估测试（不限次数）</div>
						<div><strong>增值服务</strong>：可联系老师为孩子设置AR POINTS目标积分 <img v-on:mouseenter="showTip(1,$event)"  class="doubt" src="{{ asset('home/pc/images/home/icon/icon-doubt.png') }}"/></div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy(17)">立即购买</a> 
					</div>
				</div>
				<div class="product-panel product-y">
					<div class="title">
						<div>综合系统服务</div>
						<div><hr/></div>
						<div>1298元/年</div>
					</div>
					<div class="info">
						<div><strong>适合年龄</strong>：幼儿园大班到高三</div>
						<div><strong>推荐人群</strong>：有足够的时间和精力关注孩子阅读，可通过监测<br/><span style="padding-left:60px;">系统数据，引导孩子培养英文阅读习惯的家长</span></div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div>（1）一年3次STAR测试 <img v-on:mouseenter="showTip(2,$event)"  class="doubt" src="{{ asset('home/pc/images/home/icon/icon-doubt.png') }}"/>，测试后，一个工作日提供一<br/><span style="padding-left:31px;">份中、英文STAR测试报告以及20本个性化推荐书单</span></div>
						<div>（2）书籍测试Plus服务</div>
						<div><strong>增值服务</strong>：</div>
						<div>（1）可联系老师为孩子设置AR POINTS目标积分 <img v-on:mouseenter="showTip(1,$event)"  class="doubt" src="{{ asset('home/pc/images/home/icon/icon-doubt.png') }}"/></div>
						<div>（2）全年阅读数据报告一份</div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy(18)">立即购买</a> 
					</div>
				</div>
				<div class="product-panel product-y">
					<div class="title">
						<div>定制阅读服务</div>
						<div><hr/></div>
						<div>
							6688元/年 <br/>
							<span>押金800元 </span>
							<span class="memo">（服务到期后退回）</span>
						</div>
					</div>
					<div class="info" >
						<div><strong>适合年龄</strong>：幼儿园大班到小学六年级</div>
						<div><strong>推荐人群</strong>：没有太多时间精力关注孩子阅读，需要专业老师<br/><span style="padding-left:60px;">个性化服务的家长</span></div>
						<div><strong>服务有效期</strong>：1年</div>
						<div><strong>服务包含</strong>：</div>
						<div>（1）综合系统服务</div>
						<div>（2）每个月个性化阅读计划定制服务（配书、阅读建议、<br/><span style="padding-left:31px;">阅读任务、激励机制）</span></div>
						<div>（3）1对1专属导师全年跟踪服务，分析测试数据，及时调<br/><span style="padding-left:31px;">整阅读计划</span></div>
						<small>*费用含12次往返顺丰快递费用</small>
						<div><strong>增值服务</strong>：</div>
						<div>（1）可联系老师为孩子设置AR POINTS目标积分 <img v-on:mouseenter="showTip(1,$event)" class="doubt" src="{{ asset('home/pc/images/home/icon/icon-doubt.png') }}"/></div>
						<div>（2）全年阅读数据报告一份</div>
						<div>（3）图书指定、预约服务</div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy(1)">立即购买</a> 
					</div>
				</div>
		</div>
		<!--/测试系统服务-年服务  -->
		<!--/ ar阅读服务  -->
		<div v-if="ar_tab=='ar-service' ">
				<div class="product-panel product-ar">
					<div class="title">
						<div>AR图书借阅</div>
						<div><hr/></div>
					</div>
					<div class="info">
						<div>
							<div>A <span style="font-size:20px">6本借阅<span class="fc"> 99元 </span></span> （押金<span class="fc">300元</span>）</div>
							<div>B <span style="font-size:20px">12本借阅<span class="fc"> 169元</span></span> （押金<span class="fc">600元</span>）</div>
						</div>
						<div>
							<div><strong>借阅期限</strong>：40天</div>
							<div><strong>购买条件</strong>：</div>
							<div>（1）服务期内会员</div>
							<div>（2）STAR报告中GE指数不大于6</div>
							<div>	*必须同时满足以上两个条件</div>
						</div>
						<div>
							<div><strong>温馨提示</strong>：</div>
							<div>（1）老师根据STAR测试数据和孩子阅读偏好科学选书</div>
							<div>（2）购买后2个工作日内上传书单，手机短信提醒确认书单</div>
							<div>（3）含往返顺丰快递费</div>
							<div>（4）还书后在线申请退押金，5个工作日内退回</div>
						</div>
					</div>
					<div class="btn-buy">
							<a  href="javascript:void(0)" v-on:click="doBuy('select')">立即购买</a> 
					</div>
				</div>
		</div>
		<!--/ ar阅读服务  -->
	</div>
	<div id="RD">
		<div>
				蕊丁吧，取自READINGBAR音译<br/>
				国内第一家AR系统线上服务平台<br/>
				专注于K12英文阅读兴趣和习惯培养
		</div>
	</div>
	<div id="US">
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-telphone.png') }}"/></div><div class="title">客服电话</div><div class="content">400 625 9800</div></div>
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-envelope.png') }}"/></div><div class="title">联系邮箱</div><div class="content">biz@readingbar.net</div></div>
		<div class="text"><div class="icon"><img src="{{ asset('home/pc/images/home/icon/icon-clock.png') }}"/></div><div class="title">工作时间</div><div class="content">周一至周五 9:00-18:00</div></div>
		
		<div class="qrcode">
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-customer-service.jpg') }}"/><div class="title">客服微信</div></div>
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-subscribe-number.jpg') }}"/><div class="title">订阅号</div></div>
			<div><img class="img" src="{{ asset('home/pc/images/home/qrcode/qrcode-micro-shop.jpg') }}"/><div class="title">微店</div></div>
		</div>
	</div>
	<!-- 选购模态框 -->
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"  id="buyModal">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">购买流程</h4>
		      </div>
		      <div class="modal-body">
		        	<div id="progress" >
					 	<div>
			 				<img src="{{ url('home/pc/images/products/20171107/step_yes.png') }}"  v-if="step>=1">
			 				<img src="{{ url('home/pc/images/products/20171107/step_no.png') }}" v-else>
			 				<div>第1步：选择服务</div>
			 			</div>
			 			<div>
			 				<img src="{{ url('home/pc/images/products/20171107/step_yes.png') }}"  v-if="step>=2">
			 				<img src="{{ url('home/pc/images/products/20171107/step_no.png') }}" v-else>
			 				<div>第2步：付费须知</div>
			 			</div>
			 			<div>
			 				<img src="{{ url('home/pc/images/products/20171107/step_yes.png') }}"  v-if="step>=3">
			 				<img src="{{ url('home/pc/images/products/20171107/step_no.png') }}" v-else>
			 				<div>第3步：选择孩子</div>
			 			</div>
					</div>
					<div id="step1" v-if="step==1">
							<!--服务选择-->
							<div class="option">
					 			<img src="{{ url('home/pc/images/products/20171107/radio_yes.png') }}" v-if="product_id===14" > 
					 			<img src="{{ url('home/pc/images/products/20171107/radio_no.png') }}" v-else v-on:click="doBuy(14)"> 
					 			&nbsp;<span>A:6本AR分级读物单次借阅（99元）</span>
					 		</div>
					 		<div class="option">
					 			<img src="{{ url('home/pc/images/products/20171107/radio_yes.png') }}" v-if="product_id===15" > 
					 			<img src="{{ url('home/pc/images/products/20171107/radio_no.png') }}" v-else v-on:click="doBuy(15)"> 
					 			&nbsp;<span>B:12本AR分级读物单次借阅（169元）</span>
					 		</div>
					 		<!--/服务选择-->
					</div>
					<div id="step2" v-if="step==2">
						<strong>一、 蕊丁吧会员说明</strong><br>
						1. 本服务内容及使用须知适用于蕊丁吧所有注册会员。<br><br>
						
						<strong>二、系统账号使用说明</strong><br>
						1. 会员付费或激活卡密后，系统会自动往注册邮箱发送系统账号。<br>
						2. 系统账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。<br>
						3. 蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。<br>
						   如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。<br>
						4. 定制服务会员（只限于定制服务会员）在服务有效期内，可申请最多1次、最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。<br>
						   解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。<br>
						5. 会员使用测试系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。<br>
						6. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。<br>
						7. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。<br><br>
						
						<strong>三、 押金、损耗、赔偿及还书</strong><br>
						1.会员在购买定制服务或借阅产品时，需要缴纳图书借阅押金。<br>
						2.蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：<br>
						2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。<br>
						2.2 若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
						2.3 出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。<br>
						3.书籍定价<br>
						书籍的价值以每本书的RMB标价为准。<br>
						4.书籍寄回说明<br>
						为方便您能够顺利按时将图书寄回，我们已将顺丰快递单放入盒子中，还书时您只需在签名处签字，并把盒子以及二维码快递单给上门取件的顺丰快递员即可。<br>
						4.1.寄件方式 ：顺丰到付。<br>
						4.2.下单方式：可选择以下三种方式之一。<br>
						电话：拨打“95338”预约上门取件。<br>
						网站：登录 http://www.sf-express.com预约上门取件。<br>
						微信：关注【顺丰速运】公众号，点击“寄快递”中的“收派员上门”。<br>
						4.3.注意事项<br>
						运单产品类型，选择最低运费即可，如北京、天津用户请选择【顺丰标快】；其他地区用户请选择【顺丰特惠】。<br>
						备注：因没有按照说明选择/填写运单信息，导致运费增加的部分，将从押金扣除。<br><br>
						
						
						<strong>四、 退费说明</strong><br>
						1.除定制服务，其他产品付费后不予退费。<br>
						2.仅限于定制服务会员在付费后30日内可申请终止服务并申请退费，蕊丁吧在扣除综合系统服务费及10%服务费用后，将其余费用予以退回，退费后用户可继续享受综合系统服务；<br>
						  付费后超过30日，会员费用不予退回。<br>
						3.定制服务借阅押金在会员归还全部书籍（无破损或丢失）后于15个工作日内退还；普通借阅押金，在会员在线申请退押金后5个工作日内退还。<br>
						4.定制服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本1元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。<br>
						5.普通借阅服务到期后5日内未还书的，将按照每天每本1元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。<br>
					</div>
					<div id="step3" v-if="step==3">
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							  <!-- Indicators -->
							  <!-- Wrapper for slides -->
							  <div class="carousel-inner" role="listbox">
							  <template v-for="i in Math.ceil(students.length/3)">
							  	<div class="item active"  v-if="i===0">
							  	  <template v-for="s in students"  v-if="$index>=3*i && $index<3*(i+1)">
								      <div class="child active" v-if="s.id===student_id" v-on:click="selectStudent(s)">
								      	<img :src="s.avatar" class="avatar">
								      	<div  class="nickname">[[ s.nick_name ]]</div>
								      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
								      </div>
								       <div class="child" v-else  v-on:click="selectStudent(s)">
								      	<img :src="s.avatar" class="avatar">
								      	<div  class="nickname">[[ s.nick_name ]]</div>
								      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
								      </div>
							      </template>
							    </div>
							    <div class="item" v-else>
							        <template v-for="s in students"   v-if="$index>=3*i && $index<3*(i+1)">
								      <div class="child active" v-if="s.id===student_id"  v-on:click="selectStudent(s)">
								      	<img :src="s.avatar" class="avatar">
								      	<div  class="nickname">[[ s.nick_name ]]</div>
								      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
								      </div>
								       <div class="child" v-else  v-on:click="selectStudent(s)">
								      	<img :src="s.avatar" class="avatar">
								      	<div  class="nickname">[[ s.nick_name ]]</div>
								      	<div  class="point"><img src="{{ url('home/pc/images/ioc-rdm.png') }}">[[ s.point ]]</div>
								      </div>
							      </template>
							    </div>
							  </div>
							  </template>
							  <!-- Controls -->
							  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-left.png') }}"">
							  </a>
							  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							    <img class="glyphicon" alt="" src="{{ url('home/pc/images/btn-right.png') }}"">
							  </a>
							</div>
					</div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default"  v-on:click="pre()" v-if="step==2 && (this.product_id == 14 || this.product_id == 15)">上一步</button>
		        <button type="button" class="btn btn-default"  v-on:click="pre()" v-if="step==3">上一步</button>
		        <button type="button" class="btn btn-default"  v-on:click="next()"  v-if="step==2">同意</button>
		        <button type="button" class="btn btn-default"  v-on:click="next()" v-else>下一步</button>
		      </div>
		    </div>
		  </div>
		</div>
	<!-- /选购模态框 -->
</section>
<!-- 登录框组件 -->
<template id="login">
	<div class="link-register">还没有注册 <a href="javascript:void(0)" v-on:click="goRegister()">立即注册</a></div>
	<div class="tab">
		<a href="javascript:void(0)" v-on:click="changeMode('normal')"  :class="mode == 'normal'?'active':''">账号登录</a>
		<a href="javascript:void(0)" v-on:click="changeMode('messge')" :class="mode != 'normal'?'active':''">短信验证登录</a>
	</div>
	<div style="clear: both"></div>
	<template v-if="mode == 'normal'">
		<div class="control">
			<label>手机号或邮箱</label>
			<input v-model="account"  type="text"  autocomplete="off"/>
		</div>
		<div class="control">
			<label>密码</label>
			<input v-model="password"  type="password"  autocomplete="off"/>
		</div>
		<div class="remember"><input type="checkbox" v-model="remember"/>记住密码</div>
		<div class="btn-login">
			<a href="javascript:void(0)" v-if="isLogin">正在登录...</a>
			<a href="javascript:void(0)" v-else v-on:click="doLogin()">登录</a>
		</div>
		<div class="forgoten"><a href="{{url('/forgoten')}}">忘记密码</a></div>
	</template>
	<template v-else>
		<div class="control">
			<label>手机号</label>
			<input  v-model="tel"/>
		</div>
		<div class="control message">
			<label>验证码</label>
			<input  v-model="code"/>
			<a href="javascript:void(0)" v-if="codeSending">正在发送</a>
			<a href="javascript:void(0)" v-else v-on:click="doSendCode()">发送验证码</a>
		</div>
		<div class="remember" style="clear:both"></div>
		<div class="btn-login">
			<a href="javascript:void(0)" v-if="isLogin">正在登录...</a>
			<a href="javascript:void(0)" v-else v-on:click="doLogin()">登录</a>
		</div>
	</template>
</template>
<script>
Vue.component('v-login', {
   template: '#login',
   data: function () {
    return {
		mode: 'normal',
		account: '',
		password: '',
		remember: null,
		tel: '',
		code: '',
		isLogin: false,
		codeSending: false
    }
  },
  methods: {
	  goRegister:function(){
		this.$parent.setCurrentLRForm('v-register');
	  },
	  changeMode:function (m) {
		this.mode = m;
	  },
	  doLogin:function () {
		  var _this = this;
		  var url = '{{url("/api/loginByPassword")}}';
		  var data = {
				  		username: _this.account,
						password: _this.password
				 	}
		 if(_this.mode != 'normal') {
			 var url = '{{url("/api/loginByCode")}}';
			  var data = {
					  		username: _this.tel,
							code: _this.code
					 	}
		 }
		 $.ajax({
			url: url,
			data:data,
			dataType: 'json',
			type: 'post',
			beforeSend: function(){
				_this.isLogin = true;
			},
			success: function (json) {
				window.location.reload();
			},
			error: function(e) {
				if(e.status == 400) {
					appAlert({
						title: '提示',
						msg: e.responseJSON.message
					})
				}else{
					appAlert({
						title: '提示',
						msg: e.status + '错误'
					})
				}
			},
			complete: function(){
				_this.isLogin = false;
			},
		 })
	  },
	  doSendCode:function () {
		  var _this = this
		  $.ajax({ 
				url:"{{ url('api/message/sendLoginCode')}}",
				type:"GET",
				data:{username:this.tel},
				dataType:"json",
				beforeSend: function(){
					_this.codeSending = true;
				},
				success:function(json){
				},
				complete: function(){
						_this.codeSending = false;
				}
			});
	  }
  }
});
</script>
<!-- /登录框组件 -->
<!-- 注册框组件 -->
<template id="register">
	<div class="control" style="margin-top: 0px !important">
		<input  v-model="username" placeholder="手机号/邮箱"/>
	</div>
	<div class="error" 	v-if="errors.username">[[ errors.username[0] ]]</div>
	<div class="error" 	v-else-if="errors.cellphone">[[ errors.cellphone[0] ]]</div>
	<div class="error" 	v-else-if="errors.email">[[ errors.email[0] ]]</div>
	<div class="control image-code">
		<input  v-model="captcha" placeholder="图像验证"/>
		<img src="{{ url('captcha/register?'.rand(0001,9999)) }}" alt="图像验证码" id="captcha" v-on:click="refreshCaptcha()"/>
	</div>
	<div style="clear: both;"></div>
	<div class="error" v-if="errors.captcha">[[ errors.captcha[0] ]]</div>
	<div class="control message">
		<input  v-model="code" placeholder="验证码"/>
		<a href="javascript:void(0)" v-if="codeSending">正在发送</a>
		<template v-else>
			<a href="javascript:void(0)" v-if="captcha" v-on:click="doSendCode()">发送验证码</a>
			<a href="javascript:void(0)" v-else style="background-color:#f5f5f5;color:black;" >发送验证码</a>
		</template>
	</div>
	<div style="clear: both;"></div>
	<div class="error" v-if="errors.code">[[ errors.code[0] ]]</div>
	<div class="error" v-if="errors.verification_code_expire">[[ errors.verification_code_expire[0] ]]</div>
	<div class="control">
		<input  v-model="password" placeholder="登录密码" type="password"/>
	</div>
	<div class="error" v-if="errors.password">[[ errors.password[0] ]]</div>
	<div class="control">
		<input  v-model="password_confirmation" placeholder="重复密码" type="password"/>
	</div>
	<div class="control">
		<input  v-model="nickname" placeholder="昵称"/>
	</div>
	<div class="error" v-if="errors.nickname">[[ errors.nickname[0] ]]</div>
	<div class="btn-register">
		<a href="javascript:void(0)" v-if="isRegister">正在注册...</a>
		<a href="javascript:void(0)" v-else v-on:click="doRegister()">确认注册</a>
	</div>
	<div class="register-bottom">
		<a href="javascript:void(0)" v-on:click="goLogin">直接登录</a>
		<a href="{{url('/forgoten')}}" >找回密码</a>
	</div>
</template>
<script>
Vue.component('v-register', {
  data: function () {
    return {
        username: '',
        captcha: '',
        code: '',
        password: '',
        password_confirmation: '',
        nickname: '',
        errors: {},
        isRegister: false,
		codeSending: false
    }
  },
  template: '#register',
  methods: {
	  goLogin:function(){
		 this.$parent.setCurrentLRForm('v-login');
	  },
	  refreshCaptcha:function () {
		  $("#captcha").attr('src',"{{ url('captcha/register?') }}" + Date.parse(new Date()))
	  },
	  doSendCode:function () {
		  var _this = this
		  $.ajax({ 
				url:"{{ url('api/message/sendCodeForRegister') }}",
				type:"POST",
				data:{
					username:this.username,
					captcha:this.captcha
				},
				dataType:"json",
				beforeSend: function(){
					_this.errors = {};
					_this.codeSending = true;
				},
				success:function(json){
					if(json.status){
						appAlert({
							title:'提示',
							msg:json.success
						})
					}else{
						appAlert({
							title:'错误',
							msg:json.error
						})
					}
				},
				complete: function(){
						_this.codeSending = false;
				}
			});
	  },
	  doRegister:function () {
		  var _this = this
		  $.ajax({
			url: "{{url('api/register')}}",
			data:{
				username: _this.username,
		        captcha:_this.captcha,
		        code:_this.code,
		        password: _this.password,
		        password_confirmation: _this.password_confirmation,
		        nickname: _this.nickname
			},
			dataType: 'json',
			type: 'post',
			beforeSend: function(){
				_this.isRegister= true;
			},
			success: function (json) {
				_this.goLogin()
				appAlert({
						title: '提示',
						msg: json.message
					})
			},
			error: function(e) {
				if(e.status == 400) {
					_this.errors = e.responseJSON.errors;
					appAlert({
						title: '提示',
						msg: e.responseJSON.message
					})
				}else{
					appAlert({
						title: '提示',
						msg: e.status + '错误'
					})
				}
			},
			complete: function(){
				_this.isRegister = false;
			},
		 })
	  }
  }
});
</script>
<!-- /注册框组件 -->

<script>
new Vue({
	el: 'section',
	data: {
		ar_tab: 'test-service',
		test_tab: 'experience-service',
		logged: {!! auth('member')->check()?'true':'false' !!},
		currentLRForm: 'v-login',
		students: {!! $students->toJson() !!},
		products: {!! $products->toJson() !!},
		step:1,
		enterStep: false,
		selectService: '',
		student: null,
		student_id: null,
		protocol: null,
		product_id: null
	},
	methods: {
		setCurrentLRForm:function (c) {
			this.currentLRForm = c;
		},
		changeArTab:function (tab) {
			this.ar_tab = tab
		},
		changeTestTab:function (tab) {
			this.test_tab = tab
		},
		doBuy:function(pid){
			var _this = this
			this.product_id = null
			if (!this.logged) {
				appAlert({
					title: '登录提醒',
					msg: '您尚未登录，请先登录！',
					ok:{
						callback: function(){
							window.location.href = '/#'
						}
					}
				})
			}else{
				if (pid === 'select') {
					this.step = 1;
				}else{
					this.selectProduct(pid);
				}
				$('#buyModal').modal('show');
			}
		},
		// 选择产品
		selectProduct:function (pid) {
				// 判断是否有孩子 没有则跳转孩子添加界面
				if (this.students.length=== 0) {
					appAlert({
						title: '提示',
						msg: '您名下没有孩子,请去添加孩子!',
						ok: {
							text: '添加孩子',
							callback: function () {
								window.location.href="{{ url('/member/children/create') }}"
							}
						}
					});
					return false;
				}
				if (this.checkProduct(pid)) {
					this.product_id = pid;
					this.step=2;
				}
		},
		// 校验产品
		checkProduct:function (pid) {
			for(i in this.products) {
				if (this.products[i].id == pid){
					var p = this.products[i];
					var msg = null;
					if(p.show == 0) {
						msg='产品不存在！';
					}else if(p.quantity == 0){
						msg='产品已售完！';
					}
					if(msg){
						appAlert({
							title: '提示',
							msg: msg
						});
						return false;
					}
					return true;
					break;
				}
			}
			appAlert({
				title: '提示',
				msg: '产品不存在！'
			});
			return false;
		},
		// 选择孩子
		selectStudent: function (s){
			this.student_id=s.id;
			this.student = s;
		},
		// 取消
		cancel:function() {
			this.student_id=null;
			this.protocol=null;
			this.product_id=null;
			this.selectService='';
			this.student = null;
			this.step = 1;
			this.enterStep = false;
			window.location.href="#product";
		},
		// 下一步
		next:function(){
			switch(this.step){
				case 1:
					if (this.product_id){
						this.step++;
						window.location.href="#product";
					}else{
						$("#buyModal").modal('hide');
						appAlert({
							title: '提示',
							msg: '请选择产品服务！',
							ok: {
								callback: function(){
									$("#buyModal").modal('show');
								}
							}
						});
					}
					break;
				case 2:
					// 同意须知
					this.protocol=true;
					this.step++;
					window.location.href="#product";
					break;
				case 3:
					if (this.student_id) {
						url="{{url('member/pay/confirm')}}";
						window.location.href=url+"?product_id="+this.product_id+"&protocol="+this.protocol+"&student_id="+this.student_id;
					}else{
						$("#buyModal").modal('hide');
						appAlert({
							title: '提示',
							msg: '请选择孩子！',
							ok: {
								callback: function(){
									$("#buyModal").modal('show');
								}
							}
						});
					}
					break;
			}
		},
		pre:function(){
			this.step--;
		},
		// 问号提示
		showTip:function (t,e) {
			var msg = '';
			switch (t){
				case 1: msg = "有目标就更有动力！快联系老师为孩子设置个性化目标积分吧！";break;
				case 2: msg = "良心建议半年测一次；频繁测试，数据变化不大，家长容易焦虑，且会引起孩子反感";break;
			}
			$(e.target).popover({content:msg,trigger:'hover',placement: 'top'}).popover('show')
		}
	}
})
</script>
<style>
<!--
body{
	background-color:#fff;
}
-->
</style>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

<!-- 继承整体布局 -->
@extends('front::mobile.common.main')

@section('content')
<!-- 扩展内容-->
<section>
    <div data-am-widget="tabs"class="am-tabs container bgeeeeee ">
	      <ul class="am-tabs-nav userGuide-titile  am-cf">
	          <li class="am-active"><a href="[data-tab-panel-0]" >STAR测评流程</a></li>
	          <li class=""><a href="[data-tab-panel-1]">STAR测评QA</a></li>
	          <li class=""><a href="[data-tab-panel-2]">AR测试流程    </a></li>
	          <li class=""><a href="[data-tab-panel-3]">AR测试QA     </a></li>
	          <li class=""><a href="[data-tab-panel-4]">根据STAR测评选书</a></li>
	      </ul>
	        <div class="am-tabs-bd userGuide-list  am-figure am-figure-default" >
	        	<div class="font_title_ddd color4ad2be am-text-center">STAR测评：英文阅读能力测评</div>
	        	<div class="font_title_ddd color4ad2be am-text-center">AR测试：原版书阅读理解测试</div>
	        </div>
	      <div class="am-tabs-bd userGuide-list  am-figure am-figure-default" data-am-widget="figure"  data-am-figure="{  pureview: 'true' }">
	      <!--/-->
				<div data-tab-panel-0 class="am-tab-panel am-active">
	
					 <img src="{{url('home/wap/images/page1/STAR_03.jpg')}}">
					
					 <img src="{{url('home/wap/images/page1/STAR_05.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_06.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_07.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_08.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_09.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_10.jpg')}}">
					 <img src="{{url('home/wap/images/page1/STAR_11.jpg')}}">
				</div>
				<div data-tab-panel-1 class="am-tab-panel ">
						<div class="page-nr">
							<b class="color4ad2be">1、购买产品后，测试账号何时能收到？</b>
							<p>购买后，1个工作日内账号会发送至注册邮箱，同时有短信提醒。</p>
							<br>
							<b class="color4ad2be">2、购买产品后，该做些什么？</b>
							<p>尽快完成第一次STAR测评--1个工作日后到官网【个人中心】查看中英文解读报告--等待专属导师主动致电答疑--为孩子自行准备AR分级读物--阅读书籍后进行AR测试。（服务有效期内随时联系专属导师咨询相关问题）</p>
							<br>
							<b class="color4ad2be">3、暑假期间购买产品，注册时年级填写哪一个？</b>
							<p>每年8月1日，蕊丁吧网站注册会员的孩子年级全部自动升一级！自8月2日起，请所有新注册会员一定要填写9月开学后的新年级。（我们将根据家长填写的实际年级发送对应年级的系统账号，所以这个信息很重要哦。）</p>
							<br>
							<b class="color4ad2be">4、STAR测评账号是哪个？</b>
							<p>您邮箱收到的账号，readingbar****。</p>
							<br>
							<b class="color4ad2be">5、账号可以多人使用吗？</b>
							<p>不可以，测评账号严格遵守“一人一号”的原则，多人使用存在被封停账号的风险，影响测评的准确性。</p>
							<br>
							<b class="color4ad2be">6、测评时需要有人监督吗？</b>
							<p>首次评测时，请为孩子提供安静的环境，帮助他适应线上测评的方式，而且最好监督测评全过程，避免测评时间过长。</p>
							<br>
							<b class="color4ad2be">7、父母可以帮忙测评吗？</b>
							<p>不可以，会影响测评结果的准确性。</p>
							<br>
							<b class="color4ad2be">8、一年三次STAR测评如何安排比较合理？</b>
							<p>购买初期，安排第一次测评，以后半年一次即可。</p>
							<br>
							<b class="color4ad2be">9、STAR测评有多少道题目？</b>
							<p>34道正式测试题目+7道范例测试题目。每次使用STAR测评系统，会有7道范例测试题目，目的是为了确保孩子已经具备使用这套系统的能力，还可以让孩子在进入正式测试前做好准备，了解测试形式。</p>
							<br>
							<b class="color4ad2be">10、STAR测评位置在哪里？</b>
							<p>官网首页【测评入口】</p>
						    <br>
							<b class="color4ad2be">11、STAR测评有APP吗？</b>
							<p>暂时没有APP，建议您使用电脑完成测试。</p>
							<br>
							<b class="color4ad2be">12、STAR测评的结果准确吗？</b>
							<p>测评题目建立在30年大数据统计基础之上，会根据孩子的阅读水平自动调整难易度，是目前最为科学、专业的阅读能力测评系统，仅一次测评并不能完全反映实际水平，我们将结合AR测试统计数据提供阶段性分析和阅读建议。</p>
							<br>
							<b class="color4ad2be">13、STAR测评完成后，为什么没显示结果？</b>
							<p>测评结果只能从后台查看，专属导师会帮您解读。</p>
							<br>
							<b class="color4ad2be">14、STAR测评中断了，需要输入的password是什么？</b>
							<p>admin</p>
							<br>
							<b class="color4ad2be">15、完成STAR测评后，什么时候能收到报告？</b>
							<p>STAR测评1个工作日后，可以在官网【个人中心】查询报告。专属导师上传报告时会有短信提醒，请注意查看。</p>
							<br>
							<b class="color4ad2be">16、我的专属导师是谁？如何联系?</b>
							<p>第一次STAR测评完成后，专属导师会在上传报告后1个工作日内主动致电答疑；如您暂时不需要进行STAR测评，请直接拨打400-625-9800找客服备注测试账号（readingbar开头的），老师会主动致电和您建立联系。</p>
							<br>
							<b class="color4ad2be">17、平时，如何和专属导师联系？</b>
							<p>我们建议您添加专属导师工作微信，这是最方便有效的联系方式。</p>
							<br>
							<b class="color4ad2be">18、STAR测评报告中的各种指数都是什么意思？</b>
							<p>SS：孩子本次测评的成绩得分，分数范围为0-1400；</p>
							
							<p>PR：孩子目前的得分能够超过美国学生的百分比；</p>
							
							<p>GE：孩子目前的阅读水平相当于美国孩子几年级第几个月的阅读水平；</p>
							
							<p>IRL：孩子对该年级图书内容的理解&词汇的掌握程度均达到80%以上；</p>
							
							<p>Est.ORF: 孩子目前每分钟能够正确阅读的文字量；</p>
							
							<p>ZPD：适合孩子阅读书籍的分级范围，这个范围内的书籍，不会使孩子感到因语言和词汇的缺乏造成的阅读障碍，同时也可以提高孩子的阅读能力；</p>
							
							<p>Word Knowledge and Skills : 词汇认知和理解能力；</p>
							
							<p>Comprehension Strategies and Constructing Meaning: 阅读理解能力，即对文章内容和基本结构的分析理解能力；</p>
							
							<p>Analyzing Literary Text: 阅读分析能力, 即对文章内容、情节、角色的深入分析能力；</p>
							
							<p>Understanding Author’s Craft： 对作者修辞写作手法运用的分析理解能力；</p>
							
							<p>Analyzing Argument and Evaluating Text：判断、推理等思维能力，即对书籍及其所论述的观点有自己的判断和见解。</p>
							<br>
							<b class="color4ad2be">19、STAR测评结果不准确怎么办？</b>
							<p>如果确实因孩子的状态不佳或者某些误操作造成的结果不准确，可以联系专属导师，沟通情况后，申请进行重测。</p>
							<br>
							<b class="color4ad2be">20、如何设置阅读目标？</b>
							<p>使用测试系统一个月后，可主动联系专属导师，协助您设置阅读目标。</p>
							<br>
							<b class="color4ad2be">21、根据STAR测评结果中的哪个数值选择书籍？</b>
							<p>ZPD</p>
							<br>
							<b class="color4ad2be">22、在哪个网站搜索和查询书籍相关信息？</b>
							<p>http://www.arbookfind.com</p>
							<br>
							<b class="color4ad2be">23、在www.arbookfind.com找书时，ATOS Book Level填什么？</b>
							<p>填写STAR测评报告中的ZPD数值范围</p>
							<br>
							<b class="color4ad2be">24、STAR测评和AR测试用的是同一个账号吗？</b>
							<p>是的，在同一个测评入口登陆后，再选择STAR或AR。</p>
							<br>
							<b class="color4ad2be">25、我的密码忘记了怎么办？</b>
							<p>请您联系专属导师或拨打客服热线400-625-9800咨询。</p>
							<br>
							<b class="color4ad2be">26、我的账户被锁住了怎么办？</b>
							<p>被锁住的账户24小时后自动解锁。</p>			
						</div>
				</div>
				<div data-tab-panel-2 class="am-tab-panel ">
						
					   <img src="{{url('home/wap/images/page3/AR_03.jpg')}}" >
					  
					   <img src="{{url('home/wap/images/page3/AR_05.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_06.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_07.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_08.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_09.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_10.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_11.jpg')}}" >
					   <img src="{{url('home/wap/images/page3/AR_12.jpg')}}" >
				</div>
				<div data-tab-panel-3 class="am-tab-panel ">
						<div class="page-nr">
							<b class="color4ad2be">1、购买产品后，测试账号何时能收到？</b>
							<p>购买后，1个工作日内账号会发送至注册邮箱，同时有短信提醒。</p>
						<br>
						<b class="color4ad2be">2、购买产品后，该做些什么？</b>
							<p>尽快完成第一次STAR测评--1个工作日后到官网【个人中心】查看中英文解读报告--等待专属导师主动致电答疑--为孩子自行准备AR分级读物--阅读书籍后进行AR测试。（服务有效期内随时联系专属导师咨询相关问题）</p>
						<br>
						<b class="color4ad2be">3、暑假期间购买产品，注册时年级填写哪一个？</b>
							<p>每年8月1日，蕊丁吧网站注册会员的孩子年级全部自动升一级！自8月2日起，请所有新注册会员一定要填写9月开学后的新年级。（我们将根据家长填写的实际年级发送对应年级的系统账号，所以这个信息很重要哦。）</p>
						<br>
						<b class="color4ad2be">4、AR测试和STAR测评是同一个账号吗？</b>
							<p>是的，在同一个测评入口登陆后，再选择STAR或AR。</p>
						<br>
						<b class="color4ad2be">5、AR测试一年有多少次？</b>
							<p>无限次，根据实际情况使用，使用频率越多，对孩子的英文阅读能力提升越有益。</p>
						<br>
						<b class="color4ad2be">6、AR测试如何在手机建立快捷方式？</b>
							<p>第一步：用手机浏览器打开蕊丁吧官网www.readingbar.net</p>
							<p>第二步：点击【测评入口】→选择I'm a student</p>
							<p>第三步：点击“共享”图标（一个箭头显示出来的方块）</p>
							<p>第四步：选择添加到主屏幕</p>
							<p>第五步：选择添加</p>
						<br>
						<b class="color4ad2be">7、是不是每本书都有AR测试题目？</b>
							<p>凡是AR分级读物都有测试题目，系统中目前有18万册书籍的题库，定期不断增加。</p>
						<br>
						<b class="color4ad2be">8、每本书有多少道题目？</b>
							<p>3-20道题目不等。级别低的书籍，测试题目少一些，级别高的书籍，测试题目多一些。</p>
						<br>
						<b class="color4ad2be">9、AR测试有几种类型？</b>
							<p>有三种类型：阅读理解测试（Reading Practice，简写为RP），词汇测试(Vocabulary Practice，简写为VP)和阅读技能测试(Literacy Skills，简写为LS)。</p>
						<br>
						<b class="color4ad2be">10、AR测试题目可以测几次？</b>
							<p>阅读理解测试和词汇测试只能测一次，阅读技能测试可以测三次。虽然词汇测试只能测一次，但本次答错的题有一次重答错题的机会。</p>
						<br>
						<b class="color4ad2be">11、阅读理解测试类型，测试结果是多少才算读懂了？</b>
							<p>在阅读理解测试中，每本书有3-20道测试题目，10道题目以下的合格标准为60%，10道题目以上的合格标准为70%。测试结果达到60%以上则意味着孩子读懂了书籍的大部分内容。</p>
						<br>
						<b class="color4ad2be">12、测试结果不理想，可以删除结果重新测试吗？</b>
							<p>如果确实因孩子的状态不佳或者某些误操作造成的结果不理想，可以联系专属导师，沟通情况，删除之前的测试，重新精读后再进行重测。但不建议频繁删除测试题目，这样会影响孩子的真实阅读情况，也不利于孩子阅读自信心建立，请谨慎操作。</p>
						<br>
						<b class="color4ad2be">13、AR测试完成后，在哪里查看报告？</b>
							<p>测试完成后，直接选择打印TOPS REPORT来查看本次的测试结果，也可打开bookshelf查看。</p>
						<br>
						<b class="color4ad2be">14、AR测试结束后，如何查看错题？</b>
							<p>点击进入“Review Missed Questions”查看答错的题目，系统会自动给出正确的答案。（目前只有超过合格标准的测试可以查看答错的题目，并且只有在刚答完题后才可以查看，之后就无法查看到了。）</p>
						<br>
						<b class="color4ad2be">15、如何根据AR测试正确率调整图书级别？</b>
							<p>每次测试完成后，请查看TOPS REPORT中的正确率，可以做如下调整：</p>
						
							<p>100%：这本书孩子阅读起来很舒适，下次可以尝试高于ZPD范围的书籍；</p>
							
							<p>90%：这本书对孩子来说很适合，下次可以尝试1-2本级别稍高或篇幅稍长的书籍来阅读；</p>
							
							<p>80%：这本书对孩子来说稍微有点难，下次可以尝试1-2本级别稍低的书籍来阅读；</p>
							
							<p>70%：这本书对孩子来说有一点挑战，下次可以选取在ZPD区间开始级别的书籍来阅读；</p>
							
							<p>60%：这本书对孩子来说太有挑战性了，下次可以尝试从ZPD区间开始级别的书籍来阅读，或者咨询专属导师了解详细阅读建议。</p>
						<br>
						<b class="color4ad2be">16、在哪个网站搜索和查询AR分级读物相关信息？</b>
							<p>http://www.arbookfind.com</p>
						<br>
						<b class="color4ad2be">17、在www.arbookfind.com找书时，ATOS Book Level填什么？</b>
							<p>填写STAR测评报告中的ZPD数值范围</p>
						<br>
						<b class="color4ad2be">18、我的专属导师是谁？如何联系?</b>
							<p>第一次STAR测评完成后，专属导师会在上传报告后1个工作日内主动致电答疑；如您暂时不需要进行STAR测评，请直接拨打400-625-9800找客服备注测试账号（readingbar****），老师会主动致电与您建立联系。</p>
						<br>
						<b class="color4ad2be">19、平时，如何和专属导师联系？</b>
							<p>我们建议您添加专属导师工作微信，这是最方便有效的联系方式。</p>
						<br>
						<b class="color4ad2be">20、我的密码忘记了怎么办？</b>
							<p>请您联系专属导师或拨打客服热线400-625-9800咨询。</p>
						<br>
						<b class="color4ad2be">21、我的账户被锁住了怎么办？</b>
							<p>被锁住的账户24小时后自动解锁。</p>
						</div>
				</div>
                <!--/-->
                <div data-tab-panel-4 class="am-tab-panel ">
						<div class="about-title">根据STAR测评选书 </div>
						<div class="four-horn-tbox">
							<div class="font_content_s">为您介绍一款超级实用能查找原版书分级的AR BOOKFIND系统</div>
							<div class="font_content_s">关键是~~</div>
							<div class="font_content_s color4ad2be">不花钱！不花钱！不花钱！</div>
							<div class="font_content_s">重要的事情说三遍~</div>
							<div class="font_content_s">一起来看看这个网站吧</div>
							<div class="font_content_s">首先</div>
							<div class="font_content_s">打开它的首页网址：<br><a href="http://www.arbookfind.com/">http://www.arbookfind.com/</a></div>
							
						</div>
					<div class="am-text-center">
						<div class="font_title_ddd color4ad2be am-text-center">AR BOOKFIND</div>
						<img alt="" src="{{ asset('home/wap/images/wap20170523/icon/icon-3dian.png')}}" style="width:40px !important; ">
						<div class="font_title_left_circle">AR BOOKFIND</div>
					</div>
					<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs1.png')}}">
					<div class="am-text-center ">
						<div class="four-horn-tbox">
							<div class="font_content_s">点击Advanced Search 进入二级页面</div>
							<div class="font_content_s">在页面中选择孩子的Interest Level</div>
							<div class="font_content_s">即输入孩子的真实年级</div>
							<br>
							<div class="font_content_s color4ad2be">其中各种指数为</div>
							<div class="font_content_s color4ad2be">LG K-3=幼儿园至小学三年级</div>
							<div class="font_content_s color4ad2be">MG 4-8=四年级至八年级</div>
							<div class="font_content_s color4ad2be">MG+6 and up =六年级以上</div>
							<div class="font_content_s color4ad2be">UG 9-12=九至十二年级</div>
							<br>
							<div class="font_content_s">在ATOS输入阅读能力测评报告中ZPD（Zone of Proximal Development）数据：2.0-4.0</div>
							<br>
							<div class="font_content_s">这两个是必填项</div>
							<div class="font_content_s">选好之后后面还有些附加选项</div>
							<div class="font_content_s">可以选择孩子感兴趣的主题</div>
							<div class="font_content_s">图书类别等等</div>
							<br>
							<div class="font_content_s">举个例子</div>
							<div class="font_content_s">如：为孩子选择K-3级别</div>
							<div class="font_content_s">输入ATOS Book Level以2-4为例</div>
							<div class="font_content_s">（ZPD2-4，指的是适合阅读ATOS Book Level2-4的图书）</div>
							<div class="font_content_s">然后点击GO</div>

						</div>
					</div>
					<div class="text-center">
						<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs2.png')}}">
					</div>
					<div class="am-text-center">
						<div class="conpent-bcg-tbox">
							<div class="font_content_s">搜索结果</div>
							<div class="font_content_s">显示相应图书级别的原版书</div>
							<div class="font_content_s">从中选择孩子喜欢的书籍就可以了</div>
						
						</div>
					</div>
					<div class="text-center">
						<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs3.png')}}">
					</div>
					<div class="am-text-center ">
						<div class="conpent-bcg-tbox">
							<div class="font_content_s">除了以上搜索方式</div>
							<div class="font_content_s">还可以继续进行详细搜索</div>
							<div class="font_content_s">点击搜索页上方的Sort By（排序方式）</div>
							<div class="font_content_s">可以按Rating（图书受欢迎程度）来排序</div>
							<div class="font_content_s">也可以按照Author（作者）来排序</div>
							<div class="font_content_s">这样子，查找范围就会缩小啦</div>
						
						</div>
					</div>
					<div class="text-center">
						<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs4.png')}}">
					</div>
					<div class="am-text-center">
						<div class="conpent-bcg-tbox">
						
							<div class="font_content_s">或者还可以在Advanced Search 页面</div>
							<div class="font_content_s">在Additional Criteria（附加标准）处</div>
							<div class="font_content_s">选择相应信息  精确搜索</div>
							<div class="font_content_s">这里主题分类很详细，有20多个哦。</div>
						
						</div>
					</div>
					<div class="am-text-center">
						<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs5.png')}}">
					</div>
					<div class="am-text-center">
						<div class="conpent-bcg-tbox">
							<div class="font_content_s">当然</div>
							<div class="font_content_s">AR BOOKFIND系统还可以做一件超级牛的事</div>
							<div class="font_content_s"><img alt="" src="{{ asset('home/pc/images/icon-down.png')}}" style="width:20px !important"></div>
							<div class="font_content_s">点击Quick Search</div>
							<div class="font_content_s">输入书籍名称</div>
							<div class="font_content_s">如Frog and Toad</div>
							<div class="font_content_s">会出现所有相关图书信息</div>
							<div class="font_content_s">每本书都有IL（适合年级）、BL（图书级别）、AR Pts（阅读理解测试积分）、AR Quiz Type（阅读理解测试类型）、Rating（受欢迎程度）等信息</div>
							<div class="font_content_s">通过这个功能可以查询家里的原版书是不是适合孩子目前的阅读能力水平</div>
						</div>
					</div>
					<div class="am-text-center">
						<img alt="" src="{{ asset('home/pc/images/page_cpxs/cpxs6.png')}}">
					</div>
					<div class="am-text-center">
						<div class="conpent-man-tbox">
						
							<div class="font_content_s">AR BOOKFIDN网站目前收录<br>
							<span class="color4ad2be">18万册原版书</span><br>相关数据<br>
							且这个数量还在定期不断增加<br>
							免费查询<br>
							随时查询<br>
							让阅读不再盲目<br>
							科学阅读找蕊丁吧~</div>
						</div>
					</div>
				</div>
               
	      </div>
	  </div>
</section>
<!-- /content end -->
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

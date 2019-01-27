<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 扩展内容-->
    <!--/banner-->
    <div class="content  " >
    
    
      <div class="container container-2017" style="background-color:white">
      			<img alt="" src="{{  asset('home/pc/images/products/reading_camp/banner.png') }}" width="1200px">
      			<div class="content940 text-center">
      						
      						<br><br>
      						
      						<div class="tjj-color-333333 tjj-font-size-24">
	      						您是否遇到过这样的困惑<span class="tjj-color-ff00b4">：</span>
      						</div>
      						<br>
      						<div class="tjj-color-666666 tjj-font-size-18">
      							孩子阅读<span class="tjj-color-333333 tjj-font-size-24">不能坚持</span>，还得通过<span class="tjj-color-333333 tjj-font-size-24" >奖励</span>和<span class="tjj-color-333333 tjj-font-size-24">监督<em class="tjj-color-ff4e00">？</em></span><br>
								孩子阅读<span class="tjj-color-333333 tjj-font-size-24">没兴趣</span>，感受不到<span class="tjj-color-333333 tjj-font-size-24">读书的乐趣<em class="tjj-color-ff4e00">？</em></span><br>
								孩子书上<span class="tjj-color-333333 tjj-font-size-24">单词不认识</span>，完全<span class="tjj-color-333333 tjj-font-size-24">读不了<em class="tjj-color-ff4e00">？</em></span><br>
								孩子阅读囫囵吞枣，<span class="tjj-color-333333 tjj-font-size-24">不求甚解<em class="tjj-color-ff4e00">？</em></span>
      						</div>
      						<br><br>
      						<div class="tjj-color-00baff tjj-font-size-24">
	      						莫急莫急  莫慌莫慌
      						</div>
      						<br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/dot.png') }}" >
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						用它来帮助您！
      						</div>
      						<br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/arrow.png') }}" >
      						<br><br>
      						<div class="tjj-color-ff7200 tjj-font-size-30">
	      						    六月<br>
									蕊丁吧隆重启动READING CAMP正式营！
      						</div>
  							<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						四周时间 帮孩子
      						</div>
      						<br><br>
      						<div class="tjj-color-666666 tjj-font-size-18">
      								找到合适的书籍<br>
									找到读书的伙伴<br>
									找到阅读的感觉<br>
									每天5-10分钟，在家就能轻松享受英文阅读的乐趣！
      						</div>
      						<br><br>
      						<div class="tjj-color-333333 tjj-font-size-18">
	      						来看看三期体验营中家长们的评价
      						</div>
      						<br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/talk1.png') }}"  class="rc-image-talk">
      						<br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/talk2.png') }}"  class="rc-image-talk">
      						<br><br><br><br><br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/talk3.png') }}"  class="rc-image-talk">
      						<br><br>
      						<div class="tjj-color-333333 tjj-font-size-18">
	      						还有纯欧美外教的线上互动<br>
								小学员们都是棒棒滴~
      						</div>
      						<br><br>
      						<div>	
      							<img alt="" src="{{  asset('home/pc/images/products/reading_camp/audio_back.png') }}"" class="rc-audio-back"> <br>
      							<img alt="" src="{{  asset('home/pc/images/products/reading_camp/audio_btn.png') }}"" class="rc-audio-btn " onclick="bf()"> 
      						</div>
      						<audio id="audio">
      								  <source src="{{  asset('home/pc/audio/products/reading_camp/camp.mp3') }}" type="audio/mpeg">
									 您的浏览器不支持audio标签
      						</audio>
      						<script>
      							$(".rc-audio-btn").click(function(){
      								 var audio = document.getElementById('audio'); 
      								if(audio!==null){             
    								    //检测播放是否已暂停.audio.paused 在播放器播放时返回false.
    								     //alert(audio.paused);
    								  if(audio.paused){                 
        								  $(this).addClass('rc-rotation');
    								      audio.play();//audio.play();// 这个就是播放  
    								  }else{
    									  $(this).removeClass('rc-rotation');
    								      audio.pause();// 这个就是暂停
    								  }
    								 } 
          						});
							</script>
      						<br><br>
      						<div class="tjj-color-ff7200 tjj-font-size-30">
									即日起-6月14日<br>
									READING CAMP正式营报名开始啦
      						</div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						报名条件
      						</div>
      						<br>
      						<div class="component-green-tbox font_content_g">
						     	<div class="box">
						     		<div class="text-left">
						     			<p class="font_content_rc"> 
						     				<span>蕊丁吧所有服务期内会员</span>
						     			</p>
						     			<p class="font_content_rc">
						     				<span>STAR测评GE指数在1.5-2.5之间</span>
						     			</p>
						     			<p class="font_content_rc">
						     				<span>学龄前-小学3年级</span>
						     			</p>
									</div>
						     	</div>
						   </div>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						报名人数
      						</div>
      						<br>
      						<div class="tjj-color-666666 tjj-font-size-18">仅限8名</div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						开课时间
      						</div>
      						<br>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						6月19日-7月16日
	      						<br> 
	      						共四周时间
      						</div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						READING CAMP费用
      						</div>
      						<br>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						<strong>398元/期</strong>
      						</div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						含：
      						</div>
      						<br>
      						<div class="component-green-tbox font_content_g">
						     	<div class="box">
						     			<ul class="list-circle font_content">
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周深度阅读1本书，四周共4本<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																4本指定纸质原版书（确定报名后快递到家）<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周1小时欧美外教直播阅读讨论课，四周共4小时<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																专属导师全程陪伴管理28天<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl ">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每日阅读任务，在班级群上交并打卡<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周1次作业，四周共4次作业，导师批改<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p> 
									     					相关阅读书籍推荐
									     				</p>
									     			</div>
									     		</li>
								     		</ul>
						     	</div>
						    </div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						READING CAMP形式
      						</div>
      						<br>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						专属微信群 语音+图片+文字
	      						<br> 
	      						业直播平台 视频+课件
      						</div>
      						<br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						READING CAMP积分奖励计划
      						</div>
      						<div class="component-normal-tbox font_content_g">
						     	<div class="box">
						     			<ul class="list-circle font_content">
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周按时完成所有阅读任务，奖励25个蕊丁币，4周共100个；<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周按时参加外教在线互动直播课，奖励25个蕊丁币，4周共100个；<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out"><span class="list-circle-pre-in"></span></span>
									     				<p>
																每周按时完成作业，奖励25个蕊丁币，4周共100个;
									     				</p>
									     			</div>
									     		</li>
								     		</ul>
						     	</div>
						     	<div class="tjj-color-48cbb9 tjj-font-size-18">
						     		备注：蕊丁币可在官网兑换礼物哦~
      							</div>
						    </div>
						    <br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						报名步骤
      						</div>
      						<div class="component-normal-tbox font_content_g">
						     	<div class="box">
						     			<ul class="list-circle font_content">
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">1</span>
									     				<p>
																购买此产品<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">2</span>
									     				<p>
																开课前确认报名信息，老师发送开课通知<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">3</span>
									     				<p>
																6月19日建立微信班级群，开课并宣布课程规则
									     				</p>
									     			</div>
									     		</li>
								     		</ul>
						     	</div>
						    </div>
						    <br><br>
      						<div class="tjj-color-ff4e00 tjj-font-size-24">
	      						注意事项
      						</div>
      						<div class="component-normal-tbox font_content_g">
						     	<div class="box">
						     			<ul class="list-circle font_content">
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">1</span>
									     				<p>
																报名一经确认，不可修改；<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">2</span>
									     				<p>
																如遇特殊情况缺课，不补课；<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">3</span>
									     				<p>
																不提供课程视频，请大家尽量准时参与直播；<br><br>
									     				</p>
									     			</div>
									     		</li>
									     		<li>
									     			<div class="list-circle-content-nl">
									     				<span class="list-circle-pre list-circle-pre-out-n">4</span>
									     				<p>
																本期外教课时间为每周六晚19:30-20:30，请提前做好准备。
									     				</p>
									     			</div>
									     		</li>
								     		</ul>
						     	</div>
						    </div>
						   <br>
						    <div class="tjj-color-ff4e00 tjj-font-size-24">
	      						READING CAMP书籍简介
      						</div>
      						<br>
						    <div class="tjj-color-333333 tjj-font-size-18">
							    <strong>
		      						故事、科普相结合<br>
	  								名家作品、大奖经典缺一不可
  								</strong>
      						</div>
      						<br><br>
						    <div class="tjj-color-333333 tjj-font-size-18">
	      						<strong>第一周 6月19日-6月25日</strong>
      						</div>
      						<br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/book1.png') }}">
      						<br><br>
						    <div class="tjj-color-666666 tjj-font-size-18">
	      						所读书籍：《Hi, Fly Guy》
      						</div>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						BL：1.5<br>
								Fiction<br>
								Quiz No. 101305<br>
								作者：Arnold  Tedd
      						</div>
      						<br><br>
      						<div class="content600 text-justify tjj-color-999999 tjj-font-size-14">
	      						作者简介：<br><br>
	
								Arnold Tedd出生于纽约，毕业于佛罗里达大学。他和从事幼教的妻子Carol定居于Tallahassee, 而他则从事商业插画的工作，他已出版了50本儿童书籍。他的作品 Hi！Fly Guy！荣获2006年美美国图书馆协会奖 (2006 Theodor Seuss Geisel Honor) <br>
								
								<br>图书简介：<br><br>
								
								小男孩Buzz的宠物苍蝇阴差阳错夺得宠物大赛“zui聪明宠物”的滑稽故事。“苍蝇小子”是一套简单而极其风趣的英文桥梁书,讲述了一个小男孩和一只苍蝇之间发生的有趣的故事。<br>
								
								<br>图书背景：<br><br>
								
								Fly Guy系列的语言简单、幽默，篇幅较短小，而且画面精美，故事有趣，淘气的画风，搞笑的文字，让孩子们在开心阅读的同时不知不觉学到了很多新单词、新句型。虽然是章节读物，Fly Guy整套书文字难度并不太高，再加上有趣的情节和可爱的图画，很容易让孩子们产生阅读兴趣。特别推荐给调皮又不喜欢读书的男孩子,说不定这套书可以从此打开他的阅读之门哦 。
								
								在2016-2017年Renaissance公司的读书报告中，Hi, Fly Guy一直在孩子最爱阅读的榜单前十。
      						</div>
      						
      						<br><br>
						    <div class="tjj-color-333333 tjj-font-size-18">
	      						<strong>第二周 6月26日-7月2日</strong>
      						</div>
      						<br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/book2.png') }}">
      						<br><br>
						    <div class="tjj-color-666666 tjj-font-size-18">
	      						所读书籍：《Roaring Rockets》
      						</div>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						BL：1.9<br>
								Nonficition<br>
								Quiz No. 70335<br>
								作者：Mitton Tony
      						</div>
      						<br><br>
      						<div class="content600 text-justify tjj-color-999999 tjj-font-size-14">
	      						作者简介：<br><br>
	
								托尼·米顿，英国著名童书童谣作家，教师和诗人。托尼·米顿的作品曾多次获得童书金奖，他的作品形象温馨可爱，语言押韵，活泼流畅，琅琅上口，深受小读者喜爱。托尼与安特·帕克联手创造了《神奇的机器》系列，包括神奇的飞机，强大的挖掘机，不可思议的火箭，飞快的火车，勇敢的消防车等共10册。<br>
								<br>图书简介：<br><br>
								
								这本书简单明了的解释了火箭空间站是如何运行、飞行和太空员的日常工作。 <br>
								
								<br>图书背景：<br><br>
								
								《“神奇的机器”系列》是一套科普绘本。涵盖了飞机、火箭、汽车、火车、卡车、拖拉机、挖土机、消防车、船、潜水艇共10种机器的介绍。严谨的科普知识，朗朗上口的语言，明快的色彩，以及古灵精怪的动物主人公，将带领小朋友进入一个神奇的机器世界，让小朋友兴趣盎然地学习科普小知识。
      						</div>
      						
      						<br><br>
						    <div class="tjj-color-333333 tjj-font-size-18">
	      						<strong>第三周 7月3日-7月9日</strong>
      						</div>
      						<br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/book3.png') }}">
      						<br><br>
						    <div class="tjj-color-666666 tjj-font-size-18">
	      						所读书籍：《Seven Blind Mice》
      						</div>
      						<div class="tjj-color-666666 tjj-font-size-18">
	      						BL：1.9<br>
								Fiction<br>
								Quiz No. 7592<br>
								作者： Ed Young
      						</div>
      						<br><br>
      						<div class="content600 text-justify tjj-color-999999 tjj-font-size-14">
	      						作者简介：<br><br>
								Ed Young是一位华裔美籍作家，他将小时候爸爸对他说过的故事，加上自己的想象力，写成一本又一本具有东方思想与价值观的绘本。<br>
								Caldecott Medalist Ed Young是超过八十本儿童图书的插画家，其中十七本是他写作的。他在中国绘画哲学中的工作过程中产生灵感。他解释说：“中国画常常伴随着文字。” “他们是互补的。有些事情，图片永远不能表达，而同样的，有一些图像，这些词也不能描述。
								毕业于美国帕萨迪纳艺术中心设计学院的Young曾执教于雅培大学普拉特研究所，Naropa研究所和加州大学圣克鲁斯分校。<br>
								<br>图书简介：<br><br>
								
								这本书以“盲人摸象”为蓝本的故事，重述了七只小老鼠从不同角度出发的想法和见解，是一本寓哲理于故事的不可多得的值得推荐的书籍。 <br>
								
								<br>图书背景：<br><br>
								
								七只勇敢的老鼠各自用他们不同的角度和想法，尝试探索他们未知的事物。家长们可藉由这个预言故事，鼓励小朋友培养追求真理的勇气和凡事都能追根究底的精神。故事本身十分具有童趣，是一本插画精美，用色大胆而鲜明的得奖作品。<br>
								<br>荣获奖项：<br><br>
									<span class="tjj-color-48cbb9">★</span>波士顿地球喇叭书荣誉1992年，七盲小鼠<br>
									<span class="tjj-color-48cbb9">★</span>汉斯·克里斯蒂安·安徒生奖章 - 美国提名人，2000年和1992年<br>
									<span class="tjj-color-48cbb9">★</span>兰多夫·卡尔德科特奖章 1992年，七盲小鼠 - 荣誉书<br>
									<span class="tjj-color-48cbb9">★</span>纽约公共图书馆，阅读和分享100个值得阅读和推荐的书籍
						   </div>
						   
						   <br><br>
						    <div class="tjj-color-333333 tjj-font-size-18">
	      						<strong>第四周 7月10日-7月16日</strong>
      						</div>
      						<br><br>
      						<img alt="" src="{{  asset('home/pc/images/products/reading_camp/book4.png') }}">
      						<br><br>
						    <div class="tjj-color-666666 tjj-font-size-18">
	      						所读书籍：《Froggy Rides a Bike》
      						</div>
      						<div class="tjj-color-666666 tjj-font-size-18">
		      					BL：2.1<br>
								Fiction<br>
								Quiz No. 107353<br>
								作者：London, Jonathan
      						</div>
      						<br><br>
      						<div class="content600 text-justify tjj-color-999999 tjj-font-size-14">
	      						作者简介：<br><br>
	
								乔纳森·伦敦，是超过100本儿童图画书的作者，其中许多关于野生动物。但最著名的一种野生动物：青蛙。写作的第一本书，小青蛙穿衣服，于1992年出版。被列为纽约公共图书馆的100本图书每个人都应该知道的图书，可追溯到彼得兔的故事。<br>
								青蛙是非常善良的，所有的故事都是基于作者与他的儿子亚伦和肖恩的真实经历，以及他自己成长的一些回忆。略显夸张是为了让内容更加幽默、诙谐。通过阅读青蛙书的孩子们会越来越了解他们自己，并能够笑对自己的小缺点。<br>
								<br>图书简介：<br><br>
								
								在朋友和家人的鼓励下，小青蛙学会了如何骑他的闪亮新自行车的故事。 <br>
								
								<br>图书背景：<br>
								
								<br>荣获奖项：<br><br>
								<span class="tjj-color-48cbb9">★</span>Book sense十大儿童图书 - 秋季2004年<br>
								<span class="tjj-color-48cbb9">★</span>儿童杂志2004年最佳图书<br>
								<span class="tjj-color-48cbb9">★</span>2005年明尼苏达书籍奖<br><br>
								Froggy系列绘本的每一个故事都是会在日常生活中发生的，充满了童趣。作为一本英文原版绘本，书中所用单词和句型都不复杂，且经常重复。画面色彩丰富，时而穿插白色底页的分解小图。无论是作为故事绘本，还是英文启蒙读物，都非常适合。<br><br>
								在国外，Froggy是非常知名的童书主角，他天真又脱线的性格俘获无数小小孩的心，幼稚园小朋友都会认识这位经典的童书主角。这套书籍不论去趣味性还是学习性来看，都是值得推荐的。
						   </div>
						   <br><br>
						   <div  class="tjj-color-00baff tjj-font-size-24">
				      			本期READING CAMP仅限8名小学员<br>
								现已报名<span class="tjj-color-ff4e00">[[ 8-last_quantity ]]</span>位<br>
								赶紧去抢位吧<br>
			      			</div>
      			</div>
      			<br><br>
      			
			   <div class="content940 text-center">
			   		@if(auth('member')->isLoged())
			   			<a href="javascript:void(0)" class="btn-local"  v-on:click="showProtocalModal()">
				   			<em class="circle-left"></em>
				   			<strong>GO</strong>
				   			<em class="circle-right"></em>
				   		</a>
					@else
						<a href="javascript:void(0)" class="btn-local" v-on:click="alertLogin()">
				   			<em class="circle-left"></em>
				   			<strong>GO</strong>
				   			<em class="circle-right"></em>
				   		</a>
					@endif	
			   </div>
      </div>
    </div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="protocolModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<div class="" style="overflow-y: scroll; height: 60%">
					<h1 class="product-h1 textcenter">蕊丁吧付费会员服务内容及使用须知</h1>
					<div class="product product-txt ">
					        <p>一、 蕊丁吧会员说明</p>
	<p>1. 本服务内容及使用须知适用于蕊丁吧所有付费会员。</p>
	
		<br>
	<p>二、 押金、损耗和赔偿（针对定制阅读会员）</p>
	<p>1 会员在购买定制阅读服务时，同时需要缴纳图书借阅押金。</p>
	<p>2
		蕊丁吧每本书都是精心挑选，从国外引进的，我们希望各位会员能与蕊丁吧一起爱护每一本图书。如学员对图书造成的损耗，需要支付相应的赔偿。具体规定如下：
	</p>
	<p>2.1 图书如在借阅过程中有轻微损毁，请家长在还书时主动告知，由我们进行修补。</p>
	<p>2.2
		若有出现圈点、涂画、撕毁、烧残、水浸、划线、注字、涂抹、卷曲、折皱等但不影响其内容完整，能继续使用的，按污损页数计罚，每页需按照（定价/页码）*2的标准赔偿金。赔偿金额超过书籍定价的，将按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。
	</p>
	<p>2.3
		出现开胶、撕页或大面积涂写等严重影响书籍正常阅读的，应按书籍定价的1.5倍进行赔偿，已破损的书籍归用户所有。赔偿费用需单独支付（不接受用户自行购买进行赔偿）。
	</p>
	<p>3 书籍定价</p>
	<p>3.1 书籍的价值以每本书的RMB标价为准。RMB标价按照以下方式计算：</p>
	<p>3.1.1 对图书上标有美元定价的， RMB标价按照以书籍上美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
	<p>3.1.2
		对图书上未标出美元定价的，RMB标价按照相同ISBN书籍的亚马逊网站的美元定价乘以6.7的汇率标准进行计算（四舍五入去除分角）。</p>
	<br>
	<p>三、 账号使用说明</p>
	<p>1. 会员付费后，系统会额外提供一个测试平台账号。</p>
	<p>2. 测试平台账号的使用人必须与学员信息一致，不允许与他人共用、外借或转让。</p>
	<p>3.
		蕊丁吧会定期对学员测试信息进行审核，如发现异常信息，将进行处理。首次发现异常信息，将与会员联系提出警告。如果出现第二次异常信息，将视为学员的严重违约行为，蕊丁吧将采取直接封号的处理，并不进行退费。
	</p>
	<p>4. 会员在服务期满后应当续费；如果会员停止续费，相应的会员服务将自动终止。重新续费后恢复服务。
		定制阅读会员（只限于定制阅读年会员）在服务有效期内，可申请最多1次，每次最长1个月的账号暂时冻结服务，冻结期间，所有服务暂停。解冻后，服务有效期顺延。没有申请则视为正常服务，时间不延续。
	</p>
	<br>
	<p>四、 退费说明</p>
	<p>1 定制阅读会员</p>
	<p>1.1
		定制阅读会员（仅限于定制阅读年会员）在付费后30日内可申请终止服务并申请退费；蕊丁吧在扣除10%全年服务费用后，将其余费用予以退回；超过30日，会员费用不予退回。押金在用户归还全部书籍（无破损或丢失）后于15个工作日内退还。
	</p>
	<p>1.2
		会员服务到期，应提前或及时续费。如果到期后5日内未续费，也未还书的，将按照每天每本5元收取滞纳金，滞纳金从押金中扣除（滞纳金从逾期第1天开始计算）。
	</p>
	<p>1.3 押金退还说明：会员服务期满后，如不再续费，押金将退还到原支付账户，如有变化，会员应于期满前提前说明。</p>
	<p>2 自主阅读会员</p>
	<p>2.1 会员在付费后不得申请退费。</p>
	<br>
	<p>五、 美国系统账号使用说明</p>
	<p>1. 针对付费会员，蕊丁吧将分配一个美国系统账号。</p>
	<p>2. 会员使用美国系统账号时，除遵守本使用须知及《蕊丁吧用户协议》外，还应当遵守美国系统账号管理网站的相关规定。</p>
	<p>3. 蕊丁吧有权终止会员使用美国系统账号，但应提前30日通知会员。</p>
	<p>4. 蕊丁吧通知会员停止使用美国系统账号后，可以通过其他替代方案向会员提供服务。</p>

						<a href="javascript:void(0)" v-on:click="setProtocol()"
							class="product-txt-link">同意并支付</a> <a href="javascript:void(0)"
							data-dismiss="modal" class="product-txt-link">不同意</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 模态框（Modal）end -->
<!-- 孩子选择-模态框（Modal） -->
<div class="modal fade" id="selectChildModal" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<span>选择孩子购买产品</span>
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">

				<temlpate v-for="s in students">
					<div v-if="checkArea(s)">
						<button v-if="buy.student_id==s.id" class="btn btn-primary "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
						<button v-else class="btn btn-default "
							v-on:click="setStudent(s.id)"
							style="float: left; margin-right: 10px">[[s.name]]</button>
					</div>
				</temlpate>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default"
					v-on:click="goConfirm()">确认</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal -->
</div>
<!-- 孩子选择-模态框（Modal）end -->    
<script>
	var product_list=new Vue({
		el:"body",
		data:{
			product_id:11,
			last_quantity:0,
			products:{!! json_encode($products) !!},
			students:{!! json_encode($students) !!},
			buy:{
				product_id:null,
				student_id:null,
				protocol:false
			},
			service_area:null
		},
		created:function(){
			 this.last_quantity=this.getLastQuantity();
			 this.setProduct();
		},
		methods:{
			//设置要购买的产品
			setProduct:function(){
				this.clearBuy();
				for(i in this.products){
					if(this.products[i].id==this.product_id){
						this.service_area=this.products[i].service_area;
						this.buy.product_id=this.product_id;
						break;
					}
				}
			},
			showProtocalModal:function(){
				if(this.last_quantity>0){
					this.buy.protocol=true;
					$("#selectChildModal").modal('show');
				}else{
					appAlert({
						title:"提示",
						msg:"此商品已经售尽，下次记得早点来哦！",
						ok:{
							text:"返回首页",
							callback:function(){
								window.location.href="{{ url('/') }}";
							}
						}
					});
				}
			},
			//同意购买协议
			setProtocol:function(){
				this.buy.protocol=true;
				if(this.students.length==0){
					alert('请添加孩子！');
					window.location.href="{{ url('/member') }}";
					return;
				}
				$("#protocolModal").modal('hide');
				$("#selectChildModal").modal('show');
			},
			//设置购买产品的孩子信息
			setStudent:function(id){
				this.buy.student_id=id;
			},
			//清空购物信息
			clearBuy:function(){
				this.buy={
						product_id:null,
						student_id:null,
						protocol:false
				};
			},
			//校验&确认购买信息
			goConfirm:function(){
				url="{{url('member/pay/confirm')}}";
				if(this.buy.product_id==null){
					alert('请选择产品！');
					return;
				}
				if(!this.buy.protocol){
					alert('您为同意购买协议！');
					return;
				}
				if(this.buy.student_id==null){
					alert('请选择孩子！');
					return;
				}
				window.location.href=url+"?product_id="+this.buy.product_id+"&protocol="+this.buy.protocol+"&student_id="+this.buy.student_id;
			},
			//提示登录
			alertLogin:function(){
				alert('您尚未登录！');
				window.location.href="{{ url('/login') }}";
			},
			//校验孩子所在地与产品服务区域是否匹配
			checkArea:function(s){
				if(this.service_area=='全国'){
					return true;
				}else if(this.service_area.indexOf(s.province)!=-1){
					return true;
				}else{
					return false;
				}
			},
			/*获取已经报名的人数*/
		   getLastQuantity:function(){
			   for(i in this.products){
					if(this.products[i].id==this.product_id){
						if(this.products[i].quantity>5){
							return 5;
						}else{
							return this.products[i].quantity;
						}
					}
				}	
			}
		}
	});
	@if($errors->has('product_id'))
		alert('选购的产品不存在！');
	@endif
</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

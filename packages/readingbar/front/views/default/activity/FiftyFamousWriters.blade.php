@extends('front::default.common.main')

@section('content')
<style type="text/css">
	body{ background: #f7f7f7}
	.row{margin: 0;}
</style>
<div class="FamousWriters-main" id="fifty-autors">
	<div class="row"><img src="{{url('home/pc/images/2017/FamousWriters/banner.jpg')}}" alt=""/></div>
	<div class="row">
		<ul class="row ffwriter    ffwriter-01">
			<li v-for="a in data"  :class="'ffwriter-bt'+($index%3+1)" v-if="a.no <= currentpage*10 && a.no > (currentpage-1)*10">
				<div class="col-md-2"><img :src="a.avatar">
				<em>NO.[[ a.no ]]</em></div>
				<div class="col-md-5 ffwriter-info"> 
					<h4>[[ a.name ]]</h4>
					<p v-if="!a.open">
						[[ showSubDesc(a.desc) ]]<img v-if="checkOpenStatus(a.desc)" v-on:click="doOpen(a)" src="{{ url('home/pc/images/2017/FamousWriters/dw.png') }}">
					</p>
					<p v-else>
						[[ a.desc ]]<img v-on:click="doHide(a)"  src="{{ url('home/pc/images/2017/FamousWriters/up.png') }}">
					</p>
				</div>
				<div class="col-md-5 ffwork">
					<ul> 
						<li v-for="b in a.books" >
							<div class="pic"><img  :src="b.cover"></div>
							<span>[[ b.book_name ]]</span> 
							<p v-if="b.type">[[ b.type ]]  </p>
							<p v-if="b.bl">BL=[[ b.bl ]]</p>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<!--/row 第一页-->
		<div>
			<ul class="pagination-50">
				<li><a href="javascript:void(0)" v-on:click="goPage(1)"><i class="glyphicon glyphicon-chevron-left"  ></i></a></li>
				<li v-for="i in 5">
					<a href="javascript:void(0)" v-if="i+1===currentpage" class="active">[[ i+1 ]]</a>
					<a href="javascript:void(0)"  v-else v-on:click="goPage( i+1)">[[ i+1 ]]</a>
				</li>
				<li><a href="javascript:void(0)" v-on:click="goPage(5)"><i class="glyphicon glyphicon-chevron-right" ></a></i></li>
			</ul>
		</div>
	</div>
</div>
<style>
<!--
.pagination-50 {
	text-align:right;
}
.pagination-50 >li{
		display:inline-block;
		padding:6px 12px;
}
.pagination-50 >li .active{
	color:#4bd2bf;
}
.pagination-50  i{
	border:1px solid #4bd2bf;
	padding:5px  6px 6px  6px;
	border-radius: 20px;
	color:#4bd2bf;
}
-->
</style>
<div class="mon bgffcc00" style="height: 100px;"></div>
<script type="text/javascript">
	//文字收缩
	$(".staff-more").on("click", function() {
        $(this).parent().parent().parent().find("[class='more']").toggle();
        $(this).parent().parent().parent().find("[class='less']").toggle();
    });

    new Vue({
		el: '#fifty-autors',
		data:{
			descLimit: 200,
			currentpage: 1,
			data:[
			      {
						no: 1,
						name: '乔安娜·科尔（Joanna Cole）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/1.jpg') }}',
						desc: '做过教师和儿童读物编辑，现在专职写作。在小学五年级的时候，乔安娜发现自己爱好搞研究，还曾为学校写研究报告，也是在她上小学的时候，她有一位正如《神奇校车》里的卷毛老师一样的老师。每周，这位老师都让一位同学在全班同学面前做一个实验，乔安娜特别希望自己有机会做实验。对她来说，小学是人生中最重要的阶段，在她看来，这也是决定她后来为孩子写书的重要原因。',
						books:[
						       {book_name: '《The magic school bus 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/1/1.jpg')}}',bl:'1.7-5.7',type:'Nonfiction'},
						       {book_name: '《How you were Born》 ',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/1/2.jpg')}}',bl:'4.5',type:'Nonfiction'},
						       {book_name: '《Hungry, Hungry Sharks》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/1/3.jpg')}}',bl:'2.8',type:'Nonfiction'},
						],
						open: false
				  },
				  {
						no: 2,
						name: '艾瑞克·卡尔 （Eric Carle）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/2.jpg') }}',
						desc: '国际儿童文学大师，绘本专家，创作了超过70本作品，光是《饥饿的毛毛虫》就被翻译成47种语言版本，销售超过3000万册，曾获得过70余次国际性大奖。艾瑞克·卡尔曾说：“我尝试用我的书来为家与学校的鸿沟搭起一座桥梁。”这位才华横溢的卡爷爷（创作第一本绘本时，“卡爷爷”应该还是“卡帅哥”），讨厌德国式教育，16岁那年从高中退学。在老师的劝说之下，在斯图加特一所有声望的美术学校学习了四年的视觉艺术。毕业后，曾在一家时尚杂志担任艺术指导，也曾做过平面设计师……1967年，他38岁那一年，他为广告画的一条红色龙虾引起了伯乐的注意力，于是便请他为自己写的一个故事画插图，这就是后来那本有名的《棕色的熊，棕色的熊，你在看什么?》，这是他第一次为孩子画画，创作过程中那种自由浑洒的快感，让他找回了童年画画时的乐趣，成为他事业的开始。',
						books:[
						       {book_name: '《The very hungur caterpillar》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/2/4.jpg')}}',bl:'1.7-5.7',type:'Fiction'},
						       {book_name: '《From Head to Toe》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/2/5.jpg')}}',bl:'4.5',type:'Fiction'},
						       {book_name: '《10 Little Rubber Ducks 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/2/6.jpg')}}',bl:'2.8',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 3,
						name: '山姆·麦克布雷尼（Sam McBratney）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/3.jpg') }}',
						desc: 'Sam McBratney曾是中小学教师，但把教书之外的业余时间都给了创作，到1990年，他已经写了23部小说，读者主要针对年轻人。为了有更多的时间写作，1990年他提早申请了退休，之后专心写书。接下来的几年中，他有几本书得了奖，但影响仍然不大。后来，编辑建议他为小读者写图画书，于是，Sam McBratney开始与Anita Jeram合作，1994年，出版了《猜猜我有多爱你》，瞬间风靡全球，被译为50多种语言，销量达到3000万册，全书仅不到400个英文单词，却浓缩了生命中最单纯也最无私的情感。',
						books:[
						       {book_name: '《Guess How Much I Love You 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/3/7.jpg')}}',bl:'2.8',type:'Fiction'},
						       {book_name: '《Just You and Me》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/3/8.jpg')}}',bl:'3.5',type:'Fiction'},
						       {book_name: '《I Love It When You Smile  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/3/9.jpg')}}',bl:'2.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 4,
						name: '[美]苏斯博士（Dr. Seuss）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/4.jpg') }}',
						desc: '二十世纪最卓越的儿童文学家、教育学家。在美国，如果你问最受儿童欢迎的作者是谁？不论书店或图书馆人员都会告诉你是Dr.Suess，苏斯博士自1937年出版第一本书到现在一共创作了48本图画书，销售量达2.5亿册，曾获美国图画书最高荣誉凯迪克大奖和普利策特殊贡献奖，两次获奥斯卡金像奖和艾美奖。苏斯博士的童话世界天马行空、夸张奔放，善于将极具教育意识的情节植入故事之中，让孩子在张开想象的翅膀同时，还能学会一些人生最基本的道理，乐观、勇敢、平等、宽容……他还是一个单词魔法师，仅用数百个不断重复和变幻的简单单词就能讲完一个故事，而韵文式的行文读起来更是朗朗上口，强烈的节奏感更能帮助记忆，对于孩子的阅读启蒙和英语入门教育，都极具帮助意义。',
						books:[
						       {book_name: '《The Cat in the Hat》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/4/10.jpg')}}',bl:'2.1',type:'Fiction'},
						       {book_name: '《The Sneetches and Other Stories》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/4/11.jpg')}}',bl:'3.4',type:'Fiction'},
						       {book_name: '《Horton Hatches the Egg》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/4/12.jpg')}}',bl:'3.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 5,
						name: '[英]安东尼·布朗（Anthony Browne）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/5.jpg') }}',
						desc: '安东尼1946年出生于英国，自幼喜欢艺术，常常跟着父亲画画，除此之外还喜欢橄榄球、足球等体育运动。艺术学校毕业後，他成为了一名医学书籍插图画家，绘制了许多人体内部构造图，最初安东尼觉得这工作挺有趣，可三年之后他发现那不过是重复劳动，后来投身于明信片的制作，他的设计推陈出新而不落俗套，受到出版商的赏识，开始了他的插画生涯。有15年他一直在画廊设计明信片，《大猩猩》就是从生日贺卡上的一张图片开始的。1976年，他出版了自己的第一本书。不知是否受医学插画经验的影响，安东尼布朗喜欢精细描绘，例如常被他拿来当主角的大猩猩，身上毛发几乎每一根都清晰可辨。安东尼的作品具有超现实风格，常常穿梭于现实与想象之间，阅读他的作品，时常会惊讶作家心思的缜密、幽默风趣的表现，而其书中所带给孩子们的希望与愉悦，是儿童文学作品最难能可贵的珍宝。',
						books:[
						       {book_name: '《My Dad》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/5/13.jpg')}}',bl:'1.4',type:'Fiction'},
						       {book_name: '《Gorilla》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/5/14.jpg')}}',bl:'2.6',type:'Fiction'},
						       {book_name: '《Willy the Wimp》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/5/15.jpg')}}',bl:'2.0',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 6,
						name: '[美]大卫·香农（David Shannon）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/6.jpg') }}',
						desc: '1959年出生于美国华盛顿，曾在加州艺术中心设计学院学习绘画，为《纽约时报》《时报杂志》和《滚石杂志》画过插图，也曾设计过书籍封面。大卫开始创作儿童图画书是在1989年，让他一举成名的就是绘本《大卫，不可以》，该书曾在1998年荣获凯迪克银奖，因为这本书反响强烈，他又续写了两本《大卫上学去》和《大卫惹麻烦》，也同样畅销至今。除此之外，他的《鸭子骑车记》入选了美国纽约公共图书馆“每个人都应该知道的100种绘本”，《千万别去当海盗》荣获美国国家亲子出版奖，《糟糕，身上长条纹了！》《小仙女爱丽斯》《大雨哗啦哗啦下》也都是受到小朋友们热烈欢迎的图画书。如果用一个词形容大卫的图画，那就是“热闹”，他的画面中有着非常鲜明的个人特色，色彩浓郁，看起来有些拙稚，但人物形象饱满，而且他的故事中往往充满着奇思妙想，一路热热闹闹地读下来，像吃了一顿色香味俱全的大餐，让孩子们在欢声笑语中回味无穷。',
						books:[
						       {book_name: '《David Goes to School》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/6/16.jpg')}}',bl:'0.9',type:'Fiction'},
						       {book_name: '《Duck on a Bike》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/6/17.jpg')}}',bl:'2.0',type:'Fiction'},
						       {book_name: '《A Bad Case of Stripes》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/6/18.jpg')}}',bl:'3.8',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 7,
						name: '7.[英]罗尔德·达尔 Roald Dahl （1916-1990）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/7.jpg') }}',
						desc: '1916年出生于英国威尔士，1990年去世。是当代世界最重要的奇幻文学作家之一。他的作品构思奇特，情节紧凑，在每个故事的一开始就打破现实与幻想之间的常规对应，给人一种或幽默或荒诞或机智的美感；同时更重要的是，他的作品都具有一种让人一读就爱不释手的魔力。2000年，英国在“世界图书日”期间进行的一次“我最喜欢的作家”投票中，达尔这个名字高踞榜首，连《哈里·波特》的作者J.K.罗琳也只能位列其后。身为作家，达尔的生平也是极富戏剧性色彩的，二战的时候去当空军，在空难中受伤，休养了六个月又跑回战场。后来被派驻美国担任情报官，就任三天后，星期六邮报的记者来访问他有关空军的生活，记者走了之后他干脆自己动笔，寄给对方，立刻得到热情的邀稿，开始了他的写作生涯。而后他和女明星Patricia Neal结婚，他的长子在四个月大的时候坐在婴儿车里被汽车撞了，脑水肿，眼睛失明，达尔因此自己和学者研发出一种可使症状减轻的医疗品，他的女儿Olivia在七岁的时候因痲疹死去。1968年，妻子Patricia Neal在怀女儿Lucy时三度中风。而后在1983年，两人离婚。他又娶了一个小他22岁的太太。',
						books:[
						       {book_name: '《Charlie and the Chocolate Factory 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/7/19.jpg')}}',bl:'4.8',type:'Fiction'},
						       {book_name: '《James and the Giant Peach》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/7/20.jpg')}}',bl:'4.8',type:'Fiction'},
						       {book_name: '《The Witches》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/7/21.jpg')}}',bl:'4.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 8,
						name: '[美]泰德·阿诺德（Tedd Arnold）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/8.jpg') }}',
						desc: '泰德·阿诺德1949年出生于美国纽约，毕业于佛罗里达大学。他和从事幼教的妻子Carol定居于Tallahassee, 而他则从事商业插画的工作，已出版了50本儿童书籍。他的作品Fly Guy系列，其中两本荣获苏斯博士奖，多本荣获美国图书馆协会奖，整个系列一经问世就雄踞《纽约时报》畅销书榜，其中文版也获得了2006年度“最佳少儿图书”。该系列幽默搞笑的情节，漫画般的画风，颇受儿童喜爱，是传统章节书的入门级读本，书中大量使用夸张、双关，还有很多稚拙可爱的配图，在亲身阅读的过程中，感觉是畅快的，一气呵成的。这套绘本就像一颗洋葱，表面描绘着“重口味”，中间感受到十足的“搞笑”，内心却包裹着温暖。泰德·阿诺德极具漫画感的强烈个人画风，让人体验到了100%的北美艺术与文化风格。',
						books:[
						       {book_name: '《Fly Guy 系列 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/8/22.jpg')}}',bl:'1.2-4.8',type:'Fiction'},
						       {book_name: '《Parts 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/8/23.jpg')}}',bl:'2.6-2.8',type:'Fiction'},
						       {book_name: '《Huggly 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/8/24.jpg')}}',bl:'1.7-3.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 9,
						name: '简·约伦( Jane Yolen) ',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/9.jpg') }}',
						desc: '1939年出生于美国纽约，曾先后担任过儿童书画家协会会长、美国科幻作家协会会长，被美国的《新闻周刊》誉为“美国的安徒生”和“20世纪的伊索”。Jane是一位创作和编辑了300多部作品的著名作家，她的童书代表作有《魔鬼的算术》(The Devils Arithmetic ,1988)《如何让恐龙道晚安》(How do Dinosaurs Say Goodnight? ,2000),与华裔画家杨志成(Ed Young)合作的《皇帝和风筝》(The Emperor and The Kite,1968)和与约翰·勋伯赫合作的《月下看猫头鹰》分别赢得了1968年的凯迪克奖银奖、1988年凯迪克奖金奖。此外,她还曾经获得过两次星云奖(Nebula Awards)、克里斯托夫奖(Christopher Medals)、世界幻想文学奖(The World Fantasy Award)和三次神话幻想文学奖(Mythopoeic Fantasy Awards)等，她的作品被翻译成包括中文在内的多种文字，在全世界拥有数以亿计的读者。2010年，Jane Yolen被World Fantasy Awards授予了终身成就奖。',
						books:[
						       {book_name: '《How Do Dinosaurs...?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/9/25.jpg')}}',bl:'1.7-5.7',type:'Fiction'},
						       {book_name: '《Great Alta（3本）》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/9/26.jpg')}}',bl:'5.5',type:'Fiction'},
						       {book_name: '《Foiled（2本）》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/9/27.jpg')}}',bl:'2.9-3.2',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 10,
						name: '杨志成 Ed Young',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/10.jpg') }}',
						desc: '国际图画书界声名远扬的华裔图画书作家。在40多年的图画书生涯中，创作了80多本图画书，曾三度获得美国图画书较高荣誉——凯迪克大奖，作品分别是：《皇帝与风筝》《狼婆婆》《七只瞎老鼠》。杨志成1931年生于天津，3岁迁居上海，17岁移居香港，20岁赴美国伊利诺伊州立大学建筑系就读，后来又转到洛杉矶艺术学院学习广告设计，毕业后从事广告插画工作。杨志成受到了东方文化的熏陶，很好地融合了东西方艺术，形成了独特的风格。他的创作多以各国民间故事为内容，以现代绘画技巧，结合西方建筑美学对空间的架构观点，将中国绘画写意而非写实的意境成功带出，是中西合璧的典范。近年来，杨志成的野心，也是他停笔前坚持要做的一件事，就是以图画的方式还原象形文字哲学的精髓，用十本书解释《康熙字典》里的214个偏旁部首，目前已完成两本。',
						books:[
						       {book_name: '《Seven Blind Mice 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/10/28.jpg')}}',bl:'1.9',type:'Fiction'},
						       {book_name: '《The Emperor and the Kite》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/10/29.jpg')}}',bl:'4.6',type:'Fiction'},
						       {book_name: '《The Cat From Hunger Mountain》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/10/30.jpg')}}',bl:'4.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 11,
						name: '[美]莫·威廉斯（Mo Willems））',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/11.jpg') }}',
						desc: '1968年出生于美国的新奥尔良，毕业于纽约大学艺术学院。曾担任《芝麻街》的动画制作，作为一名专业的儿童电视节目编剧及动画制作人，在1993年到 2002年期间，共六次获得美国电视界最高奖项——艾美奖。2003年开始童书创作，其中《古纳什小兔》《别让鸽子开巴士》《古纳什小兔又来了》荣获凯迪克银奖，《小象小猪》系列荣获苏斯奖。无论是动画片还是童书，莫威廉斯的作品都深得孩子们的喜爱，被《纽约时报》誉为“21世纪最突出的新锐作家”。他是一个童心未泯的大小孩，书中那种自然散发的童真童趣，是刻意雕琢所不能及的。他喜欢用卡通漫画的形式创作作品，他觉得“简单的线条更容易集中读者的注意力，也有利于突出人物形象”。这种简洁的画法会让孩子有强烈的模仿欲望，激发孩子的绘画兴趣也是他创作的初衷之一。',
						books:[
						       {book_name: '《Pigeon 8 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/11/33.jpg')}}',bl:'0.7-1.3',type:'Fiction'},
						       {book_name: '《Elephant & Piggie 25 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/11/31.jpg')}}',bl:'0.6-1.1',type:'Fiction'},
						       {book_name: '《Knuffle Bunny 3 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/11/32.jpg')}}',bl:'1.6-2.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 12,
						name: '[美]琼?穆特（Jon J Muth）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/12.jpg') }}',
						desc: '1960年生于美国，母亲是艺术教师，幼时即已游遍国内的博物馆，18岁时就在美国威尔明顿学院举办了首场个人画展。为了维持生计，高中毕业后为漫画书配过插图，后在日本出版商的资助下赴日学习石雕与书道，从此对东方文化产生浓厚的兴趣。他涉猎广泛，不但在英国、奥地利和德国学习过绘画和版画复制，还曾学习过太极拳、水墨画和茶道，更是一位吉他高手。他以优美恬静的画风在绘本创作和插画领域享有盛誉，擅长将清透灵润的水彩画与发人深省的哲思故事结合在一起，作品中透着一种悠远的禅意和古老东方文化的神韵。作品《禅的故事》获得凯迪克大奖，《尼古拉的三个问题》被《纽约时报》称赞为能够“默默地改变生命”。此外，他还获得过美国插画师协会金奖、美国犹太图书馆协会奖（即雪莉·泰勒奖）。',
						books:[
						       {book_name: '《Stone Soup》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/12/34.jpg')}}',bl:'3.6',type:'Fiction'},
						       {book_name: '《Zen Shorts》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/12/35.jpg')}}',bl:'2.9',type:'Fiction'},
						       {book_name: '《The Three Questions: Based on a Story by Leo Tolstoy》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/12/36.jpg')}}',bl:'3.4',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 13,
						name: '[美]玛西娅·布朗（Marcia Brown）(1918-2015)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/13.jpg') }}',
						desc: '1918年出生于美国纽约，在美国绘本作家中，是一位十分传奇的人物，1946年，她出版了第一本绘本作品《The Little Carousal》，之后孜孜不倦地从事创作，共完成三十多本作品，以多变的风格和荣获无数奖项著名，包括三次美国图书馆学会最佳童书推荐，两次国际安徒生大奖提名，九次凯迪克大奖，是凯迪克大奖史上的最大赢家，至今仍保持着纪录，作品被翻译成德语、中文、日语、西班牙语等数种语言在全世界出版。其创作以各国民间故事为主，她一生酷爱旅行，足迹遍及欧洲、亚洲和非洲。不过绝对不是蜻蜓点水般地一走而过，每到一地，都会长时间地停留，细细地体验和品味当地的民风和民俗。1985年，67岁高龄的她，还曾经到杭州的浙江美术学院学习过中国水墨画。1992年，获得了美国图书馆协会设立的LauraIngalls Wilder Award，其他获得此项殊荣的作者有苏斯博士、莫里斯·桑达克等。',
						books:[
						       {book_name: '《Shadow》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/13/37.jpg')}}',bl:'3.2',type:'Fiction'},
						       {book_name: '《Once A Mouse...》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/13/38.jpg')}}',bl:'3.2',type:'Fiction'},
						       {book_name: '《Cinderella 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/13/39.jpg')}}',bl:'5.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 14,
						name: '(美)帕特里克·麦克唐奈(Patrick McDonnell)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/14.jpg') }}',
						desc: '世界著名自由插画家，1956年在美国新泽西州出生，毕业于视觉艺术学院。曾荣获全美漫画家协会鲁本奖的“年度风云漫画家”称号，获得国际卡通协会颁发的“年度连环漫画”奖，还五次拿到“哈维·连载漫画”奖。风靡全球的漫画作品MUTTS的创作者，其中，《Me……Jane》荣获2012年凯迪克银奖。MUTTS是帕特里克·麦克唐奈*重要的创作成果，MUTTS 读音为“马刺”，原意为蠢蛋、杂种狗，帕特里克以其作为漫画名，颇具揶揄之意，因为我们看到的，是一群萌猫呆狗的故事。帕特里克同时还是美国人道协会及动物基金的董事，长期致力于环境与动物的保护事业。',
						books:[
						       {book_name: '《Me...Jane》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/14/40.jpg')}}',bl:'3.2',type:'Fiction'},
						       {book_name: '《A Perfectly Messed-Up Story》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/14/41.jpg')}}',bl:'1.4',type:'Fiction'},
						       {book_name: '《Just Like Heaven》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/14/42.jpg')}}',bl:'2'},
						],
						open: false
				  },
				  {
						no: 15,
						name: '[美]罗伯特·麦克洛斯基（Robert McCloskey）（1914-2003）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/15.jpg') }}',
						desc: '美国著名插画家，1914年出生于美国俄亥俄州的一个小镇。少年时兴趣广泛，在高中开始为刊物绘制插画。他一生只画了八本图画书，却有四本都获得过凯迪克奖。其中最知名的作品《让路给小鸭子》，是罗伯特在波士顿公园得到的灵感，为了画好鸭子，他还专门在家里养了几只小鸭子观察。二战期间，他加入陆军，战后携妻女一起搬到了缅因州附近一个风光明媚的小岛上，“海边三部曲”《小赛尔采蓝莓》《海边的早晨》《美好时光》就是罗伯特在小岛居住时创作的，和家人在一起幸福的生活，总是带给罗伯特无穷的创作灵感，加上罗伯特慢工出细活的创作态度，让这三本图画书先后都获得了凯迪克奖。1964年，罗伯特取得了迈阿密大学的文学博士学位。2000年，他被美国国会图书馆列入“活着的传奇人物”名录，2003年6月30日在缅因州的家中去世。',
						books:[
						       {book_name: '《Make Way for Ducklings》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/15/45.jpg')}}',bl:'4.1',type:'Fiction'},
						       {book_name: '《Blueberries for Sal》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/15/43.jpg')}}',bl:'4.1',type:'Fiction'},
						       {book_name: '《Time of Wonder》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/15/44.jpg')}}',bl:'5.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 16,
						name: '[美]李欧·李奥尼（Leo lionni）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/16.jpg') }}',
						desc: '李欧被誉为“儿童文学界的寓言大师”“色彩魔术师”，以深入浅出、耐人寻味的小故事传达出隽永的人生智慧著名。李欧1910年5月出生于荷兰，父亲是比利时犹太商人，母亲是女高音歌唱家，从小就浸润在浓郁的艺术氛围之中。13岁时，他随家人辗转美国、意大利。1935年获得经济学博士学位。1945年，欧洲掀起反犹太浪潮，他们被迫举家走避美国。李奥尼是一位才华横溢、不受拘束的艺术天才，绘画、雕刻、平面设计、印刷、陶艺、摄影......样样精通，曾任美国《财富》杂志设计主管长达10 年，并曾担任美国平面造型艺术学会主席、国际设计大会主席。尽管李欧开始创作绘本时已经49岁，他却开创了一个绘本的新时代。《纽约时报》曾不惜溢美之词：“如果绘本是我们这个时代一种新的视觉艺术，李欧·李奥尼则是这种风格的大家。”',
						books:[
						       {book_name: '《Swimmy?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/16/46.jpg')}}',bl:'2.9',type:'Fiction'},
						       {book_name: '《Inch by Inch》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/16/47.jpg')}}',bl:'1.8',type:'Fiction'},
						       {book_name: '《Frederick》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/16/48.jpg')}}',bl:'3.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 17,
						name: '[美]莱恩·史密斯（Lane Smith）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/17.jpg') }}',
						desc: '美国著名图画书作家、插画家，1959年出生于美国俄克拉荷马州，毕业于洛杉矶帕沙迪纳艺术中心设计学院。其作品曾四次荣获《纽约时报》年度最佳图画书，三次美国插画家协会银奖，以及布拉迪斯双年展金苹果奖，他还有多部作品被收录在美国插画年鉴中。他创作且绘制插图的《这是一本书》连续六个月位列《纽约时报》童书榜，并已被翻译成20种语言。他创作的其他童书，如《五个小英雄》和《总统夫人》均荣登美国畅销书榜。他还曾为苏斯博士、罗尔德·达尔、杰克·普里卢斯基、弗洛伦斯·帕里·海德以及约翰·席斯卡等著名作家的书做过插图，其中《臭起司小子爆笑故事大集合》曾荣获凯迪克银奖。现在，他和妻子书籍设计师莫莉·里奇住在美国康乃迪克州郊外。',
						books:[
						       {book_name: '《Grandpa Green 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/17/49.jpg')}}',bl:'2.5',type:'Fiction'},
						       {book_name: '《John, Paul, George & Ben 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/17/50.jpg')}}',bl:'3.7',type:'Fiction'},
						       {book_name: "《Abe Lincoln's Dream 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/17/51.jpg')}}',bl:'3.0 ',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 18,
						name: '[美]艾诺·洛贝尔（Arnold Lobel））',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/18.jpg') }}',
						desc: '出生于1933年，美国著名童书作家及画家。他是代表二十世纪美国童书的一代巨匠，被称为最懂得尊重儿童智慧的作家。他的作品除了温馨、趣味之外，对于传统被认为是高层次思考才能接触的哲学论题，例如：勇气、意志力、友谊的本质、恐惧、智慧等，都能够用具体的形象，以说闲话的语气表达出来，让读者常常会发出“啊！”的感叹。1987年，Arnold Lobel离开了这个世界，当时，《纽约时报》登了一则启事——“ 如果你想念我，请不要设立基金会、奖学金或纪念碑，请看我的书，因为我就在里面。”Arnold Lobel曾经说过，创作对他来说其实非常不容易，但是只要想到世界上，每天都有人在读他的书，欣赏他的故事，他就感到非常的高兴。Arnold Lobel就是这样一位一直努力，并乐于为孩子创作的作家。',
						books:[
						       {book_name: '《Frog and Toad 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/18/52.jpg')}}',bl:'2.5-3.0',type:'Fiction'},
						       {book_name: '《Fables》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/18/53.jpg')}}',bl:'4.2',type:'Fiction'},
						       {book_name: '《Owl at Home》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/18/54.jpg')}}',bl:'2.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 19,
						name: '[美]丹·古特曼（Dan Gutman）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/19.jpg') }}',
						desc: '1955生于纽约，罗格斯大学心理专业毕业，《纽约时报》畅销作家，写过许多无厘头又有趣的童书，在美国小学生中非常有人气，代表作有“天才档案”系列，“棒球卡冒险”系列、“疯狂学校”系列等。他自己小时候并不喜欢阅读，可以说“疯狂学校”故事中的主人公就是他儿时的化身。古特曼的书笔调风趣，平易近人，即使是不爱读书的孩子们也会被他的故事吸引住。他的书深受儿童喜爱，迄今为止共获得了1 9个州的图书奖及92个州的图书提名奖。其代表作还有 《会写作业的机器》《作业机器归来》《寻找生机》《竞选总统的孩子》《我和霍努斯》《百万美元拍摄》《为天空而战》以及《爱迪生之谜》等等，如今，他和妻子及两个孩子生活在纽约。',
						books:[
						       {book_name: '《My Weird Schoo 系列l》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/19/57.jpg')}}',bl:'5.5-5.9',type:'Fiction'},
						       {book_name: '《Baseball Card Adventures 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/19/55.jpg')}}',bl:'5.2-5.5',type:'Fiction'},
						       {book_name: '《The Genius Files 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/19/56.jpg')}}',bl:'5.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 20,
						name: '[美]盖瑞·伯森（Gary Paulsen）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/20.jpg') }}',
						desc: '1939年出生于美国明尼苏达州，先后当过卡车司机、捕猎人、弓箭手、导演、演员、歌手、水手、工程师、农夫、教师，他职业的多样化造就了他丰富的人生经验。后来移居森林，潜心写作，作品大部分都取材于实际生活，成为一个说故事的高手。《手斧男孩》首部曲出版后，他几乎每天收到两百封读者来信，询问布莱恩后来怎么样了。由于《手斧男孩》内容精彩逼真，美国《国家地理杂志》误以为是真实事件，欲对布莱恩进行采访报道。至今《手斧男孩》已畅销全球2000000册，荣获美国知名大奖"纽伯瑞奖"(世界上两大儿童文学奖项之一，另一项是"国际安徒生文学奖")，被评为美国100年来最优秀的50部青少年图书之一。',
						books:[
						       {book_name: "《Brian's Saga 系列》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/20/58.jpg')}}',bl:'5.5-5.9',type:'Fiction'},
						       {book_name: '《The Tucket Adventures 系列》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/20/59.jpg')}}',bl:'5.2-5.5',type:'Fiction'},
						       {book_name: '《Harris and Me》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/20/60.jpg')}}',bl:'5.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 21,
						name: '[美]E·B·怀特（E. B. White）（1899－1985）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/1.jpg') }}',
						desc: '二十世纪美国最杰出的随笔作家，美国当代著名散文家、评论家，以散文名世，“其文风冷峻清丽，辛辣幽默，自成一格”。生于纽约蒙特弗农，毕业于康奈尔大学，作为《纽约客》主要撰稿人的怀特一手奠定了影响深远的 “《纽约客》文风”。怀特对这个世界上的一切都充满关爱，他的道德与他的文章一样山高水长。除了他终生挚爱的随笔之外，他还为孩子们写了三本书：《斯图尔特鼠小弟》《夏洛的网》与《吹小号的天鹅》，美国当代大作家厄普代克把怀特的这三部童话都归于儿童文学经典作品之列。其中最受欢迎的就是《夏洛的网》，至今已经发行5000万册以上，拥有20多种文字的译本。在美国1976年《出版周刊》做的一次读者调查中，这本童话位居“美国十佳儿童文学名著”中的首位，可见它受欢迎的程度。',
						books:[
						       {book_name: "《Charlotte's Web?》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/21/63.jpg')}}',bl:'4.4',type:'Fiction'},
						       {book_name: '《Stuart Little?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/21/61.jpg')}}',bl:'6.0',type:'Fiction'},
						       {book_name: '《The Trumpet of the Swan》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/21/62.jpg')}}',bl:'4.9',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 22,
						name: '[美]玛格丽特·怀兹·布朗（Margaret Wise Brown）（1910-1952）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/22.jpg') }}',
						desc: '1910年出生于纽约，美国图画书界先驱性人物，“黄金时代”代表人物之一，天才图画书作家，四次凯迪克奖获得者。很少有作家像玛格丽特·怀兹·布朗一样，与孩子们的关注点和情绪那么合拍。她将自己的文学志向与儿童发展和幼儿教育的研究结合了起来，不但为孩子写了十多本童书，更与一群好友为儿童文学的教育、创作与出版开拓出了一片天地。虽然她从来没有结过婚，也没有自己的孩子，但是她却对孩子，特别是幼儿期的孩子的心理、情绪和兴趣有着深刻的认识。她擅长用精简、游戏性、押韵的优美文字来铺陈故事，不但能深深打动孩子的心，更能开发孩子的想像力。1952年，42岁的玛格丽特在法国旅行途中突然逝世。',
						books:[
						       {book_name: '《The Runaway Bunny》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/22/64.jpg')}}',bl:'2.7',type:'Fiction'},
						       {book_name: '《Goodnight Moon 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/22/65.jpg')}}',bl:'1.8',type:'Fiction'},
						       {book_name: '《The Little Island》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/22/66.jpg')}}',bl:'3.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 23,
						name: '[美]罗兰·英格斯·怀德(Laura Ingalls Wilder)(1867-1957)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/23.jpg') }}',
						desc: '出生于威斯康新州大森林的一个拓荒者家庭。童年时的生活足迹几乎遍及美国西部，15岁时就为拓荒者们开办的小学执教。婚后迁往密苏里州曼斯费尔德，抚养女儿罗丝成人。1922年罗丝获得欧亨利奖。1932年劳拉出版了她的第一部作品《大森林的小木屋》。从65岁开始到她90岁去世的25年间，她总共出版了9卷系列图书，包括《农庄男孩》(Farmer Boy)、《草原上的小木屋》(Little House On The Prairie)、《在梅溪边》(On the Banks of Plum Creek)、《在银湖岸》(By the Shore of Silver Lake)、《漫长冬季》(The Long Winter)、《草原小镇》(Little Town on the Prairie)、《快乐的金色年代》(These Happy Golden Years)、《新婚四年》(The First Four Years)，被后人称作"小屋系列"(Little House Books)，现均为世界儿童文学的经典之作。',
						books:[
						       {book_name: '《Little House On The Prairie 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/23/67.jpg')}}',bl:'4.9',type:'Fiction'},
						       {book_name: '《Farmer Boy》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/23/68.jpg')}}',bl:'5.2',type:'Fiction'},
						       {book_name: '《By the Shores of Silver Lake》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/23/69.jpg')}}',bl:'5.3',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 24,
						name: '[美]亚当?雷克斯（Adam Rex）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/24.jpg') }}',
						desc: '生于1973，纽约时报畅销书作家、插画家，在美国出版界，尤其是童书出版领域广为人知，热播电影《疯狂外星人》的原作者。流传较广的作品有《梦幻月圆夜》（美国总统奥巴马也曾专门买给自己的女儿阅读）《嘘——》《胖吸血鬼》《冷麦片》《年轮马戏团》《叽叽喳喳的小比利》《蓝鲸是个大麻烦》《克洛伊和狮子》《弗兰肯斯坦制作三明治》等。每个人都有自己的偶像，年轻时候的亚当?雷克斯也一样，他的偶像是詹妮弗?洛佩兹——著名演员、歌手兼设计师，2007年，一直默默耕耘画插画的雷克斯决定为自己的偶像做点什么，于是满怀虔诚，写了本充满童趣的小说《疯狂外星人》（原名《斯迈克节的真正意义》），甚至书中主人公的名字就是偶像的名字。几年之后，这部作品被拍成电影，导演蒂姆?约翰逊决定成人之美，不仅邀请了詹妮弗?洛佩兹为本片配音，还邀请她演唱了电影主题曲。',
						books:[
						       {book_name: '《Moonday》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/24/72.jpg')}}',bl:'2.9',type:'Fiction'},
						       {book_name: '《Frankenstein Makes a Sandwich》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/24/70.jpg')}}',bl:'4.0',type:'Fiction'},
						       {book_name: '《The True Meaning of Smekday 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/24/71.jpg')}}',bl:'4.5',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 25,
						name: '[加拿大]乔恩·克拉森（Jon Klassen）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/25.jpg') }}',
						desc: '乔恩·克拉森来自于加拿大安大略省，现居住在美国洛杉矶，曾从事过动画片、音像及编辑等工作，曾横扫凯迪克金银奖。代表作《这不是我的帽子》是史上获奖最多的图画书，曾揽下凯迪克金奖等全球19项大奖。虽说奖项不能代表一切，但是一举囊括这么多大奖的绘本至少不应该错过。这是个有一点点“黑色幽默”的小故事，最被人关注的是“偷”被摆上了台面。小鱼喜欢上了大鱼的帽子，就“偷”了过来戴在自己头上，但是他不认为这是“偷”，他有许多许多的理由来解释。在跟孩子讲读这本书的时候，你是怎么理解“偷”呢？你会如何跟孩子交流关于“偷”的内容与实质？通过《这不是我的帽子》，你会看到孩子的心理和世界。《穿毛衣的小镇》则融合了水墨、水粉和电脑制图的独特绘画技法，为我们讲述了一个温暖人心而又引人深思的故事。',
						books:[
						       {book_name: '《I Want My Hat Back 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/25/70.jpg')}}',bl:'1.0',type:'Fiction'},
						       {book_name: '《This Is Not My Hat》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/25/72.jpg')}}',bl:'1.6',type:'Fiction'},
						       {book_name: '《We Found a Hat 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/25/71.jpg')}}',bl:'1.3',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 26,
						name: '[美]麦克?巴内特（Mac Barnett）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/26.jpg') }}',
						desc: '麦克?巴内特，美国著名图画书作家，作品本本都是精品，深受孩子们的喜爱。代表作包括《蓝鲸是个大麻烦》《一起来传话》《克洛伊和狮子》《再猜猜！》《哦，不!》《胡子！》《穿毛衣的小镇》《布里克斯顿兄弟》系列等。其中《穿毛衣的小镇》获得了《波士顿环球报》号角图书奖、2013年凯迪克银奖。麦克还是洛杉矶回声公园“时光之旅”商店的创始人，同时也是“LA826”（洛杉矶826中心）组织的成员，这个组织是一个提供写作训练和指导的非营利机构，他的诸多作品都是在这个组织里，和孩子们朝夕相处中获得的灵感。麦克现在居住在美国加利福尼亚州奥克兰市。',
						books:[
						       {book_name: '《Extra Yarn》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/26/73.jpg')}}',bl:'3.2',type:'Fiction'},
						       {book_name: '《Billy Twitters and His Blue Whale Problem  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/26/74.jpg')}}',bl:'3.0',type:'Fiction'},
						       {book_name: '《The magic school bus》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/26/75.jpg')}}',bl:'1.9',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 27,
						name: '[美]马乔里·温曼·萨马特（Marjorie Weinman Sharmat）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/27.jpg') }}',
						desc: '1928年出生于美国缅因州波特兰市，从小就梦想要成为一名作家。著有130多本儿童读物，还创作了多部电影电视小说。她的另一个儿时梦想是成为一名侦探，这也就促成了后来Nate The Great《大侦探内特》系列的诞生，该系列获奖无数，包括洛杉矶国际儿童文学奖等权威大奖，畅销40多年，销量超过1500万册，在美国被誉为“最具开创性的儿童小说”，被纽约图书馆评选为“儿童百大阅读首选”，是很多美国学校推荐的必读书目，适合5-12岁孩子阅读，有助于培养孩子的逻辑推理能力和英语阅读习惯。她的作品多次被拍成电影电视，书籍已经被翻译成19种语言在世界各地出版。她的丈夫Mitchell Sharmat（米切尔·萨马特）同样也是许多儿童读物的作者，她同丈夫一起居住在美国亚利桑那州。',
						books:[
						       {book_name: '《Nate the Great?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/27/76.jpg')}}',bl:'2.0-3.2',type:'Fiction'},
						       {book_name: '《Olivia Sharp, Agent for Secrets》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/27/77.jpg')}}',bl:'3.0',type:'Fiction'},
						       {book_name: '《Maggie Marmelstein?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/27/78.jpg')}}',bl:'4.0-4.2',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 28,
						name: '[美]辛西娅·赖蓝特（Cynthia Rylant）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/28.jpg') }}',
						desc: '1954年出生于美国，广受年轻人喜欢的作者、图书管理员，已著有一百余本青少年读物，包括我们耳熟能详的Henry and Mudge,Annie and Snowball和Mr. Putter&Tabby系列。辛西娅是一位多产的作家，她的作品往往是依据自己的生活背景创作的，特别是在西弗吉尼亚山的童年生活。她不仅是一位儿童图画书作家、插画家，同时还创作小说、散文、诗歌等。她的许多作品都和动物有关，她本人也非常喜欢猫和狗，她旧时的很多宠物都曾出现在她的作品中。辛西娅和其他作者的不同之处在于，她并没打算成为一个作家，她只不过是想做一些有意义的事。她的作品获奖无数，有多部著作多次获奖，包括：Missing May-纽伯瑞文学奖，A Fine White Dust-纽伯瑞文学奖，When I Was Young in the Mountains-美国图书奖。',
						books:[
						       {book_name: '《Henry and Mudge 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/28/79.jpg')}}',bl:'10.6-3.0',type:'Fiction'},
						       {book_name: '《Mr. Putter & Tabby 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/28/80.jpg')}}',bl:'1.9-3.5',type:'Fiction'},
						       {book_name: '《Poppleton》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/28/81.jpg')}}',bl:'2.0-2.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 29,
						name: '[美]凯瑟琳·拉丝基（Lasky, Kathryn）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/29.jpg') }}',
						desc: '美国著名作家，已出版70多本书，题材包括历史小说、图画书和纪实类作品等。她是美国《纽约时报》、《出版人周刊》畅销书排行榜重点推荐的图书作家。其作品《糖衣时代》曾荣获纽伯瑞儿童文学奖银奖；《黑夜之旅》曾荣获美国全国犹太图书奖；《盛装游行》曾获美国图书馆协会颁发的ALA*童书大奖。除此之外，她还是《波士顿环球报》奖、《华盛顿邮报》儿童图书协会奖得主。 开始写作至今，狼、猫头鹰、熊等动物一直是凯瑟琳·拉丝基爱好、研究的对象。因丈夫任职美国《国家地理》摄影记者、纪录片制片人之便，凯瑟琳·拉丝基有机会深入动物的生存环境，观察动物习性，了解它们的生存习性与生活细节。加之笔下丰富多彩的文学想象与优雅传神的文学笔墨，使她赢得美国“动物奇幻小说女王”的美誉。',
						books:[
						       {book_name: '《The Rescue》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/29/82.jpg')}}',bl:'5.3',type:'Fiction'},
						       {book_name: '《Lone Wolf 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/29/83.jpg')}}',bl:'6.2',type:'Fiction'},
						       {book_name: '《More Than Magic》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/29/84.jpg')}}',bl:'3.9',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 30,
						name: '[美]理查德·斯凯瑞（Richard Scarry）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/30.jpg') }}',
						desc: '1919年出生于波士顿，美国最负盛名的儿童畅销书作家。一生创作儿童图书三百余部，全球销量超过3亿册，是世界童书界的幽默大师，2012年被插画家协会追授终生成就奖。他的“金色童书”系列风靡世界四十余年，陪伴了一代又一代人的成长，是美国家庭书架和美国国家图书馆的必藏书。以善良可爱的动物形象来模拟人类的行为，向孩子揭示日常生活的秘密，是斯凯瑞童书的特色。图书中丰富的信息量，精心设计的微小细节，以及故事中的游戏性和天马行空般的想象，会引导孩子长时间地投入观察和阅读，培养他们的观察力和想像力。斯凯瑞的童书对于幼儿学习语言，了解自然界和社会生活有着很大的帮助，非常适合亲子阅读。斯凯瑞的童书中充满了快乐和温情，在世界范围内受到了广泛欢迎。他曾说：“我不希望我写出的书是那种读过一遍以后就放在书架上，从此被遗忘的书。如果人们将我的书读旧了，甚至破到需要用透明胶带粘起来，是对我的褒奖。”',
						books:[
						       {book_name: '《What Do People Do All Day? 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/30/85.jpg')}}',bl:'3.4',type:'Fiction'},
						       {book_name: '《Cars and Trucks and Things That Go》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/30/86.jpg')}}',bl:'2.8',type:'Fiction'},
						       {book_name: "《Richard Scarry's A Day at the Airport》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/30/87.jpg')}}',bl:'2.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 31,
						name: '[英]约翰·范登（John Farndon）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/31.jpg') }}',
						desc: '英国科普作家，主要跟DK合作，已经出版过几十本科普图书，他是DK PLANETS的作者之一。作品被国内引进的有《彩图袖珍百科全书》，DK《探索岩石与矿物》等科普图书。他曾4次入围“英国皇家学会科学图书奖”决选名单，该奖是国际公认的科普图书奖项，4次入围足以证明他强大的实力。约翰·范登拥有剑桥大学科学和英国文学双学位，有26年创作经验，出版超过300本图书，创作题材十分广泛，涉及地球科学、自然知识、环境话题、社会问题等诸多领域，他的作品曾登上纽约时报和华盛顿邮报两大畅销书排行榜，获得过“美国国家图书奖”等诸多重量级奖项。此外，他还是一名多才多艺的剧作家和作曲家。约翰·范登的作品是写给孩子的趣味科学小百科，能充分满足孩子好奇的天性，启发他们从生活中去发现问题，思考问题，从小培养良好的科学习惯。',
						books:[
						       {book_name: "《Stickmen's Guide to Aircraft 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/31/88.jpg')}}',bl:'6.4',type:'Nonfiction'},
						       {book_name: '《Amazing Land Animals 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/31/89.jpg')}}',bl:'5.7',type:'Nonfiction'},
						       {book_name: '《Archaeology 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/31/90.jpg')}}',bl:'6.2',type:'Nonfiction'},
						],
						open: false
				  },
				  {
						no: 32,
						name: '[德]米切尔·恩德（Michael Ende，1929-1995）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/32.jpg') }}',
						desc: '德国著名作家，曾做过演员，1954年开始剧本写作，五十年代末开始为孩子创作，七十年代后闻名世界。米切尔·恩德1929年生于德国巴伐利亚的小镇加米施·帕腾基兴。他在一个充满文化气息的家庭中长大，曾活跃于南方的戏剧舞台，然而他真正的志趣却在于幻想文学的创作。他的成名作《小纽扣吉姆和火车司机卢卡斯》，荣获了1961年德国青少年文学奖。他最杰出的代表作当属《毛毛》和《永远讲不完的故事》，《毛毛》是一部轰动世界的时间幻想小说，与《格林童话》齐名，荣获德国青少年图书奖等12项国际国内大奖，译作达39种语言，是一部能同时感动孩子和大人的经典之作。自出版之日起，30多年来一直畅销不衰，米切尔·恩德也因此成为德国优秀的幻想文学作家，在欧洲乃至全世界都产生了深远的影响。',
						books:[
						       {book_name: "《The Neverending Story 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/32/91.jpg')}}',bl:'5.9',type:'Fiction'},
						       {book_name: '《Momo》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/32/92.jpg')}}',bl:'6.6',type:'Fiction'},
						       {book_name: '《Norberto Nucagorda》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/32/93.jpg')}}',bl:'5.5',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 33,
						name: '[英]迈克·莫波格（Michael Morpurgo）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/33.jpg') }}',
						desc: '迈克1943年出生于英国的赫特福德郡, 他是一位著名的儿童、青春文学畅销作家，诗人，编剧和作词人，迄今为止作品已有百余部，得奖无数，多部作品曾被翻拍成电影、电视剧、舞台剧和歌剧。迈克曾经还担任过小学教师，他说，“我们必须每天为孩子们讲一个故事，但是我却逐渐厌倦了书本上那些不变的故事。我决定告诉孩子们一些不一样的东西，当孩子们全神贯注地听着时，我可以看到这些故事在他们身上所产生的魔力，并且意识到它对我也产生了魔力。”迈克就是这样在教书的过程中发现了自己说故事的天赋。此外，迈克还积极投身于公益事业中，与妻子共同成立了“城市儿童下农场”计划（Farms For City Children），意在通过让平日生活在城市中的青少年们在乡村农场中生活工作一星期，来帮助增加他们贫乏的生活经验。迈克现在居住在德文郡，他时常与孩子们一起生活劳动，这给了他很多创作的灵感。',
						books:[
						       {book_name: '《WAR HORSE 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/33/94.jpg')}}',bl:'5.9',type:'Fiction'},
						       {book_name: '《Private Peaceful》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/33/95.jpg')}}',bl:'5.2',type:'Fiction'},
						       {book_name: "《Kensuke's Kingdom 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/33/96.jpg')}}',bl:'4.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 34,
						name: '[芬兰]托芙·扬松(Tove Jansson，1914-2001)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/34.jpg') }}',
						desc: '世界著名奇幻文学大师，代表作《小木民矮子精》系列童话。1914年扬松出生于芬兰首都赫尔辛基，父亲是一位雕塑家，母亲是一位画家。在芬兰，她的家庭属于外来的、说瑞典语的少数民族。可以想象，在一个很少能够找到和自己说一样语言，有一样生活习惯的邻居的地方，童年时代的杨松多多少少会感觉有些孤单。1966年，扬松获得国际安徒生奖。这是世界儿童文学的最高奖项，素有"小诺贝尔奖"之称。她创作的“姆咪谷”系列故事向读者展示了一个充满真诚、善良和美的新奇世界。她作品中那些鲜活可爱的姆咪矮子精住在森林里，样子像直立的微型小河马，胖胖的，很羞涩，热爱阳光。他们同自己生活的森林环境形成了一个统一和谐的世界。扬松笔下的这些故事现在已拍成了卡通片在世界各地上映，因此姆咪矮子精在世界各国也成了孩子们耳熟能详的角色。由于其文学艺术活动为世界儿童文学做出的巨大贡献，扬松于1966年荣获国际安徒生儿童文学作家奖。',
						books:[
						       {book_name: '《Comet in Moominland 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/34/97.jpg')}}',bl:'5.4',type:'Fiction'},
						       {book_name: "《Moomin's Winter Follies》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/34/98.jpg')}}',bl:'2.4',type:'Fiction'},
						       {book_name: '《Moominvalley in November》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/34/99.jpg')}}',bl:'5.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 35,
						name: '弗朗西斯卡·西蒙（Francesca Simon）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/35.jpg') }}',
						desc: '1955年2月23日出生于美国加利福尼亚州，2008年英国童书年度大奖的获得者，代表作Horrid Henry淘气包亨利系列。西蒙童年时期住在加利福尼亚州的海边，而后前往耶鲁大学和牛津大学学习中世纪历史与文学，现与家人居住在伦敦。她已创作超过45部作品，所著《淘气包亨利之可恶大雪人》一书获得2008年英国银河图书奖的儿童文学作品奖。她是美国历史上唯一一位获得银河图书奖的作家，最受欢迎的作品是“淘气包亨利”系列，该系列在英国持续占据畅销榜首位，在全球24个国家出版，被翻译成27种语言，销量达1900万册，并被拍摄成动画片，很难想象这么一位亲切的女作家，创作了这么一个调皮的小男孩。',
						books:[
						       {book_name: '《Horrid Henry 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/35/102.jpg')}}',bl:'3.3',type:'Fiction'},
						       {book_name: '《Hello, Moon! 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/35/100.jpg')}}',bl:'1.2',type:'Fiction'},
						       {book_name: '《Jogger’s Big Adventure》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/35/101.jpg')}}',bl:'2.5',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 36,
						name: '[爱尔兰]马丁·韦德尔（Martin Waddell）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/36.jpg') }}',
						desc: '1941年出生于北爱尔兰的贝尔费斯特，知名的爱尔兰作家，2004年国际安徒生奖作家奖的得主，代表作《小猫头鹰》《你睡不着吗》《弗兰琪的故事》等。一生创作近百本书，以童书为主，而其中又以Little Bear最著名，当年该系列的第一本《你睡不着吗》推出时，被伦敦时报评为：有史以来写的最好，画的最棒的一本童书。隔年也不负众望，荣获英国童书最大奖“凯特·格林纳威大奖”。而当年国际安徒生文学大奖评审给他的赞辞是：这位富有创造力的作者，有出众的理解力，作品深具同情和温暖，他以质朴、天真无邪的小孩子的同理心的和尊重的态度为儿童写作。马丁·韦德尔命运坎坷，比如他曾经在教堂里阻止破坏分子的时候差点遭遇了爆炸。他幽默地说：“我曾经被炸毁、活埋，还得过癌症，但我还是活了下来并如期长成了一个大人，所以我很幸运。”作为一个作家，所有这些经历，都变成了一笔宝贵的财富。',
						books:[
						       {book_name: "《Can't You Sleep, Little Bear?》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/36/103.jpg')}}',bl:'3.3',type:'Fiction'},
						       {book_name: '《Owl Babies》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/36/104.jpg')}}',bl:'2.4',type:'Fiction'},
						       {book_name: '《The Pig in the Pond》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/36/105.jpg')}}',bl:'1.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 37,
						name: '[美] 乌利?舒利瓦茨(uri Shulevitz)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/1.jpg') }}',
						desc: '1935年生于波兰，在父母的鼓励下，3岁开始画画。4岁时二战爆发，辗转搬家后，于1947年来到巴黎，12岁时参加小学素描比赛并得奖，1949年搬到以色列，15岁时素描作品在特拉维夫美术馆展出，成为在该馆展出作品最年轻的艺术家。15岁-17岁时一边工作一边在夜校学习。1959年24岁时赴美国，学习绘画的同时，在纽约一家出版社开始为儿童读物画插图。通过这些经历，他摸索出了新的儿童读物插画模式，1963年发表了第一部自编自画的图画书《我房间里的月亮》，1969年以《飞船和世界第一个傻瓜》获得了凯迪克奖。至今发表过近50部作品，多次获得了凯迪克奖、夏洛特·左罗托奖、金风筝童书奖、美国《纽约时报》年度优良好书奖等多项奖项。舒利瓦茨不但是一位艺术家，同时也是一位评论家，他个人对艺术的评判标准是：真正的图画书，必须融合了艺术和文字的形式。也因此，他的作品常能深入人心，受到大众的喜爱。他目前居住在美国纽约市。',
						books:[
						       {book_name: '《The Treasure》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/37/106.jpg')}}',bl:'3.0',type:'Fiction'},
						       {book_name: '《Cuando me visto de marinero》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/37/107.jpg')}}',bl:'2.3',type:'Fiction'},
						       {book_name: '《Rain Rain Rivers》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/37/108.jpg')}}',bl:'1.5',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 38,
						name: '[美]凯特·迪卡米洛（Kate Dicamillo）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/38.jpg') }}',
						desc: '生于美国宾西法尼亚州，在佛罗里达州长大，大学时代主修英美文学。代表作《爱德华的奇妙之旅》《傻狗温迪克》《弗罗拉与松鼠侠》，凯特曾六次获得国际大奖，在热播韩剧《来自星星的你》中，她更是透过爱德华，成为都教授情感之路上的心灵导师，著名作家殷健灵将她视为“遥远世界另一端未曾谋面的知音”，《弗罗拉与松鼠侠》更是奥巴马推荐给女儿的必读书。她的作品能以清浅语言说深奥繁复的人生，以温暖情愫的文字气息，带你领略看到却无法触摸的爱与苍茫，她的作品就是具有这样的魔力，能把你从黑暗中拯救出来，带给你新的光明……以《夏洛特的网》一书闻名于儿童文学界的E.B.怀特曾说：“所有我想要在书里表达的，甚至所有我这辈子所要表达的就是，我真的喜欢我们的世界。”凯特认为这句话也正是她写作的心情。',
						books:[
						       {book_name: '《The Miraculous Journey of Edward Tulane 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/38/110.jpg')}}',bl:'4.4',type:'Fiction'},
						       {book_name: '《Because of Winn-Dixie》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/38/109.jpg')}}',bl:'3.9',type:'Fiction'},
						       {book_name: '《The Tale of Despereaux 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/38/111.jpg')}}',bl:'4.7',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 39,
						name: '[美] 克里斯?范?奥尔斯伯格(Chris van Allsburg)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/39.jpg') }}',
						desc: '美国杰出儿童文学作家、画家。1949年出生于美国密歇根州，毕业于密歇根大学雕塑专业，曾在罗德岛设计学院任教，并成立了自己的雕刻工作坊，开始创作绘画作品，他的画曾在惠特尼美术馆和近代美术馆展出。奥尔斯伯格被誉为“美国最具才华的绘本大师之一”，他的作品构图精妙，具有雕塑般的独特质感，善于运用细腻的画面和变幻的光影，营造谜一样的超现实氛围。在他的书中，图像与文字相得益彰，共同烘托出亦真亦幻的气氛，带给读者无尽的遐想。奥尔斯伯格的代表作有：《魔法师的奇幻花园》1980年获凯迪克银奖，《勇敢者的游戏》1982年获凯迪克金奖，《北极特快车》1986年获凯迪克金奖，此外还有《仅仅是个梦》《勇敢者的游戏2》《西风号的残骸》《甜蜜的无花果》等。',
						books:[
						       {book_name: '《The Polar Express》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/39/115.jpg')}}',bl:'3.8',type:'Fiction'},
						       {book_name: '《The Garden of Abdul Gasazi 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/39/114.jpg')}}',bl:'4.0',type:'Fiction'},
						       {book_name: '《Jumanji》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/39/113.jpg')}}',bl:'3.9',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 40,
						name: '[美] 谢尔·希尔弗斯坦（Shel Silverstein）(1930-1999)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/40.jpg') }}',
						desc: '美国著名的诗人、插画家、剧作家、作曲家、乡村歌手，以及20世纪最伟大的绘本作家之一。谢尔的绘本作品被翻译成30多种语言，全球销量超过1.8亿册。1974年《爱心树》的出版轰动文坛，一举奠定了谢尔在当代美国文学界的地位。在此后几十年，该书畅销不衰，累计销量起过550万。其他作品有：《失落的一角》《失落的一角遇见大圆满》《阁楼上的光》《人行道的尽头》《往上跌了一跤》等。谢尔的绘本作品幽默温馨；简单朴实的插图、浅显的文字、淡淡的人生讽刺与生活哲学，不仅吸引儿童，更掳获了大人们的心。 他为电影《明信片的边缘》所作的歌曲I’m Checking Out获得1991年第63届奥斯卡最佳原创歌曲奖提名；《人行道的尽头》同名唱片还获得1984年格莱美奖。',
						books:[
						       {book_name: '《Who Wants a Cheap Rhinoceros?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/40/118.jpg')}}',bl:'2.8',type:'Fiction'},
						       {book_name: '《The Missing Piece Meets the Big O 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/40/117.jpg')}}',bl:'2.4',type:'Fiction'},
						       {book_name: '《The Giving Tree 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/40/116.jpg')}}',bl:'2.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 41,
						name: '[美]大卫?司摩(David Small) ',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/41.jpg') }}',
						desc: '美国知名图画书作家，曾两次获得凯迪克大奖。1945年出生于密西根州的底特律，韦恩州立大学毕业，耶鲁大学艺术硕士。童年时期的大卫身体孱弱，长期独自卧病在床，使得他日后的作品常流露出对人性孤独的探讨和克服困难的主题。大卫还曾多次在夏天前往印地安纳州乡下与祖父母同住，使得他对动物与乡村生活有一份特殊的感情和喜爱，对日后的创作也产生了一定影响。在耶鲁大学取得艺术硕士后，大卫曾在大学教绘画长达十四年之久，后来由于校方删减经费而失业，从此开始创作。除了自写自画外，他还与妻子Sarah Stewart共同创作了许多著名的绘本，如《The Journey》、《The Friend》、《小恩的秘密花园》《爱书人黄茉莉》等等。大卫擅长以水彩、墨水与粉彩作画，画风生动幽默，速写式的明快线条，加上柔和淡雅的色彩，传神地表现出人物的表情和姿态。',
						books:[
						       {book_name: '《So You Want to Be President?》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/41/121.jpg')}}',bl:'4.8',type:'Fiction'},
						       {book_name: "《Imogene's Antlers 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/41/119.jpg')}}',bl:'2.6',type:'Fiction'},
						       {book_name: '《One Cool Friend  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/41/120.jpg')}}',bl:'3.1',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 42,
						name: '[美]莱斯利(Leslie Patricelli)',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/42.jpg') }}',
						desc: 'Leslie学过传播学，跨过很多行业，华盛顿大学毕业后，在美国当过广告撰稿人，还跑去意大利当过滑雪教练，但是最有名的还是她给孩子们创作的小毛孩David系列绘本，目前她又开启了中级小说的撰写。小毛孩David系列被评为幼儿品格教育优秀绘本、幼儿行为认知发展绘本15本必读书单之一。或许因为Leslie是三个孩子的妈妈，她对于孩子性格、情绪和习惯的拿捏显得特别准确而自然，用风趣幽默的文笔加上萌萌哒画风为小朋友搭建了起行为规范，也使这套书成了很多新生代父母的育儿手册式绘本。',
						books:[
						       {book_name: '《Be Quiet, Mike!》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/42/123.jpg')}}',bl:'3.2',type:'Fiction'},
						       {book_name: '《The Birthday Box  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/42/124.jpg')}}',bl:'0.8',type:'Fiction'},
						       {book_name: '《The Patterson Puppies and the Rainy Day》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/42/125.jpg')}}',bl:'2.4',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 43,
						name: '[美]诺顿?贾斯特（Norton Juster）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/43.jpg') }}',
						desc: '贾斯特是一个多才多艺的人，美国著名儿童文学作家。出身于建筑世家，曾是大学建筑系教授，却作为儿童文学作家闻名于世，此外，他还是一名专业美食家。他的许多作品都受到高度赞扬，其中包括改编为动画片后获得奥斯卡大奖的《点与线》。他所创作的《The Phantom Tollbooth》（神奇的收费亭）至今为各国小朋友所喜爱，与画家Chris Raschka合作的《神奇的窗子》，获得2006年凯迪克大奖。《神奇的收费亭》是贾斯特最知名的作品，首印于1961年，历经五十多年而不衰，已经成为世界儿童文学宝库中不朽的经典，被翻译成多种语言，畅销千万册。该故事不断被改编成电影、动画、戏剧、话剧、音乐剧和交响乐，在全世界的学校和剧院演出。根据本书改编拍摄的《幻象天堂》被评为“全球最佳动画片”。',
						books:[
						       {book_name: '《The Phantom Tollbooth》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/43/128.jpg')}}',bl:'6.7',type:'Fiction'},
						       {book_name: '《The Hello, Goodbye Window  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/43/127.jpg')}}',bl:'3.4',type:'Fiction'},
						       {book_name: '《The Dot & the Line》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/43/126.jpg')}}',bl:'5.0',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 44,
						name: '[美]大卫·威斯纳（David Wiesner）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/44.jpg') }}',
						desc: '1956年出生于美国新泽西州，美国杰出的插画师和童书创作者，凯迪克大奖的常胜将军（包括三次金奖和三次银奖），主要代表作：《疯狂星期二》《三只小猪》《海底的秘密》《梦幻大飞行》《7号梦工厂》等。从中学时代开始，他便对用图画书讲故事的方式产生了浓厚兴趣，并开始尝试拍默片和创作没有文字的漫画。他上学时绘制过长达274厘米的作品，该作被视为《梦幻大飞行》的最初灵感来源。大卫·威斯纳热衷于无字图画书的创作，他认为无字书能为图画书留下神秘；能让想象有奔驰的空间；能让读者更接近这些插画，并能随心所欲地参与其中，用自己内在的声音创作自己的故事。《纽约时报》称其创作的无字书是无字书领域的经典，看他的书能带给你电影般的视觉享受和令人瞠目的想象力。无字书没有文字符号的限制，有助于孩子释放想象力和创造力，同时提高审美能力，甚至创作出自己的故事。目前，他与妻子及他们的儿女住在费城。',
						books:[
						       {book_name: '《Hurricane》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/44/129.jpg')}}',bl:'3.1',type:'Fiction'},
						       {book_name: '《June 29, 1999》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/44/130.jpg')}}',bl:'3.6',type:'Fiction'},
						       {book_name: '《The Three Pigs 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/44/131.jpg')}}',bl:'2.3',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 45,
						name: '[美]杰里·平克尼（Jerry Pinkney）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/45.jpg') }}',
						desc: '著名非裔美籍插画家。1939年出生于美国费城，4岁开始画画，毕业于费城艺术学院，从1964年起，专攻儿童读物的插图，至今创作了100多本绘本，还成功举办了30多次个人作品回顾展。现为多所大学的艺术教授，住在纽约州。他是多种奖项和荣誉奖的获得者，曾6次获得凯迪克奖，作品分别为《丑小鸭》《约翰·亨利》《米兰迪和风哥哥》《说话的蛋》《狮子和老鼠》《诺亚方舟》，还曾4次获得《纽约时报》最佳插图奖，5次获得克莱塔·斯科特?金奖（其中两次获得金奖章），另外获得插画家协会的2枚金质奖章和4枚银质奖章。平克尼的绘画连年在美国国内和世界各地的博物馆展出，在1998年，他还成为国际安徒生插图奖的美国候选人。目前，平克尼与妻子——作家格洛丽雅?简?平克尼居住在纽约的哈德逊克罗顿。',
						books:[
						       {book_name: "《Noah's Ark》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/45/134.jpg')}}',bl:'3.3',type:'Fiction'},
						       {book_name: '《The Little Red Hen 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/45/132.jpg')}}',bl:'3.1',type:'Fiction'},
						       {book_name: '《Puss in Boots》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/45/133.jpg')}}',bl:'4.6',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 46,
						name: '[英]朱莉娅·唐纳森（Julia Donaldson）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/46.jpg') }}',
						desc: '英国殿堂级儿童文学作家、剧作家，她长期为儿童电视节目创作歌曲，编写剧本。唐纳森的作品兼具文学性和儿童趣味，而她的音乐天赋也使作品更富于韵律感，朗朗上口，深受孩子和家长的喜爱，《出版者周刊》这样评价其作品：适合孩子们大声朗读的一流的作品。唐纳森曾创作出许多优秀的图画书，其中妇孺皆知的便是大名鼎鼎的《咕噜牛》。2011年，她被英国皇室授予大英帝国员佐勋章。2011-2013年，她被评为英国儿童文学桂冠作家。唐纳森热衷于歌唱和戏剧，非常鼓励孩子们大胆表演用图画故事改编成的儿童剧。她希望通过表演让孩子爱上读书。她与著名儿童文学作家共同编创了系列书——“边演边读”的阅读六法，分学前阶段和小学阶段。她还创建了互动网站，为家长和老师提供指导，如何选择能够成为儿童剧表演的图画书。',
						books:[
						       {book_name: '《The Gruffalo 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/46/137.jpg')}}',bl:'2.3',type:'Fiction'},
						       {book_name: '《Room on the Broom 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/46/136.jpg')}}',bl:'3.7',type:'Fiction'},
						       {book_name: '《The Snail and the Whale 》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/46/138.jpg')}}',bl:'4.0',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 47,
						name: '[瑞士]马克斯·菲斯特（Marcus Pfister）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/1.jpg') }}',
						desc: '1960年出生在瑞士的伯尔尼，瑞士著名画家，代表作“彩虹鱼”系列。毕业于瑞士伯恩艺术学院。1986年他创作的第一本图画书《疲惫的猫头鹰》一出版，就在童书界大放异彩，此后陆续推出其他作品，以独特的绘画风格在图画书界确立了一席之地。1992年，他在瑞士首次出版的《我是彩虹鱼》印刷了三万册，马上销售一空，很快这条小鱼便游出了瑞士，游出了欧洲，游向了世界各地，“彩虹鱼”系列绘本至今已被翻译成50多种文字，全球销量达到3000多万册，先后荣获意大利博洛尼亚国际儿童书展最佳选书奖、法国图书馆儿童图画书特别奖、美国年度畅销童书大奖、美国童书协会儿童票选最佳图书奖、美国纽约图书馆协会三苹奖等10多项国际大奖。马克斯·菲斯特有四个孩子，现在居住在瑞士伯尔尼。',
						books:[
						       {book_name: '《The Rainbow Fish》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/47/141.jpg')}}',bl:'3.3',type:'Fiction'},
						       {book_name: '《Penguin Pete》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/47/140.jpg')}}',bl:'3.5',type:'Fiction'},
						       {book_name: "《Ava's Poppy》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/47/139.jpg')}}',bl:'2.3',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 48,
						name: '[英】C.S.刘易斯（Clive Staples Lewis）（1898.11.29-1963.11.22）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/48.jpg') }}',
						desc: '爱尔兰裔英国知名作家及神学家，代表作《纳尼亚传奇》系列，和约翰·托尔金相交甚笃，20世纪30年代，他们相约各写一部奇幻史诗，《魔戒》和《纳尼亚传奇》相继诞生。他1898年出生在爱尔兰的有钱人家，从小就喜欢躲在小阁楼上耽读、幻想。9岁失去母亲的经历，直接影响了他笔下魔法世界的诞生。他26岁登上牛津大学教席，人称“最伟大的牛津人”，毕生研究文学、哲学、神学，尤其对中古及文艺复兴时期的英国文学造诣尤深，堪称为英国文学的巨擘，一直任教于牛津大学和剑桥大学这两所英国最著名的高等学府。J.K.罗琳被问到哈利·波特系列最终会是几本的时候，罗琳的回答是七本。因为她的母亲曾让她读过一个故事，那套书就是七本，书名叫做《纳尼亚传奇》。',
						books:[
						       {book_name: '《The Lion, the Witch and the Wardrobe》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/48/143.jpg')}}',bl:'4.9',type:'Fiction'},
						       {book_name: '《Perelandra  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/48/142.jpg')}}',bl:'7.3',type:'Fiction'},
						       {book_name: "《The Magician's Nephew 》",cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/48/144.jpg')}}',bl:'5.4',type:'Fiction'},
						],
						open: false
				  },
				  {
						no: 49,
						name: '[美]玛丽·波·奥斯本（Mary Pope Osborne）',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/49.jpg') }}',
						desc: '美国儿童文学作家，1949年她出生在美国的一个军人家庭，跟着身为军人的爸爸在不同地区生活，大学毕业后，游遍世界。这些丰富的游历，令玛丽拥有无限的想象力与联想力。玛丽迄今已写作20余年，作品上百本，获得过许多奖项，且担任过两届作家协会的主席。1992年，她创作了“神奇树屋”系列的《恐龙谷历险记》，在小读者中引起了热烈反响。最早是兰登书屋建议她写成一个系列的。为了准备素材，了解孩子们的口味和需求，她四处旅行，和老师们通信，在三四年的时间里跑了100所学校。作者把历史、文化、魔法、神话、地理等不同面向的知识，透过孩子的冒险，简单而有趣生动地介绍给孩子，吸引着孩子们阅读更多与social study（社会研究）和 history（历史）相关的书。“神奇树屋”系列自出版以来，颇受欢迎，至今她仍在进行“神奇树屋”故事的创作，这个长长的系列故事，经久不衰。',
						books:[
						       {book_name: '《Dinosaurs Before Dark》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/49/147.jpg')}}',bl:'2.6',type:'Fiction'},
						       {book_name: '《The Brave Little Seamstress》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/49/145.jpg')}}',bl:'4.0',type:'Fiction'},
						       {book_name: '《Dolphins and Sharks: A Fiction Companion to Dolphins at Daybreak》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/49/146.jpg')}}',bl:'5.1',type:'Nonfiction'},
						],
						open: false
				  },
				  {
						no: 50,
						name: '[英]J.K. 罗琳（J. K. Rowling））',
						avatar: '{{ url('home/pc/images/2017/FamousWriters/Headwriter/50.jpg') }}',
						desc: '英国女作家，是风靡全球的《哈利·波特》系列丛书的作者，该系列已在全球范围销售超过4.5亿册，发行至200多个国家和地区，被翻译成79种语言，并被华纳兄弟公司改编拍摄为8部热门电影。罗琳凭着哈利·波特的魔力荣登福布斯的10亿富翁排行榜。2016年8月，罗琳宣布将不再继续写哈利·波特的故事。罗琳还为成年读者创作了小说《The Casual Vacancy》（偶发空缺），并以罗伯特·加尔布雷思的笔名撰写了3部推理小说，塑造了私人侦探科莫兰·斯特莱克这一形象，该系列将被BBC改编成电视剧。近期罗琳还创作了第一部电影剧本《Fantastic Beasts & Where to Find Them》（神奇动物在哪里），该系列电影预计共有5部，每两年上映一部，是J.K罗琳和导演大卫·叶茨共同打造的新长篇魔幻巨作。',
						books:[
						       {book_name: '《Harry Potter and the Cursed Child  》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/50/149.jpg')}}',bl:'3.9',type:'Fiction'},
						       {book_name: '《Fantastic Beasts & Where to Find Them》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/50/148.jpg')}}',bl:'8.8',type:'Fiction'},
						       {book_name: '《The Casual Vacancy》',cover:'{{url('home/pc/images/2017/FamousWriters/writersworks/50/150.jpg')}}',bl:'7.2',type:'Fiction'},
						],
						open: false
				  }
			]
		},
		methods:{
			// 判断文本是否需要做展开操作
			checkOpenStatus: function(desc) {
				if (desc.length > this.descLimit) {
					return true;
				}else {
					return false;
				}
			},
			// 截取显示
			showSubDesc: function (desc) {
				if (this.checkOpenStatus(desc)) {
					return desc.substr(0,this.descLimit)+'...';
				} else {
					return desc;
				}
			},
			// 展开文本
			doOpen:function (d){
				d.open=true;
			},
			// 隐藏文本
			doHide:function (d){
				d.open=false;
			},
			goPage:function (page){
				this.currentpage= page;
			}
		}
    })
</script>

<!-- //扩展内容-->
@endsection
<!-- //继承整体布局 -->
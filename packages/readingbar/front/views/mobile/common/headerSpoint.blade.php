<header data-am-widget="header"  class="am-header am-header-local12 am-header-local1">
      <div class="am-g tjj-header">
      <div class="am-u-sm-2 ">
        <a href="javascript:history.back()" class="header-nav-fl2">
              <i class="am-icon-chevron-left "></i>
          </a>
      </div>
      <div class="am-u-sm-8 am-text-center">
        <a href="#title-link" class="header-nav-cent2">{{ $head_title }}</a>
      </div>
      <div class="am-u-sm-2">
           <i class="tjj-header-line tjj-header-menu"></i>
        <nav data-am-widget="menu" class="am-menu  am-menu-offcanvas1"   data-am-menu-offcanvas> 
          <a href="javascript: void(0)" class="am-menu-toggle">
               
          </a>
      
          <div class="am-offcanvas" >
            <div class="am-offcanvas-bar am-offcanvas-bar-flip color999999">
              <ul class="am-menu-nav-local am-avg-sm-1">
                 @if(auth('member')->guest())
                 	 <li class="">
	                    <a href="{{ url('login?intended='.request()->path()) }}" class="" >登录</a>
	                  </li>
	                  <li class="">
	                    <a href="{{url('/register')}}" class="" >注册</a>
	                  </li>
                 @else
	                  <li class="">
	                    <a href="{{url('/member/spoint/cart')}}" class="" >购物车</a>
	                  </li>
	                    <li class="">
	                    <a href="{{url('/member/spoint/collection')}}" class="" >我的收藏</a>
	                  </li>
	                    <li class="">
	                    <a href="{{url('/member/spoint/order/log')}}" class="" >我的订单</a>
	                  </li>
                 @endif
                 	  <li class="">
	                    <a href="javascript:void(0)"  data-am-modal="{target: '#howToGetPoint', closeViaDimmer: 0}">如何获取<img width="20px" src="{{ url('home/wap/images/sp/sp3_2.png') }}" alt="">？</a>
	                  </li>
              </ul>
              
            </div>
          </div>
        </nav>
      </div>
      
    </div>
    <!-- /扩展内容 -->
<div class="am-modal am-modal-no-btn" tabindex="-1" id="howToGetPoint">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">蕊丁币的获得方式： <a href="javascript: void(0)"
				class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<div class="" style="overflow-y: scroll; height: 60%">

				<div class="product-txt">
						<p>*会员每天登陆官网，就可获得10个蕊丁币。（和登录次数无关，对所有注册会员有效）</p>
						<p>*凡进入每月更新的小达人排行榜，都可以获得100个蕊丁币。</p>
						<p>*定制会员，每完成阅读计划中的任务目标，就可以获得100个蕊丁币。</p>
						<p>*所有蕊丁使者，成功推广一名注册会员，即可获得20蕊丁币。</p>
						<p>*购买蕊丁吧产品，即可获得相同数量的蕊丁币。</p>
						<p>*参与蕊丁吧“Reading Camp”，完成任务可获得奖励蕊丁币。</p>
						<p>*蕊丁吧年费会员，凡是获得过区、市、省、国家级的英语类奖项，可获得额外获得50，100，150，200蕊丁币的奖励。	</p>	

				</div>
				<div class="am-modal-footer am-text-center" style="display: block !important">
					 <a href="javascript:void(0)" data-am-modal-close style="background: #4bd2bf;color:white;padding:1rem 5rem">知道了</a>
				</div>

				<!--/modal-footer-->
			</div>
			<!--/-->
		</div>
	</div>
</div>
</header>
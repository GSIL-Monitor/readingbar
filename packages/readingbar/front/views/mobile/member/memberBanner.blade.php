<div class="container">
	@if(auth('member')->member->star_quiz>0)
		<a href="{{ config('readingbar.starTestWebSite') }}" target="_blank"><img src="{{url('home/wap/images/banner3.jpg')}}" class="am-img-responsive" alt=""/></a>
	@else
        <a href="{{url('member/freeStar')}}"><img src="{{url('home/wap/images/banner3.jpg')}}" class="am-img-responsive" alt=""/></a>
	@endif
</div>
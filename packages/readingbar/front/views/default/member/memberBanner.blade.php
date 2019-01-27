<div class="star-test-banner">
	@if(auth('member')->member->star_quiz>0)
		<a href="{{ config('readingbar.starTestWebSite') }}" target="_blank"><img src="{{url('home/pc/images/STAR-Test-banner_07.png')}}" alt=""></a>
	@else
        <a href="{{url('member/freeStar')}}"><img src="{{url('home/pc/images/STAR-Test-banner_07.png')}}" alt=""></a>
	@endif
</div>
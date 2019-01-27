
			
		<section>
		<link rel="stylesheet" type="text/css" href="{{url('home/wap/css/camp.css')}}">

			<img src="{{url('home/wap/images/camp/camp_01.jpg')}}" class="am-img-responsive" alt=""/>
			<figure data-am-widget="figure" class="am am-figure am-figure-default "   data-am-figure="{  pureview: 'true' }">
    			<img src="{{url('home/wap/images/camp/camp_02.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_03.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_04.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_05.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_06.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_07.jpg')}}" class="am-img-responsive" alt=""/>
			</figure>
			<!-- Styles -->
			
			<div class="camp_mp3">
				<img src="{{url('home/wap/images/camp/camp_09.jpg')}}" class="am-img-responsive" alt=""/>
				<button onclick="playPause()" class="camp_player">
					<img src="{{url('home/wap/images/camp/mp3play.png')}}"  alt=""/>
				</button>
				<audio id="audio1">
				    <source src="{{url('home/wap/images/camp/camp.mp3')}}" type="audio/mp4" />
				    <source src="example.ogg" type="audio/ogg" />
				</audio>
				
			</div>
			<!--/camp_mp3-->
			<script type="text/javascript">
				var myAudio = document.getElementById('audio1');
				    function playPause(){
				        if(myAudio.paused){
				            myAudio.play();
				        }else{
				            myAudio.pause();
				        }
				    }

			</script>
			<figure data-am-widget="figure" class="am am-figure am-figure-default "   data-am-figure="{  pureview: 'true' }">
    			<img src="{{url('home/wap/images/camp/camp_11.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_12.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_13.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_14.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_15.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_16.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_17.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_18.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_19.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_20.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_21.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_22.jpg')}}" class="am-img-responsive" alt=""/>
    			<img src="{{url('home/wap/images/camp/camp_23.jpg')}}" class="am-img-responsive" alt=""/>
    		</figure>
    		<div class="camp_11-txt">
    			<h4>本期 READING CAMP 仅限 8 名小学员</h4>
				<h4>	
				现已报名 
				<b v-if="8-getLastQuantity(11)<=3">3 </b>
				<b v-else>[[ 8-getLastQuantity(11) ]] </b>
				位</h4>
				<h4>	赶紧去抢位吧</h4>
    		</div>
			@if(auth('member')->isLoged())
		   		<button  type="button" class="am-btn camp_link"  v-on:click="skipProtocol(11)">GO</button>
			@else
				<button  type="button" class="am-btn camp_link"  v-on:click="alertLogin()">GO</button>
			@endif

		</section>
     	
		

<!-- /整体布局 -->
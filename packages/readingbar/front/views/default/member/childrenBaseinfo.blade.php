<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')

<div class="container">
	<div class="row padt9">
	  	<div class="col-md-2 home-column-fl" >@include('front::default.member.memberMenu')</div>
	    <!--/ home-column-fl end-->
	    <div class="col-md-10 home-column-fr100">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="#">{{$head_title}}</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content">
				<div class="child-01">
					<div class="col-md-2 margintop30">
					   <div class="user-tx">
	        				<img src="{{ $student['avatar']?url($student['avatar']):url('files/avatar/avatar_default_sex'.$student['sex'].'.jpg') }}">
	                    	<em class="user-tx-hover"></em>
	                    </div>
                   </div>
                   <!--/col-md-2-->
                   <div class="col-md-10 child-information margintop70">
                       <div id="child-info3">
	                       	<p style="height: 22px;display:block;"></p>
							<p>生日：{{$student['dob']}}</p>
                       </div>
                        <em>
                        	<h4>{{$student['nick_name']}}</h4>
                   		</em>
                   		<p>性别：{{$student['sex']?'男':'女'}}</p>
                   	    <p>地址:{{$student['province']}}{{$student['city']}}{{$student['area']}}{{$student['address']}}</p>
                   	   <a href="{{url('member/children/edit/'.$student['id'])}}" class="button-01" style="margin-top: 22px;">修改</a>

                   </div>
                   <!--/child-information-->
				</div>
				
			</div>
			<!--/content-->

		</div>
		<!--/ content end-->	
	</div>
	<!--/ row end-->
</div>
</div>
<script>
    $(function(){
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            // 获取已激活的标签页的名称
            var activeTab = $(e.target).text();
            // 获取前一个激活的标签页的名称
            var previousTab = $(e.relatedTarget).text();
            $(".active-tab span").html(activeTab);
            $(".previous-tab span").html(previousTab);
        });
    });
</script>
@endsection


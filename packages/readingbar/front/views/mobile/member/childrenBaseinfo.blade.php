<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<!-- 扩展内容-->
<section>
	<div class="pab0_0 am-container" id="childForm">
		<div class="user-heard-modify2 pab15">
    		<div class="user-heard-photo">
    		    <img src="{{ $student['avatar']?url($student['avatar']):url('files/avatar/avatar_default_sex'.$student['sex'].'.jpg') }}" class="am-img-thumbnail am-circle marg0_auto">
            </div>
    	</div>
    	<!--/user-heard-photo-->
    	<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">姓名：</div>
			<div class="am-u-sm-9 fl">{{$student['name']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">昵称：</div>
			<div class="am-u-sm-9 fl">{{$student['nick_name']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">性别：</div>
			<div class="am-u-sm-9 fl">{{$student['sex']?'男':'女'}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">生日：</div>
			<div class="am-u-sm-9 fl">{{$student['dob']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">年龄：</div>
			<div class="am-u-sm-9 fl">{{$student['age']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20 ">
			<div class="am-u-sm-3 fl">年级：</div>
			<div class="am-u-sm-9 fl">{{$student['grade']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">学校：</div>
			<div class="am-u-sm-9 fl">{{$student['school_name']}}</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g pab20_20">
			<div class="am-u-sm-3 fl">阅读偏好：</div>
			<div class="am-u-sm-9 fl">
			     @foreach($student['favorite'] as $f)
					{{$f}};
				@endforeach
			</div>
		</div>
		<!--/am-g-->
		<div class="add-childer-box3 am-g ">
			<div class="am-u-sm-3 fl">地址：</div>
			<div class="am-u-sm-9 fl">{{$student['province']}}{{$student['city']}}{{$student['area']}}{{$student['address']}}</div>
		</div>
		<!--/am-g-->
		
		
    </div>
	<!--/am-container-->
</section>
@endsection
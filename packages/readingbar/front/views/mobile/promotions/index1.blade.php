<!-- 继承整体布局 -->
@extends('front::mobile.common.main2l')

@section('content')
<script type="text/javascript" src="{{url('home/pc/images/promotion/echarts.min.js')}}"></script>
<script type="text/javascript" src="{{url('home/pc/images/promotion/westeros.js')}}"></script>
<section>
    <div class="container pab15_15 margintop15">
		<span class="promotion-link fl">推广链接：</span>
		<div class="am-input-group promotion-copy">
	      <input type="text" class="am-form-field">
	      <span class="am-input-group-btn">
	        <button class="am-btn am-btn-default" type="button">复制</button>
	      </span>
	    </div>
		<!--<img src="{{url('home/pc/images/promotion/promotion_03.jpg')}}" class="QRcode fl">-->
	</div>
	<!--/container-->
	<div class="container pab15_15 margintop15">
    	<span class="promotion-link fl">推广链接：</span>
		<div class="am-btn-group doc-js-btn-1 promotion-data" data-am-button>
			  <label class="am-btn am-btn-primary mgflfr8">
			    <input type="radio" name="data" value="今天" id="option1"> 今天
			  </label>
			  <label class="am-btn am-btn-primary mgflfr8">
			    <input type="radio" name="data" value="昨天" id="option2"> 昨天
			  </label>
			  <label class="am-btn am-btn-primary mgflfr8">
			    <input type="radio" name="data" value="7天" id="option3"> 7天
			  </label>
			  <label class="am-btn am-btn-primary">
			    <input type="radio" name="data" value="30天" id="option3"> 30天
			  </label>
		</div>
		<script>
			  // 获取选中的值
			  $(function() {
			    var $radios = $('[name="options"]');
			    $radios.on('change',function() {
			      console.log('单选框当前选中的是：', $radios.filter(':checked').val());
			    });
			  });
			</script>
	</div>
	<!--/container-->
	<div class="am-g pab15_15 margintop15" >
	  <div class="am-u-sm-6" style="padding-left: 0;"><input id="dob" v-model="student.dob" readonly type="text" name="dob" class="addchilder-box-input" /></div>
	  <div class="am-u-sm-6" style="padding-right: 0;"><input id="dob" v-model="student.dob" readonly type="text" name="dob" class="addchilder-box-input" /></div>
	</div>
	<!--/am-g-->
	<div class="am-g pab15_15 margintop15" >
		<div class="am-u-sm-6 promotion-members">
			<h4>217</h4>
			<b>会员数量</b>
		</div>
		<div class="am-u-sm-6 promotion-amount">
			<h4>462</h4>
			<b>支付金额</b>
		</div>  
	</div>
	<!--/am-g-->
	<div class="am-g promotion pab15_0">
	    <div class="am-u-sm-12 promotion-tj01">
            <div id="promotion-cont" style="height: 100%"></div>
            <div id="pro-childer-info">
				<span><em class="pro-ys-01"></em><b>总人数：12132</b></span>
				<span><em class="pro-ys-02"></em><b>已添加孩子：1548</b></span>
				<span><em class="pro-ys-03"></em><b>未添加孩子：1000</b></span>
			</div>
		</div>
	    <div class="am-u-sm-12 promotion-tj01">
		  	<div id="promotion-cont02" style="height: 100%"></div>
			<div id="pro-pay-info">
				<span><em class="pro-ys-01"></em><b>总订单：12132</b></span>
				<span><em class="pro-ys-02"></em><b>已支付订单：1548</b></span>
				<span><em class="pro-ys-03"></em><b>未支付订单：1000</b></span>
			</div>
	    </div>
	</div>
	<!--/-->
	<div class="am-g pab15_15" style="font-size: 1.6rem;line-height: 40px;">信息列表</div>
	  <div data-am-widget="list_news" class="am-list-news am-list-news-default" >
		<div class="am-g pab15 infor-list bgf4f4f4">
			<p>序号  :<span>lkmscssdvsdvsd</span></p>         
			<p>推广人 :<span>lkmscssdvsdvsd</span></p>          
			<p>注册日期 :<span>lkmscssdvsdvsd</span></p>          
			<p>会员昵 :<span>lkmscssdvsdvsd</span></p>            
			<p>手机 :<span>lkmscssdvsdvsd</span></p>            
			<p>邮箱 :<span>lkmscssdvsdvsd</span></p>          
			<p>孩子姓名 :<span>lkmscssdvsdvsd</span></p>          
			<p>套餐名称 :<span>lkmscssdvsdvsd</span></p>       
			<p>区域:<span>lkmscssdvsdvsd</span></p>
		</div>
		<div class="am-g pab15 infor-list">
				<p>序号  :<span>lkmscssdvsdvsd</span></p>         
				<p>推广人 :<span>lkmscssdvsdvsd</span></p>          
				<p>注册日期 :<span>lkmscssdvsdvsd</span></p>          
				<p>会员昵 :<span>lkmscssdvsdvsd</span></p>            
				<p>手机 :<span>lkmscssdvsdvsd</span></p>            
				<p>邮箱 :<span>lkmscssdvsdvsd</span></p>          
				<p>孩子姓名 :<span>lkmscssdvsdvsd</span></p>          
				<p>套餐名称 :<span>lkmscssdvsdvsd</span></p>       
				<p>区域:<span>lkmscssdvsdvsd</span></p>
		</div>
		<!--/page-->
		<div class="am-list-news-ft am-btn-default">
            <a class="am-list-news-more am-btn color999999" href="###">查看更多 &raquo;</a>
        </div>		
	</div>

</section>
<script type="text/javascript">
var dom = document.getElementById("promotion-cont");
var myChart = echarts.init(dom, 'westeros');
var app = {};
option = null;
option = {
    title : {
       
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
         /*orient: 'vertical',
        left: 'left',
        data: ['未添加孩子','已加孩子']*/
    },
    series : [
           {
            
            type: 'pie',
            radius : '65%',
            center: ['47%', '45%'],
            label: {
                        normal: {
                            show: false
                        },
                        emphasis: {
                            show: true
                        }
                    },
            data:[
                
                {value:1000, name:'已加孩子'},
                {value:1548, name:'未添加孩子'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 2,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}

</script>
<script type="text/javascript">
var dom = document.getElementById("promotion-cont02");
var myChart = echarts.init(dom, 'westeros');
var app = {};
option = null;
option = {
    title : {
       
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        /*orient: 'vertical',
        left: 'left',
        data: ['未支付订单','已支付订单']*/
    },
    series : [
        {
            
            type: 'pie',
            radius : '65%',
            center: ['47%', '45%'],
            label: {
                        normal: {
                            show: false
                        },
                        emphasis: {
                            show: true
                        }
                    },
            data:[
                
                {value:1000, name:'已支付订单'},
                {value:1548, name:'未支付订单'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 2,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
};
;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}

</script>

<script src="{{url('home/pc/js/distpicker.data.js')}}"></script>
<script src="{{url('home/pc/js/distpicker.js')}}"></script>
<script type="text/javascript">
		$('#dob').datepicker({
	        startView: 1,
	        todayBtn: "linked",
	        keyboardNavigation: false,
	        forceParse: false,
	        autoclose: true,
	        language:"cn",
	        format: "yyyy-mm-dd"
	    });
	</script>
@endsection
<!-- //继承整体布局 -->

@extends('superadmin/backend::layouts.backend')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'List' }}</h2>
                    <ol class="breadcrumb">
                    	@foreach($breadcrumbs as $b)
                        <li>
                        	@if($b['active'])
                            	<strong class="active">{{ trans($b['name']) }}</strong>
                        	@else
                        		<a href="{{$b['url']!=''?url($b['url']):'javascript:void(0);'}}">{{ trans($b['name']) }}</a>
                        	@endif
                        </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<div class="wrapper wrapper-content animated fadeInRight" id="discountChart">
	<div class="row">
		<div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">优惠券饼图</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">优惠券折线图</i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                   @include('back::discount.pc')
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                   @include('back::discount.lc')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
     </div>
</div>

<link href="{{ asset('assets/css/plugins/c3/c3.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/js/plugins/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/c3/c3.min.js') }}"></script>
<script>
var chart=c3.generate({
    bindto: '#lc',
    data: {
        x:'x',
        columns:[]
	},
	axis: {
        x: {
            type: 'category' // this needed to load string x value
        }
    },
    type: 'bar'
});
var pie=c3.generate({
    bindto: '#pc',
    data:{
        columns: [],
        colors:{
        	'优惠券总数': '#8dd16e',
        	'未消费的优惠券': '#61d9c8',
        	'已消费的优惠券': '#aef8ed'
        },
        hide: ['优惠券总数'],
        type : 'pie'
    },
    pie: {
        label: {
            format: function (value, ratio, id) {
                return value;
            }
        }
    }
});
var _discountChart=new Vue({
	el:"#discountChart",
	data:{
		members:null,
		lc:{
			type:'day',
			fromDate:'2016-12-01',
			toDate:'2017-01-01',
		},
		pc:null,
		search:{
			page:1,
			limit:5
		},
		alert:null
	},
	created:function(){
		var _this=this;
		_this.doGetPc();
		_this.doGetLc();
		$('.input-daterange').datepicker({
			format:"yyyy-mm-dd",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
		});
	},
	methods:{
		//获取优惠券饼图信息
		doGetPc:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/discount/pc') }}",
				dataType:"json",
				data:_this.lc,
				success:function(json){
					pie.load(json);
				},error:function(){
				}
			});
		},
		//获取优惠券折线图信息
		doGetLc:function(){
			var _this=this;
			if(_this.lc.ajaxStatus){
				return;
			}else{
				_this.lc.ajaxStatus=true;
			}
			_this.lc.fromDate=$('#lc-daterange input[name=fromDate]').val();
			_this.lc.toDate=$('#lc-daterange input[name=toDate]').val();
			$.ajax({
				url:"{{ url('admin/api/discount/lc') }}",
				dataType:"json",
				data:_this.lc,
				success:function(json){
					chart.load(json);
					_this.lc.ajaxStatus=false;
				},error:function(){
					_this.lc.ajaxStatus=false;
				}
			});
		},
		//设置图表类型
		setlcType:function(t){
			this.lc.type=t;
		},
		//提示信息
		doAlert:function(type,msg){
			switch(type){
				case 'success':
					this.alert={
							msg:msg,
							classes:'alert alert-success'
						}
					break;
				case 'error':
					this.alert={
						msg:msg,
						classes:'alert alert-danger'
					}
	 				break;
			}
		},
		doChangePage:function(page){
			this.search.page=page;
		},
		doSearch:function(){
			this.search.page=1;
			this.doGetMembers();
		}
	}
	
});
</script>
@endsection



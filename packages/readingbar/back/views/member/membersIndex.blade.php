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
<div class="wrapper wrapper-content animated fadeInRight" id="membersList">
	<div :class="alert.classes" role="alert" v-if="alert">
	  <button type="button" class="close" v-on:click="alert=null" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>[[ alert.msg ]]</strong>
	</div>
	<div class="row">
	<div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">会员列表</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">会员信息折线图</i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                   @include('back::member.lm')
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    @include('back::member.lcom')
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
    bindto: '#lcorm',
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
var _membersList=new Vue({
	el:"#membersList",
	data:{
		members:null,
		areas:{!! $areas !!},
		lcom:{
			type:'day',
			fromDate:'2016-12-01',
			toDate:'2017-01-01',
		},
		search:{
			page:1,
			limit:5
		},
		alert:null
	},
	created:function(){
		var _this=this;
		_this.doGetMembers();
		_this.doGetLcorm();
		$('#lcom').datepicker({
			format:"yyyy-mm-dd",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
		});
		$('#members').datepicker({
			format:"yyyy-mm-dd",
		    keyboardNavigation: false,
		    forceParse: false,
		    autoclose: true
		}).on('changeDate', function(ev){
			_this.doSearch();
		});
	},
	methods:{
		//获取会员数据
		doGetMembers:function(){
			var _this=this;
			$.ajax({
				url:"{{ url('admin/api/members/getMembers') }}",
				dataType:"json",
				data:_this.search,
				success:function(json){
					_this.members=json;
				},error:function(){
				}
			});
		},
		//获取注册图表信息
		doGetLcorm:function(){
			var _this=this;
			if(_this.lcom.ajaxStatus){
				return;
			}else{
				_this.lcom.ajaxStatus=true;
			}
			_this.lcom.fromDate=$('#lcom input[name=fromDate]').val();
			_this.lcom.toDate=$('#lcom input[name=toDate]').val();
			$.ajax({
				url:"{{ url('admin/api/members/lcom') }}",
				dataType:"json",
				data:_this.lcom,
				success:function(json){
					chart.load(json);
					_this.lcom.ajaxStatus=false;
				},error:function(){
					_this.lcom.ajaxStatus=false;
				}
			});
		},
		//设置图表类型
		setLcomType:function(t){
			this.lcom.type=t;
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
			this.doGetMembers();
		},
		doSearch:function(){
			this.search.fromDate=$('#members input[name=fromDate]').val();
			this.search.toDate=$('#members input[name=toDate]').val();
			this.search.page=1;
			this.doGetMembers();
		}
	}
	
});
</script>
@endsection



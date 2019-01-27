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
<div class="wrapper wrapper-content animated fadeInRight" id="editFrom">
	
	<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>公告表单</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="post" class="form-horizontal" action='{{ $action }}'>
                            {!! csrf_field() !!}
                            	<input type="hidden" class="form-control" value="{{ $obj->id or '' }}" name='id'>
                            	@if($errors->has('id'))
	                                  <label class="error">{{ $errors->first('id') }}</label>
	                            @endif
                                <div class="form-group"><label class="col-sm-2 control-label">名称</label>
                                    <div class="col-sm-10">
                                    	<input type="text" class="form-control" value="{{ $obj->name or '' }}" name='name'>
                                    	@if($errors->has('name'))
	                                    	<label class="error">{{ $errors->first('name') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">价格</label>
                                    <div class="col-sm-10">
                                    	<input type="text" class="form-control" value="{{ $obj->price or '' }}" name='price'>
                                    	@if($errors->has('price'))
	                                    	<label class="error">{{ $errors->first('price') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">有效天数</label>
                                    <div class="col-sm-10">
                                    	<input  type="text" class="form-control" value="{{ $obj->days or '' }}" name='days'>
                                    	@if($errors->has('days'))
	                                    	<label class="error">{{ $errors->first('days') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">备注</label>
                                    <div class="col-sm-10">
                                    	<input  type="text" class="form-control" value="{{ $obj->memo or '' }}" name='memo'>
                                    	@if($errors->has('memo'))
	                                    	<label class="error">{{ $errors->first('memo') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">优惠券关联可使用的产品</label>
                                    <div class="col-sm-10">
	                                     @foreach($products as $p)
		                                    <div  class="col-md-4">
		                                    	<label>
			                                    	@if(isset($obj) && in_array($p->id,$obj->products))
			                                    		<input checked value="{{ $p->id }}" type="checkbox" name='products[]'>
			                                    	@else
			                                    		<input  value="{{ $p->id }}" type="checkbox" name='products[]'>
			                                    	@endif
			                                    	{{ $p->product_name }}
		                                    	</label>
		                                    </div>
		                                @endforeach
	                                    <br style="clear:both">	
	                                    @if($errors->has('products'))
	                                    	<label class="error">{{ $errors->first('products') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">优惠券获取规则</label>
                                    <div class="col-sm-10">
	                                  <select class='form-control' name='get_rule'>
		                                    				<option value=''>请选择该优惠券获取规则</option>
		                                    				@foreach($get_rules as $k=>$v)
		                                    					@if(isset($obj) && isset($obj->get_rule) && $obj->get_rule==$k)
		                                    					<option value='{{ $k }}' selected>{{ $v }}</option>
		                                    					@else
		                                    					<option value='{{ $k }}'>{{ $v }}</option>
		                                    					@endif
		                                    				@endforeach
		                               </select>
	                                    <br style="clear:both">	
	                                    @if($errors->has('get_rule'))
	                                    	<label class="error">{{ $errors->first('get_rule') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">获取规则关联的推广员</label>
                                    <div class="col-sm-10">
		                                @foreach($get_rule_promotions_types as $k=>$v)
		                                    <div  class="col-md-4">
		                                    	<label>
			                                    	@if(isset($obj) && in_array($v->id,$obj->get_rule_promotions_types))
			                                    		<input checked value="{{ $v ->id }}" type="checkbox" name='get_rule_promotions_types[]'>
			                                    	@else
			                                    		<input  value="{{ $v ->id }}" type="checkbox" name='get_rule_promotions_types[]'>
			                                    	@endif
			                                    	{{ $v->name }}
		                                    	</label>
		                                    </div>
		                                @endforeach
	                                    <br style="clear:both">	
	                                    @if($errors->has('get_rule_promotions'))
	                                    	<label class="error">{{ $errors->first('get_rule_promotions') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">获取规则关联的产品</label>
                                    <div class="col-sm-10">
		                                    @foreach($get_rule_products as $k=>$v)
		                                    <div  class="col-md-4">
		                                    	<label>
			                                    	@if(isset($obj) && in_array($v->id,$obj->get_rule_products))
			                                    		<input checked value="{{ $v ->id }}" type="checkbox" name='get_rule_products[]'>
			                                    	@else
			                                    		<input  value="{{ $v ->id }}" type="checkbox" name='get_rule_products[]'>
			                                    	@endif
			                                    	{{ $v->name }}
		                                    	</label>
		                                    </div>
		                                @endforeach
	                                    <br style="clear:both">	
	                                    @if($errors->has('get_rule_products'))
	                                    	<label class="error">{{ $errors->first('get_rule_products') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">获取限制</label>
                                    <div class="col-sm-10">
		                                 <select class='form-control' name='get_limit'>
	                                  					<option value=''>请选获取限制</option>
		                                    				@foreach($get_limits as $k=>$v)
		                                    					@if(isset($obj) && $obj->get_limit==$k)
		                                    					<option value='{{ $k }}' selected>{{ $v }}</option>
		                                    					@else
		                                    					<option value='{{ $k }}'>{{ $v }}</option>
		                                    					@endif
		                                    				@endforeach
		                               	</select>
	                                    <br style="clear:both">	
	                                    @if($errors->has('get_limit'))
	                                    	<label class="error">{{ $errors->first('get_limit') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">优惠券转赠规则</label>
                                    <div class="col-sm-10">
	                                  <select class='form-control' name='donation'>
	                                  					<option value=''>请选择转赠规则</option>
		                                    				@foreach($donations as $k=>$v)
		                                    					@if(isset($obj) && $obj->donation==$k)
		                                    					<option value='{{ $k }}' selected>{{ $v }}</option>
		                                    					@else
		                                    					<option value='{{ $k }}'>{{ $v }}</option>
		                                    					@endif
		                                    				@endforeach
		                               </select>
		                               <br style="clear:both">	
	                                    @if($errors->has('donation'))
	                                    	<label class="error">{{ $errors->first('donation') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">状态</label>
                                    <div class="col-sm-10">
	                                  <select class='form-control' name='status'>
		                                    				<option value=''>请选择状态</option>
		                                    				@foreach($status as $k=>$v)
		                                    					@if(isset($obj) && isset($obj->status) && $obj->status==$k)
		                                    					<option value='{{ $k }}' selected>{{ $v }}</option>
		                                    					@else
		                                    					<option value='{{ $k }}'>{{ $v }}</option>
		                                    					@endif
		                                    				@endforeach
		                               </select>
	                                    <br style="clear:both">	
	                                    @if($errors->has('status'))
	                                    	<label class="error">{{ $errors->first('status') }}</label>
	                                    @endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" href="javascript:history.back()">取消</a>
                                        <button class="btn btn-primary">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       
</div>
<script>
//日期控件
$('.datepicker-date').datepicker({format: 'yyyy-mm-dd'});
</script>
@endsection



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
<div class="wrapper wrapper-content animated fadeInRight">
 <div class="ibox-content">
    <div class="row">
         <div class="col-xs-3">{{ trans('survey.column_question') }}</div>
         <div class="col-xs-9">{{ trans('survey.column_answer') }}</div>
    </div>
    @foreach($result as $s)
	<div class="row">
         <div class="col-xs-3">
         	{{$s['question']}}
         	@if($s['answer_type']==1)
         		({{trans('survey.answer_type_1')}})
         	@elseif($s['answer_type']==2)
         		({{trans('survey.answer_type_2')}})
         	@elseif($s['answer_type']==3)
         		({{trans('survey.answer_type_3')}})
         	@endif
         </div>
         <div class="col-xs-9">
         	@if($s['answer_type']==1)
         		@for($i=1;$i<=10;$i++)
         			@if($s['answer'.$i]!='')
         				{{$s['answer'.$i]}}
         			@endif
         		@endfor
         	@elseif($s['answer_type']==2)
         		@for($i=1;$i<=10;$i++)
         			@if($s['answer'.$i]!='')
         				{!! str_replace('[input]','<font style="border-bottom:1px solid black">  '.$s['answer'.$i].'  </font>',$s['option'.$i]) !!}
						<br>
         			@endif
         		@endfor
         	@elseif($s['answer_type']==3)
         		{{ $s['answer1'] }}
         	@endif
         </div>
    </div>
    @endforeach
 </div>
</div>
@endsection



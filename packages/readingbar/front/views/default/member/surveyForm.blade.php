<!-- 继承整体布局 -->
@extends('front::default.common.main')

@section('content')
<!-- 包含会员菜单
基础信息
完善信息
修改密码
设置邮箱
设置手机
设置安全问答
孩子信息
 -->
	
<!-- 包含会员菜单 -->
<!-- 扩展内容-->


<div class="container">
	<div class="row padt9">
	  <div class="col-md-2 home-column-fl">
	  	@include('front::default.member.memberMenu')
	  </div>
	  <!--/ home-column-fl end-->
	  <div class="col-md-10 home-column-fr100">
	        <ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="javascript:volid(0);">孩子基础问卷调查</a></li>
			</ul>
			<div style="clear:both"></div>
			<div class="content">
				<form id="surveyForm" class="mgl-40 mgb-20" action="" method="post">
					@foreach($questions as $k=>$q)
					<div v-if="cq=={{$q['id']}}">
						<div class="home-questionnaire-titile">
							<i>{{$k+1}}</i>
							<span>
							{{ trans('survey.answer_type_'.$q['answer_type'])}}
							</span>
						</div>
						<div class="home-questionnaire">
							@if($q['answer_type']==1)
								
								<h5 class="questionnair-heard">问题:{{$q['question']}} </h5>
								@for($i=1;$i<=10;$i++)
									@if($q['option'.$i]!=null)
										<div class="q-choice-piccheck">
								            <div class="q_choice_in"> 
									            <input type="radio" class="survey{{$q['id']}}" name="answer_{{$q['id']}}" v-model="answer.answer_to_{{$q['id']}}"  value="{{$i}}">
									            <label class="">{{$q['option'.$i]}}</label>
								            </div>
								        </div> 
							        @endif
								@endfor
							@elseif($q['answer_type']==2)
								<h5 class="questionnair-heard">问题:{{$q['question']}} </h5>
								@for($i=1;$i<=10;$i++)
									@if($q['option'.$i]!=null)
										@if(strpos($q['option'.$i],"[input]"))
											<div class="q-choice-piccheck">
								            <div class="q_choice_in"> 
									            <input class="survey{{$q['id']}}" type="checkbox" name="answer_{{$q['id']}}[]" v-model="answer.answer_to_{{$q['id']}}"  value="{{$i}}">
									            <label class="">
									             
									            {!! str_replace("[input]","<input type=\"text\" v-model=\"answer.answer_to_".$q['id']."_text[".$i."]\">",$q['option'.$i]) !!}
									            </label>
								            </div>
								        </div> 
										@else
										<div class="q-choice-piccheck">
								            <div class="q_choice_in"> 
									            <input class="survey{{$q['id']}}" type="checkbox" name="answer_{{$q['id']}}[]" v-model="answer.answer_to_{{$q['id']}}"  value="{{$i}}">
									            <label class="">{{$q['option'.$i]}}</label>
								            </div>
								        </div> 
								        @endif
							        @endif
								@endfor
							@elseif($q['answer_type']==3)
								 <h5 class="questionnair-heard">问题:{{$q['question']}} </h5>
								 <div class="q-choice-piccheck">
								     <input class="survey{{$q['id']}}" class="col-md-12" name="answer['answer_to_{{$q['id']}}']"></input>
								 </div> 
							@endif
						</div>
					</div>
					@endforeach
					<a v-on:click="nextQuestion()" v-if="!submitButton" class="home-questionnaire-referre">下一题</a>	
					<a v-on:click="doSubmit()" v-if="submitButton" class="home-questionnaire-referre">提交问卷</a>	
				</form>
			</div>
		</div>
		<!--/col-md-3-->	
	</div>
	<!--/row end-->
</div>
<script type="text/javascript">
var answer=null;

new Vue({
	el:"#surveyForm",
	data:{
		cq:1,
		questions:{!! json_encode($questions) !!},
		submitButton:false,
		answer:{
			@foreach($questions as $q)
				@if($q['answer_type']==2)
					answer_to_{{$q['id']}}:[],
				@else
					answer_to_{{$q['id']}}:null,
				@endif
			@endforeach
			},
	},
	methods:{
		nextQuestion:function(){
			console.log(this.answer);
			q=this.questions[this.cq-1];
			if(this.checkInput()){
				if(q.NextID){
					this.cq=q.NextID;
				}else{
					if(q['answer_type']==3){
						var v=$(".survey"+q.id).val();
					}else{
						var v=$(".survey"+q.id+":checked").val();
					}
					if(v==1){
						this.cq=q.YesNextID;
					}else{
						this.cq=q.NoNextID;
					}
				}
			}else{
				alert('该题为必填项！');
			}
			if(this.cq==18){
				this.submitButton=true;
			}
		},
		checkInput:function(){
			q=this.questions[this.cq-1];
			if(q['answer_type']==3){
				var v=$(".survey"+q.id).val();
			}else{
				var v=$(".survey"+q.id+":checked").val();
			}
			if(v || q['required']!=1){
				return true;
			}else{
				return false;
			}
		},
		doSubmit:function(){
			if(this.checkInput()){
				$.ajax({
					url:"{{url('api/member/children/survey/submitSurvey')}}",
					type:"POST",
					data:{student_id:{{ $student_id}},answer:this.answer},
					dataType:"json",
					success:function(json){
						if(json.status){
							alert(json.success);
							window.opener.childrenList.getChildren();
							window.close();
						}else{
							alert(json.error);	
						}
					}
				});
			}else{
				alert('该题为必填项！');
			}
		}
	}
});

</script>
<!-- /扩展内容 -->
@endsection
<!-- //继承整体布局 -->

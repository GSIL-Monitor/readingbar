@extends('Readingbar/common/frontend::backend')
@section('content')
<div id="studentForm" style="display:none ">
	<form action="[[action]]">
		{!! csrf_field() !!}
	    {{ method_field('POST') }}
	     <input type="text" name="id" autocomplete="off" value="[[student.id]]"><br>
		姓名：<input type="text" autocomplete="off" name="name" value="[[student.name]]"><br>
		昵称：<input type="text" autocomplete="off" name="nick_name" value="[[student.nick_name]]"><br>
		头像：<input type="text" autocomplete="off" name="avatar" value="[[student.avatar]]"><br>
		生日：<input type="text" autocomplete="off" name="dob" value="[[student.dob]]"><br>
		性别：
		<select name="sex">
			<option value='1'>男</option>
			<option value='2'>女</option>
		</select>
		<br>
		<a v-on:click="submit">提交</a>
	</form>
</div>
<div id="list">
	<a v-on:click="create">新增</a>
	<ul >
		<li v-for="s in students">
			<div>id:[[s.id]]</div>
			<div>avatar:[[s.avatar]]</div>
			<div>student:[[s.nick_name]]</div>
			<div>
				<a v-on:click="edit(s.id)">编辑</a>
				<a v-on:click="destroy(s.id)">删除</a>
				<a v-on:click="startSurvey(s)">start测评</a>
			</div>
		</li>
	</ul>
</div>
<script type="text/javascript">
var student_form=new Vue({
	el:"#studentForm",
	data:{
		action:'',
		student:{}
	},
	methods:{
		submit:function(){
			_self=this;
			 $.ajax({
      			url:$("#studentForm form").attr('action'),
      			data:$("#studentForm form").serialize(),
      			type:'POST',
      			dataType:'json',
      			success:function(json){
      				_self.clearErrors();
      				if(json.errors){
          				for(i in json.errors){
							$("input[name="+i+"]").after("<font class='error'>"+json.errors[i]+"</font>");
                  		}
          			}
          			if(json.success){
          				_self.hide();
          				students.showData();
              			alert(json.success);
              		}
      			}
		     });
		},
        clearForm:function(){
            inputName=['id','name','nick_name','dob','avatar'];
            for(i in inputName){
				$("#studentForm input[name="+inputName[i]+"]").val('');
    		}
        },
        fillForm:function(data){
        	for(i in data){
				$("#studentForm input[name="+i+"]").val(data[i]);
    		}
        },
        clearErrors:function(){
			$(".error").remove();
        },
        show:function(){
        	$("#studentForm").show();
        },
        hide:function(){
        	$("#studentForm").hide();
        }
	}
});
var students=new Vue({
	  el: '#list',
	  data: {
		 students:[],
	  },
	  methods: {
		  showData: function () {
              var url = "{{url('member/student/ajax/students')}}";
              $.ajax({
      			url:url,
      			data:{},
      			dataType:'json',
      			success:function(json){
      				students.students=json.data;
      			}
	      	  });
          },
          edit:function(id){
        	  var url = "{{url('member/student/ajax')}}/"+id;
        	  $.ajax({
        			url:url,
        			data:{},
        			dataType:'json',
        			success:function(json){
        				student_form.clearForm();
        				student_form.action="{{url('member/student/ajax/edit')}}";
        				student_form.fillForm(json.data);
        				student_form.show();
        			}
  	      	  });
          },
          create:function(){
        	  student_form.clearForm();
        	  student_form.action="{{url('member/student/ajax/create')}}";
			  student_form.student=[];
			  student_form.show();
          },
          destroy:function(id){
        	  if(!confirm("确定删除吗?")){
            	  return;
              }
        	  var url = "{{url('member/student/ajax/destroy')}}";
        	  $.ajax({
        			url:url,
        			data:{id:id},
        			dataType:'json',
        			success:function(json){
        				if(json.error){
              				alert(json.error);
              			}
              			if(json.success){
              				students.showData();
                  			alert(json.success);
                  		}
        			}
  	      	  });
          },
          startSurvey:function(student){
              if(student.survey_status!=1){
            	  window.location.href="{{url('member/student')}}/"+student.id+"/survey";
              }else{
				  alert("这个学生已经做过基础调查了");
              }
				
          }
      }
});
students.showData();
</script>
<input type="file" name="test" class="jcrop"/>

　　<div id="prvid">预览容器</div>  
<link href="{{asset('assets/css/plugins/jcrop/jquery.Jcrop.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{asset('assets/js/plugins/jcrop/jquery.Jcrop.min.js')}}"></script>
<script type="text/javascript">
  jQuery(function($){
	  $('#target').Jcrop({
	      aspectRatio: 100 / 100
	  });
  });
  $(".jcrop").change(function(){
	    file=this;
	    prvid='prvid';
		var tip = "Expect jpg or png or gif!"; // 设定提示信息
		  var filters = {
			  "jpeg" : "/9j/4",
			  "gif" : "R0lGOD",
			  "png" : "iVBORw"
		  }
		  var prvbox = document.getElementById(prvid);
		  prvbox.innerHTML = "";
		  if (window.FileReader) { // html5方案
			  for (var i=0, f; f = file.files[i]; i++) {
				  var fr = new FileReader();
				  fr.onload = function(e) {
					  var src = e.target.result;
					  if (!validateImg(src)) {
					  	alert(tip)
					  } else {
						  $("#target").attr('src',src);
					  	
					  }
				  }
				  	fr.readAsDataURL(f);
			  }
		  } else { // 降级处理
	
			  if ( !/\.jpg$|\.png$|\.gif$/i.test(file.value) ) {
			  	alert(tip);
			  } else {
				  $("#target").attr('src',src);
			  }
		  }
		function validateImg(data) {
			  var pos = data.indexOf(",") + 1;
			  for (var e in filters) {
				  if (data.indexOf(filters[e]) === pos) {
				  	return e;
				  }
			  }
			  return null;
		}
		function showPrvImg(src) {
			  var img = document.createElement("img");
			  img.src = src;
			  prvbox.appendChild(img);
		}
  });
  
</script>
<img src="{{url('files/image/14.jpg')}}" id="target" style="width:50%" alt="[Jcrop Example]" />

@endsection
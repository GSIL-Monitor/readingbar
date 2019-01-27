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
    <div class="row">
    <template v-for="r in result.data">
             <div class="col-lg-4">
                <div class="contact-box">
                    <a >
                    <div class="col-sm-4">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="[[r.avatar]]">
                            <div class="m-t-xs font-bold">[[r.nick_name]]</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>[[r.name]]</strong></h3>
                        <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                        <address>
                            <strong>parent:[[r.parent_name]]</strong><br>                                            
                            <select v-model="result.data[$index].teacher_id">
                            	 <option v-for="t in teachers" v-bind:value="t.id">
								    [[ t.name ]]
								 </option>
                            </select>
                            <button v-on:click="dodistribute($index)">分配</button>
                        </address>
                    </div>
                    <div class="clearfix"></div>
                        </a>
                </div>
            </div>
     </template>
    </div>
    <div>
    	<ul class="pagination" v-if="result.total_pages>1">
	    	<li v-if="result.current_page>1" v-on:click="dochangepage(1)"><a>«</a></li>
    		<template v-for="p in result.total_pages" v-if="Math.abs(result.current_page-(p+1))<=3">
    			<li v-if="result.current_page==p+1" class="active" v-on:click="dochangepage(p+1)"><span>[[ p+1 ]]</span></li>
    			<li v-else v-on:click="dochangepage(p+1)"><a>[[ p+1 ]]</a></li>
    		</template>
	     	<li v-if="result.current_page < result.total_pages" v-on:click="dochangepage(result.total_pages)"><a>»</a></li>
     	</ul>
     </div>
</div>
<script type="text/javascript">
	_students=new Vue({
			el:"body",
			data:{
				ajaxurl:"{{url('admin/studentdistribution/students')}}",
				search:{
					name:"",
					page:1,
					limit:8
				},
				result:null,
				teachers:null
			},
			methods:{
				showdata:function(){
					_this=this;
					$.ajax({
						url:_this.ajaxurl,
						data:_this.search,
						dataType:'json',
						success:function(json){
								_this.result=json;
						}
					});
				},
				teachersdata:function(){
					_this=this;
					$.ajax({
						url:"{{url('admin/studentdistribution/teachers')}}",
						dataType:'json',
						success:function(json){
							if(json.status){
								_this.teachers=json.data;
							}
							
						}
					});
				},
				dodistribute:function(index){
					tid=this.result.data[index].teacher_id;
					stid=this.result.data[index].id;
					_this=this;
					$.ajax({
						url:"{{url('admin/studentdistribution/dodistribute')}}",
						data:{student_id:stid,teacher_id:tid},
						dataType:'json',
						success:function(json){
							if(json.status){
								alert(json.msg);
							}
						}
					});
				},
				dochangepage:function(page){
					this.search.page=page;
					this.showdata();
				}
			}
		});
	_students.showdata();
	_students.teachersdata();
</script>
@endsection



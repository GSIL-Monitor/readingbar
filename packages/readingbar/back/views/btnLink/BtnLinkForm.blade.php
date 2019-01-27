@extends('superadmin/backend::layouts.backend')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('home/t-btns/btn.css') }}">
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
  <section class="wrapper wrapper-content animated fadeInRight"  id="mainContent"> 
		<div class="row">
			<div class="col-md-12">
				<div class="box box-warning ibox-content">
		            <div class="box-header with-border ">
		              <h3 class="box-title">{{ trans('BtnLink.view_form') }}</h3>
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		              <form role="form" method="POST"  :action="action" enctype="multipart/form-data" >
		             	{!! csrf_field() !!}
		             	<input class="form-control"   type="hidden" name='id' v-model='form.id'>
		                <!-- text input -->
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.name') }}</label>
		                  <input class="form-control" placeholder="{{ trans('BtnLink.placeholder.name') }}" type="text" name='name' v-model='form.name'>
		                  <span class="help-block" v-if="errors.name">[[ errors.name[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.link') }}</label>
		                  <input class="form-control" placeholder="{{ trans('BtnLink.placeholder.link') }}" type="text" name='link' v-model='form.link'>
		                  <span class="help-block" v-if="errors.link">[[ errors.link[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.position') }}</label>
		                 <select class="form-control"  name='position'  v-model='form.position' v-on:change="changePosition()">
		                    <option v-for="p in positions" :value='p.id' >[[ p.name ]]</option>
		                  </select>
						 <span class="help-block" v-if="errors.position">[[ errors.position[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.style') }}</label>
		                  <select class="form-control"  name='style'  v-model='form.style' v-on:change="getPreview()">
		                    <option v-for="s in filerStyle(styles)" :value='s.id' >[[ s.style_name ]]</option>
		                  </select>
		                  <span class="help-block" v-if="errors.style">[[ errors.style[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.preview') }}</label>
		                  <div class="row" style="padding:50px;">
		                  		<div v-html="preview"></div>
		                  </div>
		                </div>
		                
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.display') }}</label>
		                  <input class="form-control" placeholder="{{ trans('BtnLink.placeholder.display') }}" type="text" name='display' v-model='form.display'>
		                  <span class="help-block" v-if="errors.display">[[ errors.display[0] ]]</span>
		                </div>
		                <div class="form-group">
		                  <label>{{ trans('BtnLink.columns.status') }}</label>
		                  <select class="form-control"  name='status'  v-model='form.status'>
		                    <option value='0' >{{ trans('BtnLink.form.status.0') }}</option>
		                    <option value='1' >{{ trans('BtnLink.form.status.1') }}</option>
		                  </select>
		                  <span class="help-block" v-if="errors.status">[[ errors.status[0] ]]</span>
		                </div>
		             
						<div class="box-footer">
			                <a type="submit" :href="cancel" class="btn btn-default">{{ trans('BtnLink.btns.cancel') }}</a>
			                <button type="submit" class="btn btn-info pull-right">{{ trans('BtnLink.btns.save') }}</button>
			            </div>
		              </form>
		            </div>
		            <!-- /.box-body -->
		            <div class="overlay" v-if="loading.status">
			          <i class="fa fa-refresh fa-spin"></i>
			        </div>
		          </div>
			</div>
		</div>
    </section>
    <script type="text/javascript">
	    var mainContent=new Vue({
			el:"#mainContent",
			data:{
				action:"{{ $action }}",
				cancel:"{{ $cancel }}",
				form:{!! $editObj !!},
				styles:{!! $styles !!},
				preview:"",
				positions:{!! $positions !!},
				loading:{
					status:false,
					msg:''
				},
				errors:{!! $errors->toJson() !!},
			},
			created:function(){
				this.getPreview();
				for(i in this.errors){
					$('input[name='+i+'],select[name='+i+']').parent('.form-group').addClass('has-error');
					$(".error_"+i).parent('.form-group').addClass('has-error');
				}
			},
			methods:{
				filerStyle:function(styles){
					var _this=this;
                     return styles.filter(function(item){  
                        return item.position==_this.form.position;
                    })  
				},
				changePosition:function(){
					this.form.style='';
				},
				getPreview:function(){
					var html='';
					for(i in this.styles){
						if(this.form.style==this.styles[i].id){
							html=this.styles[i].html;
							html=html.replace('replace_name',this.form.name);
							html=html.replace('replace_link',this.form.link);
							return this.preview=html;
						}
					}
				}
			}
		});
    </script>
@endsection



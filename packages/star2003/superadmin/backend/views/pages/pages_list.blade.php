@extends('superadmin/backend::layouts.backend')

@section('content')
<link href="{{ asset('assets/css/plugins/jsTree/style.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $head_title or 'form' }}</h2>
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
	@if($success)
		<div role="alert" class="alert alert-success alert-dismissible">
		      <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
		       <strong>{{$success}}</strong> 
		</div>
	@endif
	@if($error && $error!='')
		<div role="alert" class="alert alert-success alert-dismissible">
		      <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
		      <strong>{{$error}}</strong> 
		</div>
	@endif
</div>
<div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <h5>Folders</h5>
                                <div id="FolderTree">
                                	
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 animated fadeInRight">
                    <div class="row" id="FilesList">
                            <div class="ibox float-e-margins">
			                   
			                    <div class="ibox-content">
			
			                    <div class="table-responsive">
			                    <table class="table table-striped table-bordered table-hover dataTables-example" >
			                    <thead>
			                    <tr>
			                        <th>{{ trans("pages.column_name")}}</th>
			                        <th>{{ trans("pages.column_modified")}}</th>
			                        <th>{{ trans("common.operations")}}</th>
			                    </tr>
			                    </thead>
			                    <tbody>
			                   	
			                    </tbody>
			                    
			                    </table>
			                        </div>
			
			                    </div>
			                </div>
                    </div>
                </div>
            </div>


<script src="{{asset('assets/js/plugins/jsTree/jstree.min.js')}}"></script>
<style>
    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }
    .vakata-context{
    	z-index:1000
    }
</style>

<script>				
		$(function () {
			var to = false;
			$('#demo_q').keyup(function () {
				if(to) { clearTimeout(to); }
				to = setTimeout(function () {
					var v = $('#demo_q').val();
					$('#FolderTree').jstree(true).search(v);
				}, 250);
			});

			$('#FolderTree')
				.jstree({
					"core" : {
						"animation" : 0,
						"check_callback" : true,
						
						'force_text' : true,
						"themes" : { "stripes" : true },
						'data' : {
							'url' : '{{url("admin/pages/operations?operation=get_folders")}}',
							'dataType':"json",
							'data' : function (node) {
								return { 'direct' : node.id};
							}
						}
					},'sort' : function(a, b) {
						return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
					},
					'contextmenu' : {
						'items' : function(node) {
							var tmp = $.jstree.defaults.contextmenu.items();
							delete tmp.create.action;
							tmp.create.label = "New";
							tmp.create.submenu = {
								"create_folder" : {
									"separator_after"	: true,
									"label"				: "Folder",
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
											inst.create_node(obj, { type : "folder" }, "last", function (new_node) {
											inst.set_type(new_node,"folder" );
											setTimeout(function () { inst.edit(new_node); },0);
										});
									}
								},
								"create_file" : {
									"label"				: "File",
									"action"			: function (data) {
										var inst = $.jstree.reference(data.reference),
											obj = inst.get_node(data.reference);
										inst.create_node(obj, { "type" : "html" }, "last", function (new_node) {
											setTimeout(function () { 
												inst.edit(new_node); 
											},0);
										});
									}
								}
							};
							if(this.get_type(node) === "file") {
								delete tmp.create;
							}
							return tmp;
						}
					},
					"types" : {
						'default' : {
		                    'icon' : 'fa fa-folder'
		                },
		                'html' : {
		                    'icon' : 'fa fa-file-code-o'
		                },
		                'svg' : {
		                    'icon' : 'fa fa-file-picture-o'
		                },
		                'css' : {
		                    'icon' : 'fa fa-file-code-o'
		                },
		                'img' : {
		                    'icon' : 'fa fa-file-image-o'
		                },
		                'js' : {
		                    'icon' : 'fa fa-file-text-o'
		                }
					},
					'unique' : {
						'duplicate' : function (name, counter) {
							return name + ' ' + counter;
						}
					},
					"plugins" : [ 'state','dnd','sort','types','contextmenu','unique']
				}).on('delete_node.jstree', function (e, data) {
					$.getJSON('{{url("admin/pages/operations")}}?operation=delete_node', { 'id' : data.node.id })
					.fail(function () {
						data.instance.refresh();
					});
				})
				.on('create_node.jstree', function (e, data) {
					$.getJSON('{{url("admin/pages/operations")}}?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
						.done(function (d) {
							if(d.id){
								data.instance.set_id(data.node, d.id);
							}
						}).fail(function () {
							data.instance.refresh();
						});
				})
				.on('rename_node.jstree', function (e, data) {
					$.getJSON('{{url("admin/pages/operations")}}?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
						.done(function (d) {
							data.instance.set_id(data.node, d.id);
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('move_node.jstree', function (e, data) {
					$.getJSON('{{url("admin/pages/operations")}}?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
						.done(function (d) {
							data.instance.refresh();
						})
						.fail(function () {
							data.instance.refresh();
						});
				})
				.on('copy_node.jstree', function (e, data) {
					$.getJSON('{{url("admin/pages/operations")}}?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
						.done(function (d) {
							data.instance.refresh();
						})
						.fail(function () {
							data.instance.refresh();
						});
				}).on("select_node.jstree",function(e,data){
					$("input[name='direct']").val(data.node.id);

					$.getJSON("{{url('admin/pages/operations?operation=get_files')}}&direct="+data.instance.get_path(data.node,'/'))
					.done(function (d) {
						trHtml='<tr class="gradeX"><td>[name]</td><td>[modified]</td><td class="center">  <a href="{{url('admin/pages/operations?operation=edit_file')}}&direct=[dir]" class="btn btn-primary">{{ trans("common.edit")}}</a>   <a href="[webPath]" target="_blank" class="btn btn-primary">{{ trans("pages.button_view_effect")}}</a> <a href="{{url('admin/pages/operations?operation=static_file')}}&direct=[dir]" target="_blank" class="btn btn-primary">{{ trans("pages.button_view_static")}}</a></td></tr>';
						$("#FilesList table tbody").html('');
						if(d.length>0){
							for(i in d){
								$("#FilesList table tbody").append(replaceFilesListTag(trHtml,d[i]));
							}
						}else{
							trHtml='<tr class="gradeX"><td colspan="3" class="text-center">null</td></tr>';
						}
					})
					.fail(function () {
						//data.instance.refresh();
					});
				});
		});
		function replaceFilesListTag(html,json){
			html=html.replace('[name]',json.name);
			var regS = new RegExp(/\[dir\]/,"gi"); 
			html=html.replace(regS,json.dir);
			html=html.replace('[modified]',json.modified);
			html=html.replace('[webPath]',json.webPath);
			return html;
		}
		
</script>

</div>     
@endsection
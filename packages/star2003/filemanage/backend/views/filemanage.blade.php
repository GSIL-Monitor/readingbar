<div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary btn-block" id="btn-upload" onclick="$('#fileupload input[name=uploadfile]').click()">Upload Files</button>
                                <form enctype="multipart/form-data" style="display: none"  action="{{url('admin/filemanage/upload')}}" method="post"  id="fileupload" target="fileuploadIframe">
	                                {!! csrf_field() !!}
									{{ method_field('POST') }}
									<input type="file" onchange="$('#fileupload').submit()" name="uploadfile"/>
									<input type="text" name="jstree_path"/>
								</form>
                                <iframe style="display:none" name="fileuploadIframe" src="about:blank" ></iframe>
                                <div class="hr-line-dashed"></div>
                                <h5>Folders</h5>
                                <div id="FolderTree">
                                	
                                </div>
                                
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 animated fadeInRight">
                    <div class="row" id="FilesList" >
	                   	<div class="col-lg-12">
	                        <div class="file-box" v-for="file in files">
							  <div class="file" id='[[file.id]]' file-type="[[file.type]]" file-webpath="[[file.href]]"  v-if="file.type=='txt'">
							    <a href="javascript:void(0)">
							      <span class="corner"></span>
							      <div class="icon">
							        <i class="fa fa-file"></i>
							      </div>
							      <div class="file-name">[[file.text]]
							      <br/>
							      <small>Modified:[[file.modified]]</small></div>
							    </a>
							  </div>
							  <div class="file" id='[[file.id]]' file-type="[[file.type]]" file-webpath="[[file.href]]" v-if="file.type=='jpg'|| file.type=='jpeg' || file.type=='png' ||file.type=='gif'">
							    <a href="javascript:void(0)">
							      <span class="corner"></span>
							      <div class="image">
                                      <img src="[[file.href]]" class="img-responsive" alt="image">
                                  </div>
							      <div class="file-name">[[file.text]]
							      <br/>
							      <small>Modified:[[file.modified]]</small></div>
							    </a>
							  </div>
							  <div class="file" id='[[file.id]]' file-type="[[file.type]]" file-webpath="[[file.href]]" v-if="file.type=='mp4'">
							    <a href="javascript:void(0)">
							      <span class="corner"></span>
							      <div class="icon">
							        <i class="img-responsive fa fa-film"></i>
							      </div>
							      <div class="file-name">[[file.text]]
							      <br/>
							      <small>Modified:[[file.modified]]</small></div>
							    </a>
							  </div>
							  <div class="file" id='[[file.id]]' file-type="[[file.type]]" file-webpath="[[file.href]]" v-if="file.type=='mp3'">
							    <a href="javascript:void(0)">
							      <span class="corner"></span>
							      <div class="icon">
							        <i class="fa fa-music"></i>
							      </div>
							      <div class="file-name">[[file.text]]
							      <br/>
							      <small>Modified:[[file.modified]]</small></div>
							    </a>
							  </div>
							  <div class="file" id='[[file.id]]' file-type="[[file.type]]" file-webpath="[[file.href]]" v-if="file.type=='pdf'">
							    <a href="javascript:void(0)">
							      <span class="corner"></span>
							      <div class="icon">
							        <i class="fa fa-music"></i>
							      </div>
							      <div class="file-name">[[file.text]]
							      <br/>
							      <small>Modified:[[file.modified]]</small></div>
							    </a>
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
var FileType="";
var FilesList = new Vue({
	  el: '#FilesList',
	  data: {
	    files: []
	  }
});
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
					'url' : '{{url("admin/filemanage/operations?operation=get_folders")}}&filetype='+FileType,
					'dataType':"json",
					'data' : function (node) {
						return { 'id' : node.id};
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
                    'icon' : 'fa fa-file-text-o'
                },
				'folder' : {
                    'icon' : 'fa fa-folder'
                },
                'image' : {
                    'icon' : 'fa fa-file-image-o'
                },
                'text':{
                	'icon' : 'fa fa-file-text-o'
                },
                'inode': {
                    'icon' : 'fa fa-file-image-o'
                },
			},
			'unique' : {
				'duplicate' : function (name, counter) {
					return name + ' ' + counter;
				}
			},
			"plugins" : [ 'state','dnd','sort','types','contextmenu','unique']
		}).on('delete_node.jstree', function (e, data) {
			$.getJSON('{{url("admin/filemanage/operations")}}?operation=delete_node', { 'id' : data.node.id })
			.fail(function () {
				data.instance.refresh();
			});
		})
		.on('create_node.jstree', function (e, data) {
			$.getJSON('{{url("admin/filemanage/operations")}}?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
				.done(function (d) {
					if(d.id){
						data.instance.set_id(data.node, d.id);
					}
				}).fail(function () {
					data.instance.refresh();
				});
		})
		.on('rename_node.jstree', function (e, data) {
			$.getJSON('{{url("admin/filemanage/operations")}}?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('move_node.jstree', function (e, data) {
			$.getJSON('{{url("admin/filemanage/operations")}}?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
				.done(function (d) {
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('copy_node.jstree', function (e, data) {
			$.getJSON('{{url("admin/filemanage/operations")}}?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
				.done(function (d) {
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
				});
		}).on("select_node.jstree",function(e,data){
			
			if(data.node.type=='folder'){
				$('input[name=jstree_path]').each(function(){
					$(this).val(data.node.id);
				});
				$.getJSON('{{url("admin/filemanage/operations")}}?operation=get_files&filetype='+FileType, { 'id': data.node.id })
				.done(function (d) {
					FilesList.files=d;
				})
				.fail(function () {
					alert('接口调用失败！');
				});
			}
		});
});	
function refleshJstree(){
	ref=$('#FolderTree').jstree(true);
	ref.refresh();
}
</script>
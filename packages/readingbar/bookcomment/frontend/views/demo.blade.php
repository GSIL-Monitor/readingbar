<script src="{{ asset('assets/js/jquery-2.1.1.js')}}"></script>
<script type="text/javascript">
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
</script>
<script src="{{ asset('assets/js/plugins/vue/vue.min.js')}}"></script>
<script type="text/javascript">
Vue.config.delimiters = ['[[', ']]']; 
</script>
<div id="list">
	<ul >
		<li v-for="c in comments">
			<div>id:[[c.id]]</div>
			<div>ISBN:[[c.ISBN]]</div>
			<div>comment:[[c.comment]]</div>
			<div>member:[[c.nickname]]</div>
			<div><a href="{{url('comment/[[c.id]]/info')}}" onclick="return false" class="edit">编辑</a></div>
		</li>
	</ul>
	 <div class="page-bar">
            <ul>
            <li v-if="showFirst"><a v-on:click="btnClick(--cur)">上一页</a></li>
             <li v-for="index in indexs"  v-bind:class="{ 'active': cur == index}">
		        <a v-on:click="btnClick(index)">[[ index ]]</a>
		    </li>
                <li v-if="showLast"><a v-on:click="btnClick(++cur)">下一页</a></li>
                <li><a>共<i>[[ all ]]</i>页</a></li>
            </ul>
     </div>
</div>
<script type="text/javascript">
var comment_list=new Vue({
	  el: '#list',
	  data: {
		 comments:[],
		 all: 0, //总页数
	     cur: 1,//当前页码
	     order:'',
	     sort:'',
	     ISBN:13799956353
	  },
		computed: {
		    indexs: function(){
		      var left = 1
		      var right = this.all
		      var ar = [] 
		      if(this.all>= 11){
		        if(this.cur > 5 && this.cur < this.all-4){
		                left = this.cur - 5
		                right = this.cur + 4
		        }else{
		            if(this.cur<=5){
		                left = 1
		                right = 10
		            }else{
		                right = this.all
		                left = this.all -9
		            }
		        }
		     }
		    while (left <= right){
		        ar.push(left)
		        left ++
		    }   
		    
		    return ar
		   },
		   showLast: function(){
		        if(this.cur == this.all){
		            return false
		        }
		        return true
		   },
		   showFirst: function(){
		        if(this.cur == 1){
		            return false
		        }
		       return true
		   }
		},
	  methods: {
		  showData: function () {
              var url = "{{url('comment/list')}}";
              $.ajax({
	      			url:url,
	      			data:{ISBN:this.ISBN,page:this.cur,order:this.order,sort:this.sort},
	      			dataType:'json',
	      			success:function(json){
	      				comment_list.comments=json.data;
	      				comment_list.all=json.total_pages;
	      				comment_list.cur=json.current_page;
	      				comment_list.sort=json.sort;
	      				comment_list.order=json.order;
	      			}
	      	 });
          },
          btnClick: function(data){//页码点击事件
              if(data != this.cur){
                  this.cur = data 
              }
              this.showData();
          }
      },
      watch: {
          cur: function(oldValue , newValue){
              console.log(arguments)
         }
      }
});
comment_list.showData();
</script>



<br><hr><br>





<div id="comment">
评论
<form id="comment-form">
	comment:<input type="text" name="comment">
	ISBN:<input type="text" name="ISBN" value="13799956353">
	<button>提交</button>
</form>
<script type="text/javascript">

	$("#comment-form").submit(function(){
			$.ajax({
				url:"{{url('comment/comment')}}",
				data:$(this).serialize(),
				dataType:'json',
				success:function(json){
					if(json.error){
						alert(json.error);
					}else{
						alert('success');
					}
				}
			});
			return false;
	});
</script>
</div>




<br><hr><br>





<div id="edit">
编辑
<form id="edit-form">
	comment:<input type="text" name="comment" autocomplete="off" value="[[info.comment]]">
	id:<input type="text" name="id" value="[[info.id]]">
	<button>提交</button>
</form>
<script type="text/javascript">
	var edit_form=new Vue({
		  el: '#edit-form',
		  data: {
			  info:[]
		  }
	});
	$("#list").on('click','a.edit',function(){
		$.ajax({
			url:$(this).attr('href'),
			dataType:'json',
			success:function(json){
				if(json.error){
					alert(json.error);
				}else{
					edit_form.info=json;
				}
			}
		});
	});
	$("#edit-form").submit(function(){
			$.ajax({
				url:"{{url('comment/edit')}}",
				data:$(this).serialize(),
				dataType:'json',
				success:function(json){
					if(json.error){
						alert(json.error);
					}else{
						alert('success');
					}
				}
			});
			return false;
	});
</script>
</div>
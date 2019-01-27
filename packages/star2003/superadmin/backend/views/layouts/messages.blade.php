<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-envelope"></i>  
        @if(session('BMessages')['unread'])
        <span class="label label-warning">{{ session('BMessages')['unread'] }}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-messages">
    	@foreach(session('BMessages')['messages'] as $m)
    	<li>
            <div class="dropdown-messages-box">
                <a href="{{url('admin/messagesBox/'.$m['id'].'/detail')}}" class="pull-left">
                    <img alt="image" class="img-circle" src="{{ $m['sender_avatar'] }}"/>
                </a>
                <div class="media-body">
                    <strong>{{ $m['content'] }}<br></strong>
                    <small class="text-muted">{{ $m['created_at'] }}</small>
                </div>
            </div>
        </li>
        <li class="divider"></li>
    	@endforeach
        <li>
            <div class="text-center link-block">
                <a href="{{url('admin/messagesBox')}}">
                    <i class="fa fa-envelope"></i> <strong>查看所有消息</strong>
                </a>
            </div>
        </li>
    </ul>
</li>
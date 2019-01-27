<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="{{ trans('header.search') }}" class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message">{{ trans('header.welcome') }}</span>
                </li>
                <li>
                	<a class="set_en active" href="{{url('/admin/lang/en')}}"><img alt="EN" src="{{ asset('assets/img/flags/16/United-States.png') }}">EN</a>
                </li>
                <li>
                	<a class="set_en active" href="{{url('/admin/lang/zh')}}"><img alt="ZH" src="{{ asset('assets/img/flags/16/China.png') }}">ZH</a>
                </li>
                @include('superadmin/backend::layouts.messages')
                <!-- 
                @include('superadmin/backend::layouts.alerts')
                -->

                <li>
                    <a href="{{url('admin/logout')}}">
                        <i class="fa fa-sign-out"></i> {{ trans('common.text_logout') }}
                    </a>
                </li>
                <!-- li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li -->
            </ul>

        </nav>
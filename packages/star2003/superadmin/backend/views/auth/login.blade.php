<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SuperAdmin | Login</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
   
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">    

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div style= "margin-top: 150px;margin-bottom:50px">

                <img alt="Logo" style="width: 200px"src="{{ asset('assets/img/logo.png') }}">

            </div>
            
            <form class="m-t" role="form" action="{{ url('/admin/login') }}" method="POST">
            	 {{ csrf_field() }}
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="email" name="email" required="" value="{{ old('email') }}">
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif                               
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required="">
                	@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif  
                </div>
                @if(session('showCaptcha'))
                <div class="form-group">
                	<div class="input-group clockpicker" data-autoclose="true">
                           <input type="text" class="form-control" name="captcha" value="" placeholder="Captcha">
                           <span class="input-group-addon" style="padding:0 !important" onclick="newCaptcha()">
                                  <img id="captcha" src="{{ captcha_src('adminLogin') }}" alt="captcha"></img>
                           </span>
                           <span class="input-group-addon" onclick="newCaptcha()">
                                    <span class="fa fa-repeat" ></span>
                           </span>
                           <script type="text/javascript">
								//刷新验证码
								function newCaptcha(){
									var captcha=document.getElementById('captcha');
									captcha.src=captcha.src+1;
								}
                           </script>
                    </div>
                    @if ($errors->has('captcha'))
						<span class="help-block">
							<strong>{{ $errors->first('captcha') }}</strong>
						</span>
					@endif 
                </div>
                @endif
                <div class="form-group">
                    <input type="checkbox" name="remember"> Remember Me  
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

               </form>
            <p class="m-t"> <small>Readingbar.Net &copy; 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
   <script src="{{ asset('assets/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

</body>

</html>

<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
class PauthController extends Controller
{
   
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    //设置登录后重定向
    protected $redirectTo = '/admin/user';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
    }
    protected function create(array $data)
//    public function create()
    {
//        $data=[
//            'name'  =>111,
//            'email' =>"605333742@qq.com",
//            'password'  =>'123456'
//        ];
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    protected function validateLogin(Request $request)
    {
    	if(session('showCaptcha')){  //登录一次错误后   后续登录需要验证码
    		$this->validate($request, [
                    'captcha' => 'required|captcha',$this->loginUsername() => 'required', 'password' => 'required'
    		]);
    	}else{
    		$this->validate($request, [
                    $this->loginUsername() => 'required', 
                    'password' => 'required'
    		]);
    	}
    }
    protected function sendFailedLoginResponse(Request $request)
    {
    	session(['showCaptcha'=>true]);//开启验证码登录
    	return redirect()->back()
    	->withInput($request->only($this->loginUsername(), 'remember'))
    	->withErrors([
            $this->loginUsername() => $this->getFailedLoginMessage(),
    	]);
    }
    public function loginForm(){
    	return view("superadmin/backend::auth.login");
    }
    public function registerForm(){
    	return view("superadmin/backend::auth.register");
    }
}

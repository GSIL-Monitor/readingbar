<?php

namespace Superadmin\Backend\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Superadmin\Backend\Models\User;
use Validator;
use Cache;
use Auth;
use Storage;
use Illuminate\Support\Facades\File;
class ProfileController extends Controller
{
	private $breadcrumbs=array(
			array('name'=>'menu.home','url'=>'admin','active'=>false),
			array('name'=>'menu.system','url'=>'','active'=>false),
			array('name'=>'profile.head_title','url'=>'admin/profile','active'=>true),
	);
   public function index(){
	   	$data['head_title']=trans('profile.head_title');
	   	$data['breadcrumbs']=$this->breadcrumbs;
   		
   		return view("superadmin/backend::profile.profile",$data);
   }
   public function show(){}
   public function edit($id){}
   public function create(){}
   public function getForm($id=0){}
   public function update(Request $request){}
   public function store(Request $request){
   		switch($request->input("operation")){
   			case 'reset_password':return $this->resetPassword($request);break;
   			case 'reset_avatar':return $this->resetAvatar($request);break;
   		}
   }
   public function resetAvatar($request){
	   	$file = $_FILES['avatar'];
	    $fileName = "avatar_".Auth::user()->id.".".File::extension($file['name']);
	    $fileName = $fileName ?: $file['name'];
	    $path = 'files/avatar/' . $fileName;
	    $content = File::get($file['tmp_name']);
	    $result = Storage::put($path, $content);
	    if ($result === true) {
	    	User::where("id","=",Auth::user()->id)->update(array('avatar'=>$path));
	        return redirect()
	                ->back()
	                ->withSuccess("File '$fileName' uploaded.");
	    }
	    $error = $result ? : "An error occurred uploading file.";
	   
	    return redirect()
            ->back()
            ->withErrors([$error]);
   }
   public function resetPassword($request){
	   	$all=$request->all();
	   	if (Auth::attempt(array('email' => Auth::user()->email, 'password' => $all["password"])))
	   	{
	   		$validator = Validator::make($all, [
	   				'newpassword' => 'required|min:6|confirmed'
	   		]);
	   	}else{
	   		$validator = Validator::make($all, [
	   				'password'	  => 'required|in:users,id,'.Auth::user()->id,
	   				'newpassword' => 'required|min:6|confirmed'
	   				]);
	   	}
	   	
	   	if ($validator->fails()) {	   		
	   		return redirect("admin/profile")
	   		->withErrors($validator)
	   		->withInput();
	   	}else{
	   		$user=array(
	   				'password'=>bcrypt($all["newpassword"])
	   		);
	   		User::where("id","=",Auth::user()->id)->update($user);
	   		return redirect('admin/logout');
	   	}
   }
   public function destroy(Request $request){
   		
   }

}

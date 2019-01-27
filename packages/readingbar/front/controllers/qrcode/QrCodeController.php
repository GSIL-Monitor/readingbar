<?php

namespace Readingbar\Front\Controllers\Qrcode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use QrCode;
use Storage;
use Readingbar\Front\Controllers\FrontController;
class QrCodeController extends FrontController
{
	public function index(Request $request){
		$path = 'files/qrcodes/'.md5(time().rand(0,99999999)).'.png';
		QrCode::format('png')->size(200)->generate($request->input('param'),public_path($path));
		return redirect($path);
	}
}

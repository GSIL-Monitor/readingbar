1.config/app.php
=>providers
Tools\Oauth\OauthProvider::class,
=>aliases
'Oauth' => Tools\Oauth\Facades\Oauth::class
 
2.composer.json "psr-4"
	"Tools\\Oauth\\": "packages/star2003/tools/oauth"
3.config/services.php 服务
'QQ' => [
	    'client_id' => env('QQ_KEY'),
	    'client_secret' => env('QQ_SECRET'),
	    'redirect' => env('QQ_REDIRECT_URI'),
 ],
4.env
QQ_KEY=101345828
QQ_SECRET=5de8a4298681a79271b89214970b09e4
QQ_REDIRECT_URI=http://www.584231366.site/oauth/QQ/login

5. composer dump-autoload

测试  www.584231366.site/oauth/QQ  因为这个QQ的app绑定的域名是www.584231366.site 所以测试的时候请把本地的域名改为www.584231366.site


1.config/app.php 

providers 下添加
Tools\Messages\MessagesProvider::class,

aliases 下添加
 'Messages' => Tools\Messages\Facades\Messages::class,
 
2.composer.json
"Tools\\Messages\\": "packages/star2003/tools/messages"

3.运行 composer dump-auto

4.将配置文件复制至config下

5.配置QQ SMPT 
MAIL_DRIVER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=465
MAIL_USERNAME=584231366@qq.com
MAIL_PASSWORD=wqbqvdowcfmibdad（这个是QQ邮箱的第3方授权码  不是登录密码）
MAIL_ENCRYPTION=ssl


6.测试路由
message
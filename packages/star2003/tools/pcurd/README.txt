1.config/app.php 服务提供者
 Tools\Pcurd\Backend\ToolsProvider::class,
 
2.composer.json
"Tools\\Pcurd\\Backend\\": "packages/star2003/tools/pcurd/backend"

3. composer dump-autoload

4. php artisan list

5. php artisan help package:create

---php artisan package:create star2003 testuser users

6. composer dump-autoload
 
7. php artisan vendor:publish
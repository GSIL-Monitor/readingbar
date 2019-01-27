    
1.composer.json
"Readingbar\\Common\\":"packages/readingbar/common",

2.config/app.php

Readingbar\Common\CommonProvider::class,

3.composer dump-auto
4.php artisan vendor:publish
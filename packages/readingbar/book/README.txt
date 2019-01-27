1.config/app.php 服务提供者
Readingbar\Book\BookProvider::class,
 
2.composer.json
"Readingbar\\Book\\": "packages/readingbar/book",

3.composer dump-auto
4.php artisan vendor:publish
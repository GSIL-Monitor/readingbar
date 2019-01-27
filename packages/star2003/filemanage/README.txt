1.config/app.php 服务提供者
Filemanage\Backend\FilemanageProvider::class,
 
2.composer.json
"Filemanage\\Backend\\": "packages/star2003/filemanage/backend",

3.config/filesystems.php 文件指定存储位置
'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => public_path('/'),
            'webPath'=>'/files'
        ],
4.composer dump-autoload
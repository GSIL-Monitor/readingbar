<?php

namespace Superadmin\Backend\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use Cache;
class Superadmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'superadmin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install superadmin service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('vendor:publish',[
    		'--force' => true,
		]);
		echo "publish success!\n";
		Artisan::call('migrate',[
			'--path'  =>'packages\star2003\superadmin\backend\database\migrations'
		]);
		echo "migrate success!\n";
		Cache::flush();
    }
}

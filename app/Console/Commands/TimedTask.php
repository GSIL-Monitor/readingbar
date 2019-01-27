<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Messages;
use Readingbar\Back\Models\Messages as MessagesModel;
use Readingbar\Back\Models\TimedTask as TimedTaskModel;
use Readingbar\Back\Models\StarAccount;
use Superadmin\Backend\Models\User;
use Readingbar\Back\Models\Members;
use Readingbar\Back\Models\ReadPlan;
use App\Jobs\ReadPlanJob;
use App\Jobs\DueServiceInformat;
use DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\ServiceStatus;
use Readingbar\Back\Models\ActionTimes;
use Readingbar\Back\Models\Discount;
use Readingbar\Back\Controllers\Messages\AlidayuSendController;
class TimedTask extends Command
{
	use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timed-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send delay messages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		// 发送服务到期后n天，到期前n天，开始后n天的短信
    	$a=new AlidayuSendController();
    	$a->send('after_service_start');
    	$a->send('after_service_end');
    	$a->send('before_service_end');
    	$a->send('before_read_plan_end');
    	$this->read_plan();
    	$this->confirm_read_plan();
    	$this->dell_expirated_discount();
    }
    //过期阅读计划改变状态
    public function read_plan(){
    	ReadPlan::where('read_plan.to','<=',DB::raw('NOW()'))
	    	->whereIn('read_plan.status',[2,3])
	    	->update(['status'=>6]);
    }
    //阅读计划提交1日后默认为确认
    public function confirm_read_plan(){
    	$rps=ReadPlan::where(['status'=>0])->where(DB::raw('TIMESTAMPDIFF(DAY,updated_at,NOW())'),'>=','1')->get();
    	foreach($rps as $rp){
    		dispatch(new ReadPlanJob($rp));
    	}
    }
    //过期优惠券状态改变
    public function dell_expirated_discount(){
    	Discount::where('expiration_time','<',DB::raw('NOW()'))->where(['status'=>0])->update(['status'=>2]);
    }
}

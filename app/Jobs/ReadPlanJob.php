<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Readingbar\Back\Models\ReadPlan;
use Readingbar\Back\Models\Messages;
class ReadPlanJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
	private $rp;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ReadPlan $rp)
    {
        $this->rp=$rp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    	ReadPlan::where(['id'=>$this->rp->id,'status'=>0])->update(['status'=>1]);
    	$message=array(
    			'sendfrom'=>"system",
    			'sendto'  =>4,
    			'content' =>"编号".$this->rp->id."的阅读计划已确认，请准备发书！"
    	);
    	Messages::create($message);
    }
}

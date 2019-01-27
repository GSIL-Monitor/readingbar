<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Messages;
use Readingbar\Back\Models\Students;
use Readingbar\Back\Models\Orders;
use Readingbar\Back\Models\Products;
use Readingbar\Back\Models\StarAccountAsign;
use Readingbar\Back\Models\StarAccount;
use Readingbar\Back\Models\Members;
use Superadmin\Backend\Models\User;
use DB;
use Readingbar\Api\Frontend\Controllers\Discount\DiscountController;
use Readingbar\Back\Models\TimedTask as TimedTaskModel;
class AliPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:pay {order_id} {trade_no} {pay_type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'alipay';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$r=DB::select('select buy_notify("'.$this->argument('order_id').'","'.$this->argument('trade_no').'","TRADE_FINISHED","'.$this->argument('pay_type').'") as result');
    	$o=Orders::where(['order_id'=>$this->argument('order_id')])->first();
    	if($r[0]->result){
    		DiscountController::createPayDiscountForPromoter($o->id);
    	}
    	
    	TimedTaskModel::where(['unique'=>md5('star_report_created_'.$o->owner_id)])->update(['status'=>1]);
    	$this->paymentMessages(Orders::where(['order_id'=>$this->argument('order_id')])->first());
    }
    /*付款消息通知*/
    public function paymentMessages($order){
    	$product=Products::where(['id'=>$order->product_id])->first();
    	$student=Students::where(['id'=>$order->owner_id])->first();
    	$member=Members::where(['id'=>$student->parent_id])->first();
    	$a=DB::select('select fun_asign_account_v3('.$student->id.') as result');
    	if($a[0]->result){
    		$staraccount=StarAccount::where(['id'=>$a[0]->result])->first();
    		$data['product_name']=$product->product_name;
    		$data['student_name']=$student->name;
    		$data['star_account']=$staraccount->star_account;
    		$data['star_password']=$staraccount->star_password;
    		$data['expired_date']=date("Y-m-d",time()+$product['days']*60*60*24);
    		$conections=array(
    				'sms'=>$member->cellphone,
    				'email'=>$member->email
    		);
    		Messages::sendMessageForAllConections($conections,"蕊丁吧",$data,'payment');
    	}else{
    		Messages::sendMessage($member->cellphone,"蕊丁吧",'','sms','payment-unAsignStarAccount');
    	}
    }
}

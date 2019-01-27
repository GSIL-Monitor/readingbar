<?php

namespace App\Events;
use App\Events\Event;
use Readingbar\Api\Frontend\Models\Orders;
class OrderEvent extends Event
{	
	public $order;
	public function __construct(Orders $order)
    {
        $this->order=$order;
    }
}

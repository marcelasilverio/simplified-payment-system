<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\PaymentModel;

class PaymentCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(PaymentModel $payment)
    {
        $this->payment = $payment;
    }
}

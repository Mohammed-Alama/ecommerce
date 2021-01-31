<?php

namespace App\Support\Order\StatusAction;

use App\Support\Order\StatusAbstract;

class Paid extends StatusAbstract
{
    public $previous_statuses = ['pending'];

    public function apply()
    {
        $this->checkValidStatus();
        $this->updateOrdeStatus();
    }

    public function updateOrdeStatus()
    {
        $this->order->update([
            'status' => $this->status,
            'paid_at' => now()
        ]);
    }
}

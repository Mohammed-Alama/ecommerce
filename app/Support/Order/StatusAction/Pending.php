<?php

namespace App\Support\Order\StatusAction;

use App\Support\Order\StatusAbstract;

class Pending extends StatusAbstract
{
    public $previous_statuses = ['in_cart'];

    public function apply()
    {
        $this->checkValidStatus();
        $this->updateOrdeStatus();
    }

    public function updateOrdeStatus()
    {
        $this->order->update([
            'status' => $this->status,
        ]);
    }
}

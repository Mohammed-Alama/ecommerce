<?php

namespace App\Support\Order\StatusAction;

use App\Support\Order\StatusAbstract;

class Cancelled extends StatusAbstract
{
    public $previous_statuses = ['paid'];

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

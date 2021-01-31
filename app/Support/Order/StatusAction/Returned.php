<?php

namespace App\Support\Order\StatusAction;

use App\Support\Order\StatusAbstract;

class Returned extends StatusAbstract
{
    public $previous_statuses = ['delivered'];

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

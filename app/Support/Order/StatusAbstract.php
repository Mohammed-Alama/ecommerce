<?php

namespace App\Support\Order;

use Illuminate\Validation\ValidationException;
use App\Models\Order;

abstract class StatusAbstract
{
    public $previous_statuses;

    public $status;

    public Order $order;

    public function __construct(string $status, Order $order)
    {
        $this->status = $status;
        $this->order = $order;
    }

    abstract public function apply();

    public function checkValidStatus()
    {
        $this->checkStatus();
    }

    public function checkStatus()
    {
        if (!in_array($this->order->status, $this->previous_statuses))
            throw ValidationException::withMessages(['errors' => [
                'reservation' => __('You can\'t Update Order Status')
            ]]);
    }
}

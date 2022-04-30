<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PurchaseMade
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;
    public $order;
    public $orderItems;

    /**
     * Create a new event instance.
     *
     * @return void
     */


    public function __construct($transaction, $order, $orderItems)
    {
        //
        $this->transaction = $transaction;
        $this->order = $order;
        $this->orderItems = $orderItems;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

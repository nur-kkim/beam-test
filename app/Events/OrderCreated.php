<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements shouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */

    public function broadcastOn(): array
    {
        return [
            new Channel('order')
        ];
    }

    public function broadcastAs()
    {
        return 'order.created'; // Имя события
    }

    public function broadcastWith()
    {
        $data = $this->order->load(['address.customer', 'device']);
        return [
            'order' => 'Пользователь ' . $data->address->customer->name . ' сделал заказ на ' . $data->device->name
        ];
    }
}

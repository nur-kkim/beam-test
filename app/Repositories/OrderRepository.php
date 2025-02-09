<?php

namespace App\Repositories;

use App\Dto\OrderDto;
use App\Events\OrderCreated;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function __construct(protected Order $order)
    {
    }


    public function index()
    {
        return $this->order->with(['address.customer', 'device'])->get();
    }

    public function create(OrderDto $data)
    {
        $order = new $this->order();
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $order->fill($data);
            $order->save();
            DB::commit();
            event(new OrderCreated($order));

            return $order;
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }


    public function update(OrderDto $data, $order)
    {
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $order->fill($data);
            $order->save();
            DB::commit();
            return $order;
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

}

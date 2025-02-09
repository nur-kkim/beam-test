<?php

namespace App\Http\Controllers;

use App\Dto\OrderDto;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    )
    {
    }
    /**
     * Получить всех клиентов.
     */
    public function index()
    {
        $result = $this->service->index();
        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Создать нового клиента.
     */
    public function store(OrderRequest $request)
    {
        $data = OrderDto::from($request);
        $result = $this->service->create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Показать конкретного клиента.
     */
    public function show(Order $order)
    {
        return response()->json($order, Response::HTTP_OK);
    }

    /**
     * Обновить информацию о клиенте.
     */
    public function update(OrderRequest $request, Order $order)
    {

        $data = OrderDto::from($request);
        $result = $this->service->update($data, $order);

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Удалить клиента.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => 'Order deleted'], Response::HTTP_NO_CONTENT);
    }
}

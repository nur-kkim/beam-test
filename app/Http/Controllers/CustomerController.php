<?php

namespace App\Http\Controllers;

use App\Dto\CustomerDto;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerService $service
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
    public function store(CustomerRequest $request)
    {
        $data = CustomerDto::from($request);
        $result = $this->service->create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Показать конкретного клиента.
     */
    public function show(Customer $customer)
    {
        return response()->json($customer->load(['addresses', 'inn']), Response::HTTP_OK);
    }

    /**
     * Обновить информацию о клиенте.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {

        $data = CustomerDto::from($request);
        $result = $this->service->update($data, $customer);

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Удалить клиента.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }

    public function getCurrantCustomer(Request $request)
    {
        $result = $this->service->getCurrantCustomer($request->ip());
        return response()->json($result, Response::HTTP_OK);
    }
}

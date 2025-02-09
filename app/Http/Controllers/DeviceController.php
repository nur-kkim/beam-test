<?php

namespace App\Http\Controllers;

use App\Dto\DeviceDto;
use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Http\Response;

class DeviceController extends Controller
{
    public function __construct(
        protected DeviceService $service
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
    public function store(DeviceRequest $request)
    {
        $data = DeviceDto::from($request);
        $result = $this->service->create($data);

        return response()->json($result, Response::HTTP_CREATED);
    }

    /**
     * Показать конкретного клиента.
     */
    public function show(Device $device)
    {
        return response()->json($device, Response::HTTP_OK);
    }

    /**
     * Обновить информацию о клиенте.
     */
    public function update(DeviceRequest $request, Device $device)
    {

        $data = DeviceDto::from($request);
        $result = $this->service->update($data, $device);

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * Удалить клиента.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        return response()->json(['message' => 'Device deleted'], Response::HTTP_NO_CONTENT);
    }
}

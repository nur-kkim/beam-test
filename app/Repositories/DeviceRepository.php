<?php

namespace App\Repositories;

use App\Dto\DeviceDto;
use App\Models\Device;
use Illuminate\Support\Facades\DB;

class DeviceRepository
{
    public function __construct(protected Device $device)
    {
    }


    public function index()
    {
        return $this->device->get();
    }

    public function create(DeviceDto $data)
    {
        $device = new $this->device();
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $device->fill($data);
            $device->save();
            DB::commit();
            return $device;
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }


    public function update(DeviceDto $data, $device)
    {
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $device->fill($data);
            $device->save();
            DB::commit();
            return $device;
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

}

<?php

namespace App\Services;


use App\Dto\CustomerDto;
use App\Dto\DeviceDto;
use App\Repositories\CustomerRepository;
use App\Repositories\DeviceRepository;

class DeviceService
{
    public function __construct(
        protected DeviceRepository $repository)
    {
    }

    public function create(DeviceDto $data)
    {
        return $this->repository->create($data);
    }


    public function index()
    {
        return $this->repository->index();
    }

    public function update(DeviceDto $data, $customer)
    {
        return $this->repository->update($data, $customer);
    }
}

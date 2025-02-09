<?php

namespace App\Services;


use App\Dto\CustomerDto;
use App\Repositories\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomerService
{
    public function __construct(
        protected CustomerRepository $repository)
    {
    }

    public function create(CustomerDto $data)
    {
        return $this->repository->create($data);
    }


    public function index()
    {
        return $this->repository->index();
    }

    public function update(CustomerDto $data, $customer)
    {
        return $this->repository->update($data, $customer);
    }

    public function getCurrantCustomer(?string $ip)
    {
        return $this->repository->getCurrantCustomer($ip);
    }
}

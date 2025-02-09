<?php

namespace App\Services;


use App\Dto\OrderDto;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(
        protected OrderRepository $repository)
    {
    }

    public function create(OrderDto $data)
    {
        return $this->repository->create($data);
    }


    public function index()
    {
        return $this->repository->index();
    }

    public function update(OrderDto $data, $customer)
    {
        return $this->repository->update($data, $customer);
    }
}

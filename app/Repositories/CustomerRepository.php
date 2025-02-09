<?php

namespace App\Repositories;

use App\Dto\CustomerDto;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function __construct(protected Customer $account)
    {
    }


    public function index()
    {
        return $this->account->with('addresses', 'inn')->get();
    }

    public function create(CustomerDto $data)
    {
        $account = new $this->account();
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $account->fill($data);
            $account->save();
            if (array_key_exists('inn', $data) && $data['inn']) {
                $account->inn()->create(['inn' => $data['inn']]);
            }
            if (array_key_exists('addresses', $data) && $data['addresses']) {
                $this->createAddressesRelatedToModel($account, $data['addresses']);
            }
            DB::commit();
            return $account->load('addresses', 'inn');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    private function createAddressesRelatedToModel($account, $addresses)
    {
        foreach ($addresses as $address) {
            $account->addresses()->create($address);
        }
    }

    public function update(CustomerDto $data, $customer)
    {
        try {
            $data = $data->toArray();
            DB::beginTransaction();
            $customer->fill($data);
            $customer->save();
            if (array_key_exists('inn', $data) && $data['inn']) {
                $customer->inn()->updateOrCreate(['inn' => $data['inn']]);
            }
            if (array_key_exists('addresses', $data) && $data['addresses']) {
                $this->updateAddressesRelatedToModel($customer, $data['addresses']);
            }
            DB::commit();
            return $customer->load('addresses');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function updateAddressesRelatedToModel($customer, array $addresses)
    {
        collect($addresses)->each(function ($address) use ($customer) {
            $customer->addresses()->updateOrCreate(['id' => $address['id'] ?? null], $address);
        });
    }

    public function getCurrantCustomer(?string $ip)
    {
        return Customer::where('ip', $ip)->with('inn', 'addresses')->first();
    }

}

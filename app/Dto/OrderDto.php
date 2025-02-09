<?php

namespace App\Dto;

use Spatie\LaravelData\Data;

class OrderDto extends Data
{
    public function __construct(
        public int $device_id,
        public ?string $delivery_time,
        public int $address_id
    )
    {
    }
}

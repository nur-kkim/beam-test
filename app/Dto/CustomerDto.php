<?php

namespace App\Dto;

use App\Dto\AddressDto;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class CustomerDto extends Data
{
    public function __construct(
        public string $ip,
        public string $phone_number,
        public ?string $inn,
        public string $name,
        #[DataCollectionOf(AddressDto::class)]
        public null|Lazy|DataCollection $addresses,
    )
    {
    }
}

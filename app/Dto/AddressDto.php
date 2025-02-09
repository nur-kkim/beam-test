<?php

namespace App\Dto;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class AddressDto extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $apartment,
        public string $street,
        public string $house,
        public string $description,
    )
    {
    }
}

<?php

namespace App\Dto;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class DeviceDto extends Data
{
    public function __construct(
        public ?string $description,
        public string $slug,
        public string $name
    )
    {
    }
}

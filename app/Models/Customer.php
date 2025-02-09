<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'phone_number',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function inn()
    {
        return $this->hasOne(CustomerData::class);
    }
}

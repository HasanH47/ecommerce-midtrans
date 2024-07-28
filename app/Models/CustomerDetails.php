<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetails extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'order_id',
        'name',
        'email',
        'phone',
        'address',
    ];
}

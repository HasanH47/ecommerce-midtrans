<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'order_id',
        'total_price',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customerDetails()
    {
        return $this->hasOne(CustomerDetails::class);
    }
}

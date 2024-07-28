<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

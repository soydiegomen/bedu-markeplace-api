<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'SKU',
        'sale_price',
        'list_price',
        'image_url',
        'fecha_fin',
        'is_active'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id', 'purchase_id', 'purchase_item_id', 'login', 'password', 'email', 'is_delivered', 'delivered_at'
    ];
}

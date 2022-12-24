<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountStock extends Model
{
    use HasFactory;

    protected $table = 'account_stocks';

    protected $fillable = [
        'item_id', 'purchase_id', 'purchase_item_id', 'login', 'password', 'email', 'is_delivered', 'delivered_at'
    ];
}

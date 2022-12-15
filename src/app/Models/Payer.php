<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id', 'name', 'document_type', 'document_value', 'bank_name', 'bank_ispb', 'bank_agency',
        'bank_account_number'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}

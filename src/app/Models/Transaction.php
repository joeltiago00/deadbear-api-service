<?php

namespace App\Models;

use App\Types\AddressTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
        'customer_id', 'payment_provider', 'payment_method', 'card_id', 'transaction_provider_id', 'status',
        'status_reason', 'refuse_reason', 'acquirer_response_code', 'acquirer_response_message',
        'authorization_code', 'amount', 'authorized_amount', 'paid_amount', 'refunded_amount', 'postback_url', 'risk_level',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasOne
     */
    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class);
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasOne
     */
    public function billingAddress(): HasOne
    {
        return $this->hasOne(Address::class)->where('type', AddressTypes::BILLING);
    }

    /**
     * @return HasOne
     */
    public function shippingAddress(): HasOne
    {
        return $this->hasOne(Address::class)->where('type', AddressTypes::SHIPPING);
    }
}

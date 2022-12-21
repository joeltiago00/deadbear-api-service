<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('payment_provider', 30);
            $table->string('payment_method', 30);
            $table->string('transaction_provider_id');
            $table->string('status');
            $table->text('refuse_reason')->nullable();
            $table->string('status_reason')->nullable();
            $table->string('acquirer_response_code')->nullable();
            $table->string('acquirer_response_message')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('amount');
            $table->string('authorized_amount');
            $table->string('paid_amount');
            $table->string('refunded_amount')->nullable();
            $table->string('postback_url')->nullable();
            $table->string('risk_level')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

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
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->boolean('is_delivery');
            $table->unsignedBigInteger('billing_id')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('total_price');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
            $table->foreign('billing_id')
                ->references('id')
                ->on('addresses');
            $table->foreign('shipping_id')
                ->references('id')
                ->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};

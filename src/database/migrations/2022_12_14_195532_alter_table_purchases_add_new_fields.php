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
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['billing_id', 'shipping_id']);
            $table->dropColumn(['is_delivery',]);
            $table->dropColumn(['billing_id',]);
            $table->dropColumn(['shipping_id']);
            $table->unsignedBigInteger('customer_id')->after('transaction_id');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id']);

            $table->boolean('is_delivery');
            $table->unsignedBigInteger('billing_id')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();

            $table->foreign('billing_id')
                ->references('id')
                ->on('addresses');
            $table->foreign('shipping_id')
                ->references('id')
                ->on('addresses');
        });
    }
};

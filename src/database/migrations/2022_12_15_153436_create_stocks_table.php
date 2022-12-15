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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('purchase_item_id')->nullable();
            $table->string('login');
            $table->string('password');
            $table->string('email');
            $table->boolean('is_delivered')->nullable();
            $table->timestamp('delivered_at');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases');
            $table->foreign('purchase_item_id')
                ->references('id')
                ->on('purchase_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};

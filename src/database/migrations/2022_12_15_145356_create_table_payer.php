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
        Schema::create('payers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('name');
            $table->string('document_type')->nullable();
            $table->string('document_value')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_ispb')->nullable();
            $table->string('bank_agency')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payers');
    }
};

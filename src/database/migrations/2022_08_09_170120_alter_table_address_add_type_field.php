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
        Schema::table('addresses', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->after('id');

            $table->foreign('type_id')
                ->references('id')
                ->on('address_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn(['type_id']);
        });
    }
};

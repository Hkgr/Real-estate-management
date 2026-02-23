<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_operations', function (Blueprint $table) {
            $table->foreign('property_card_id')
                ->references('id')
                ->on('property_cards')
                ->cascadeOnDelete();
        });

        Schema::table('property_operation_old_owner', function (Blueprint $table) {
            $table->foreign('owner_id')
                ->references('id')
                ->on('owners')
                ->cascadeOnDelete();
        });

        Schema::table('property_operation_new_owner', function (Blueprint $table) {
            $table->foreign('owner_id')
                ->references('id')
                ->on('owners')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('property_operation_new_owner', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
        });

        Schema::table('property_operation_old_owner', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
        });

        Schema::table('property_operations', function (Blueprint $table) {
            $table->dropForeign(['property_card_id']);
        });
    }
};

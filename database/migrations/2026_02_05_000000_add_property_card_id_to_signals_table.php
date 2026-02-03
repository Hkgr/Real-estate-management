<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            $table->foreignId('property_card_id')
                ->nullable()
                ->constrained('property_cards')
                ->nullOnDelete()
                ->after('property_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            $table->dropForeign(['property_card_id']);
            $table->dropColumn('property_card_id');
        });
    }
};

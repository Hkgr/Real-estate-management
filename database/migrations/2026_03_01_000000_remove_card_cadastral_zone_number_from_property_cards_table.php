<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropUnique('property_cards_unique_zone_property');
            $table->dropColumn('card_cadastral_zone_number');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->string('card_cadastral_zone_number', 50);
            $table->unique(['card_cadastral_zone_number', 'card_property_number'], 'property_cards_unique_zone_property');
        });
    }
};

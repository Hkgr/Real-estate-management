<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasColumn = Schema::hasColumn('property_cards', 'card_cadastral_zone_number');
        $indexExists = false;

        if ($hasColumn) {
            $indexExists = !empty(DB::select(
                "SHOW INDEX FROM `property_cards` WHERE Key_name = 'property_cards_unique_zone_property'"
            ));
        }

        Schema::table('property_cards', function (Blueprint $table) use ($hasColumn, $indexExists) {
            if ($indexExists) {
                $table->dropUnique('property_cards_unique_zone_property');
            }

            if ($hasColumn) {
                $table->dropColumn('card_cadastral_zone_number');
            }
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

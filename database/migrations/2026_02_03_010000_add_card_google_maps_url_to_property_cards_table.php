<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_cards', 'card_google_maps_url')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->string('card_google_maps_url', 2048)->nullable()->after('card_property_details');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_cards', 'card_google_maps_url')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropColumn('card_google_maps_url');
            });
        }
    }
};

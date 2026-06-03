<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_cards', 'owned_area_m2')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->decimal('owned_area_m2', 12, 2)
                    ->nullable()
                    ->after('card_total_area');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_cards', 'owned_area_m2')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropColumn('owned_area_m2');
            });
        }
    }
};

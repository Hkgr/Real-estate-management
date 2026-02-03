<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_cards', 'card_record_number')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->string('card_record_number', 50)->nullable()->after('card_region_name');
                $table->unique('card_record_number', 'property_cards_unique_record_number');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_cards', 'card_record_number')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropUnique('property_cards_unique_record_number');
                $table->dropColumn('card_record_number');
            });
        }
    }
};

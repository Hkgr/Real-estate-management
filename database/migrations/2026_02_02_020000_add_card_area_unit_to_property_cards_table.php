<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->enum('card_area_unit', ['percentage', 'shares', 'meters'])
                ->default('meters')
                ->after('card_total_area');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropColumn('card_area_unit');
        });
    }
};

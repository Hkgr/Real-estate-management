<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_cards', 'card_subdivision')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->string('card_subdivision', 100)->nullable()->after('card_region_name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_cards', 'card_subdivision')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropColumn('card_subdivision');
            });
        }
    }
};

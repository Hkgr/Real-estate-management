<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->string('card_investment_type', 50)->nullable()->after('card_status');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropColumn('card_investment_type');
        });
    }
};

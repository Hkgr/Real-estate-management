<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->date('card_sale_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropColumn('card_sale_date');
        });
    }
};

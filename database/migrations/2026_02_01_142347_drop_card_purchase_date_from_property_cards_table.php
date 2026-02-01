<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('property_cards', 'card_purchase_date')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropColumn('card_purchase_date');
            });
        }
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->date('card_purchase_date')->nullable();
        });
    }
};

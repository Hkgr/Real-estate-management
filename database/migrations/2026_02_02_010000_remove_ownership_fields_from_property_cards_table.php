<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropColumn([
                'card_previous_owner',
                'card_owned_area',
                'card_ownership_metric',
                'card_ownership_value',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->string('card_previous_owner')->nullable();
            $table->decimal('card_owned_area', 12, 2);
            $table->enum('card_ownership_metric', ['percentage', 'shares', 'meters'])->default('percentage');
            $table->decimal('card_ownership_value', 12, 2)->nullable();
        });
    }
};

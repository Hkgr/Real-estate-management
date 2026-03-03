<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->decimal('total_property_value_usd', 25, 2)->nullable()->after('owned_property_value_usd');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->dropColumn('total_property_value_usd');
        });
    }
};

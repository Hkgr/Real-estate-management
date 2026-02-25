<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->decimal('abdulqader_sankari_total_shares', 12, 2)->nullable()->after('owned_property_value_usd');
            $table->decimal('riyad_asali_total_shares', 12, 2)->nullable()->after('abdulqader_sankari_total_shares');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->dropColumn([
                'abdulqader_sankari_total_shares',
                'riyad_asali_total_shares',
            ]);
        });
    }
};

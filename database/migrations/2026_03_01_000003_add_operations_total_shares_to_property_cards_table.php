<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->decimal('operations_total_shares', 12, 2)
                ->nullable()
                ->after('total_property_value_usd');
        });
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table): void {
            $table->dropColumn('operations_total_shares');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('property_operations', function (Blueprint $table): void {
            $table->text('contract_notes')->nullable()->after('contract_date');
        });
    }

    public function down(): void
    {
        Schema::table('property_operations', function (Blueprint $table): void {
            $table->dropColumn('contract_notes');
        });
    }
};

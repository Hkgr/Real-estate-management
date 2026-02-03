<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owner_property_card', function (Blueprint $table) {
            $table->enum('purchase_method', ['sale_contract', 'court_judgment'])
                ->nullable()
                ->after('sale_date');
        });
    }

    public function down(): void
    {
        Schema::table('owner_property_card', function (Blueprint $table) {
            $table->dropColumn('purchase_method');
        });
    }
};

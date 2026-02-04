<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_owner_payments', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropIndex('property_owner_payments_owner_id_index');
            $table->dropColumn('owner_id');
        });
    }

    public function down(): void
    {
        Schema::table('property_owner_payments', function (Blueprint $table) {
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->index('owner_id', 'property_owner_payments_owner_id_index');
        });
    }
};

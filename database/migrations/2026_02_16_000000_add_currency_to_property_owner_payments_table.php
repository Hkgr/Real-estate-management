<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_owner_payments', function (Blueprint $table) {
            if (! Schema::hasColumn('property_owner_payments', 'currency')) {
                $table->string('currency', 20)->nullable()->after('balance_movement');
            }
        });
    }

    public function down(): void
    {
        Schema::table('property_owner_payments', function (Blueprint $table) {
            if (Schema::hasColumn('property_owner_payments', 'currency')) {
                $table->dropColumn('currency');
            }
        });
    }
};

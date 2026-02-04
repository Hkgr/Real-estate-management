<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->string('owner_type', 20)->default('individual')->after('full_name');
            $table->string('company_name', 200)->nullable()->after('owner_type');
            $table->string('commercial_register_number', 100)->nullable()->after('company_name');

            $table->index('owner_type');
            $table->index('company_name');
            $table->unique('commercial_register_number', 'owners_commercial_register_number_unique');
        });
    }

    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropUnique('owners_commercial_register_number_unique');
            $table->dropIndex(['owner_type']);
            $table->dropIndex(['company_name']);
            $table->dropColumn(['owner_type', 'company_name', 'commercial_register_number']);
        });
    }
};

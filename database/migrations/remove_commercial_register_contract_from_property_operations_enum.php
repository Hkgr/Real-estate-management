<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function (): void {
            DB::table('property_operations')
                ->where('operation_method', 'commercial_register_contract')
                ->update(['operation_method' => 'regular_contract']);

            DB::statement("ALTER TABLE property_operations MODIFY operation_method ENUM('court_judgment','regular_contract') NOT NULL");
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE property_operations MODIFY operation_method ENUM('court_judgment','regular_contract','commercial_register_contract') NOT NULL");
    }
};

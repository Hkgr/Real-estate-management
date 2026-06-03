<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE `property_cards`
                MODIFY `card_governorate` varchar(100) NULL,
                MODIFY `card_region_name` varchar(191) NULL,
                MODIFY `card_total_area` decimal(12,2) NULL,
                MODIFY `card_area_unit` enum('percentage','shares','meters') NULL DEFAULT NULL,
                MODIFY `card_status` enum('active','frozen') NULL DEFAULT NULL,
                MODIFY `final_balance` decimal(25,2) NULL DEFAULT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE `property_cards`
                MODIFY `card_governorate` varchar(100) NOT NULL,
                MODIFY `card_region_name` varchar(191) NOT NULL,
                MODIFY `card_total_area` decimal(12,2) NOT NULL,
                MODIFY `card_area_unit` enum('percentage','shares','meters') NOT NULL DEFAULT 'meters',
                MODIFY `card_status` enum('active','frozen') NOT NULL DEFAULT 'active',
                MODIFY `final_balance` decimal(25,2) NOT NULL DEFAULT 0.00
        ");
    }
};
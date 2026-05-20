<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->string('property_country', 100)
                ->nullable()
                ->default('سورية')
                ->after('id');

            $table->string('property_name', 191)
                ->nullable()
                ->after('card_record_number');

            $table->decimal('actual_price_usd', 25, 2)
                ->nullable()
                ->after('total_property_value_usd');

            $table->decimal('estimated_price_usd', 25, 2)
                ->nullable()
                ->after('actual_price_usd');

            $table->index('property_country', 'property_cards_property_country_index');
            $table->index('property_name', 'property_cards_property_name_index');
        });

        DB::statement("
            ALTER TABLE property_cards
            MODIFY card_governorate VARCHAR(100)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NULL
        ");
    }

    public function down(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropIndex('property_cards_property_country_index');
            $table->dropIndex('property_cards_property_name_index');

            $table->dropColumn([
                'property_country',
                'property_name',
                'actual_price_usd',
                'estimated_price_usd',
            ]);
        });

        DB::statement("
            ALTER TABLE property_cards
            MODIFY card_governorate VARCHAR(100)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NOT NULL
        ");
    }
};
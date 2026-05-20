<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('property_cards', function (Blueprint $table) {
            $table->enum('property_type', [
                'land',
                'residential',
                'commercial',
            ])
                ->nullable()
                ->default('land')
                ->after('card_total_area');

            $table->string('property_subtype', 50)
                ->nullable()
                ->default('agricultural')
                ->after('property_type');

            $table->index(
                ['property_type', 'property_subtype'],
                'property_cards_property_type_subtype_index'
            );
        });

        DB::statement("
            ALTER TABLE property_cards
            ADD CONSTRAINT property_cards_type_subtype_check
            CHECK (
                property_type IS NULL
                OR property_subtype IS NULL
                OR (
                    property_type = 'land'
                    AND property_subtype IN ('agricultural', 'residential_land')
                )
                OR (
                    property_type = 'residential'
                    AND property_subtype IN ('house', 'villa')
                )
                OR (
                    property_type = 'commercial'
                    AND property_subtype IN ('complex', 'shop', 'mall', 'restaurant', 'other')
                )
            )
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE property_cards
            DROP CHECK property_cards_type_subtype_check
        ");

        Schema::table('property_cards', function (Blueprint $table) {
            $table->dropIndex('property_cards_property_type_subtype_index');

            $table->dropColumn([
                'property_type',
                'property_subtype',
            ]);
        });
    }
};
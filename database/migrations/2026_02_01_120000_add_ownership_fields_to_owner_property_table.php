<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('owner_property', function (Blueprint $table) {
            $table->decimal('ownership_percentage', 5, 2)->after('property_id');
            $table->string('ownership_metric')->after('ownership_percentage');
            $table->boolean('is_current')->default(true)->after('ownership_metric');
            $table->date('purchase_date')->nullable()->after('is_current');
            $table->date('sale_date')->nullable()->after('purchase_date');

            $table->index('owner_id', 'owner_property_owner_id_index');
            $table->index('property_id', 'owner_property_property_id_index');
            $table->dropUnique('owner_property_owner_id_property_id_unique');
            $table->unique(
                [
                    'owner_id',
                    'property_id',
                    'purchase_date',
                    'sale_date',
                    'ownership_percentage',
                    'ownership_metric',
                ],
                'owner_property_ownership_details_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owner_property', function (Blueprint $table) {
            $table->dropUnique('owner_property_ownership_details_unique');
            $table->dropIndex('owner_property_owner_id_index');
            $table->dropIndex('owner_property_property_id_index');
            $table->dropColumn([
                'ownership_percentage',
                'ownership_metric',
                'is_current',
                'purchase_date',
                'sale_date',
            ]);
            $table->unique(['owner_id', 'property_id']);
        });
    }
};

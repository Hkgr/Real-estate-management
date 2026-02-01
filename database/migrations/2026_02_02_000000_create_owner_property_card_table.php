<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owner_property_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->decimal('ownership_percentage', 5, 2);
            $table->string('ownership_metric');
            $table->boolean('is_current')->default(true);
            $table->date('purchase_date')->nullable();
            $table->date('sale_date')->nullable();
            $table->timestamps();

            $table->index('owner_id', 'owner_property_card_owner_id_index');
            $table->index('property_card_id', 'owner_property_card_property_card_id_index');
            $table->unique(
                [
                    'owner_id',
                    'property_card_id',
                    'purchase_date',
                    'sale_date',
                    'ownership_percentage',
                    'ownership_metric',
                ],
                'owner_property_card_ownership_details_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_property_card');
    }
};

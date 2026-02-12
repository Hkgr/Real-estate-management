<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->decimal('amount', 25, 2);
            $table->date('payment_date');
            $table->decimal('remaining_after_payment', 25, 2)->nullable();
            $table->timestamps();

            $table->index('property_card_id', 'property_installments_property_card_id_index');
            $table->index('payment_date', 'property_installments_payment_date_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_installments');
    }
};


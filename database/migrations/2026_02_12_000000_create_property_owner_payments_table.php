<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_owner_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('credit', 12, 2)->default(0);
            $table->string('statement')->nullable();
            $table->string('voucher')->nullable();
            $table->date('payment_date');
            $table->decimal('balance_movement', 12, 2)->default(0);
            $table->timestamps();

            $table->index('property_card_id', 'property_owner_payments_property_card_id_index');
            $table->index('owner_id', 'property_owner_payments_owner_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_owner_payments');
    }
};

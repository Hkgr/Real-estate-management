<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->enum('operation_type', ['sale', 'purchase']);
            $table->decimal('transaction_amount', 14, 2);
            $table->enum('transaction_unit', ['shares', 'square_meter', 'percentage']);
            $table->enum('operation_method', ['court_judgment', 'regular_contract']);
            $table->string('case_number')->nullable();
            $table->string('decision_number')->nullable();
            $table->string('authority')->nullable();
            $table->date('judgment_date')->nullable();
            $table->string('contract_number')->nullable();
            $table->text('contract_notes')->nullable();
            $table->date('contract_date')->nullable();
            $table->timestamps();

            $table->index('property_card_id');
            $table->index('operation_type');
            $table->index('operation_method');
        });

        Schema::create('property_operation_old_owner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_operation_id')->constrained('property_operations')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['property_operation_id', 'owner_id'], 'property_operation_old_owner_unique');
        });

        Schema::create('property_operation_new_owner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_operation_id')->constrained('property_operations')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['property_operation_id', 'owner_id'], 'property_operation_new_owner_unique');
        });

        Schema::create('property_operation_witnesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_operation_id')->constrained('property_operations')->cascadeOnDelete();
            $table->string('witness_name');
            $table->timestamps();

            $table->index('property_operation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_operation_witnesses');
        Schema::dropIfExists('property_operation_new_owner');
        Schema::dropIfExists('property_operation_old_owner');
        Schema::dropIfExists('property_operations');
    }
};

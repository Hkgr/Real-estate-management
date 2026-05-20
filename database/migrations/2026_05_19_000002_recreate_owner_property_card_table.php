<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('owner_property_card')) {
            return;
        }

        Schema::create('owner_property_card', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')
                ->constrained('owners')
                ->cascadeOnDelete();

            $table->foreignId('property_card_id')
                ->constrained('property_cards')
                ->cascadeOnDelete();

            $table->decimal('ownership_percentage', 5, 2);

            $table->string('ownership_metric', 191);

            $table->boolean('is_current')
                ->default(true);

            $table->date('purchase_date')
                ->nullable();

            $table->date('sale_date')
                ->nullable();

            $table->enum('purchase_method', [
                'court_judgment',
                'regular_contract',
                'commercial_register_contract',
            ])->nullable();

            $table->string('case_number', 191)
                ->nullable();

            $table->string('decision_number', 191)
                ->nullable();

            $table->string('authority', 191)
                ->nullable();

            $table->date('judgment_date')
                ->nullable();

            $table->date('regular_contract_date')
                ->nullable();

            $table->string('contract_number', 191)
                ->nullable();

            $table->date('commercial_contract_date')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_property_card');
    }
};
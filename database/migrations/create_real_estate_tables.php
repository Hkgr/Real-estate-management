<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('governorate_name')->nullable();
            $table->string('previous_owner_name')->nullable();
            $table->string('region_name');
            $table->string('cadastral_zone_number', 50);
            $table->string('property_number', 50);
            $table->decimal('total_area', 12, 2);
            $table->decimal('owned_area', 12, 2);
            $table->date('purchase_date');
            $table->decimal('ownership_percentage', 5, 2);
            $table->enum('status', ['active', 'frozen'])->default('active');
            $table->text('location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('region_name');
            $table->index('property_number');
            $table->index('governorate_name');
            $table->index('status');
            $table->unique(['cadastral_zone_number', 'property_number']);
        });

        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 200);
            $table->date('birth_date')->nullable();
            $table->string('national_id', 50)->unique();
            $table->string('phone', 50)->nullable();
            $table->string('email', 150)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('full_name');
            $table->index('phone');
        });

        Schema::create('reservation_notices', function (Blueprint $table) {
            $table->id();
            $table->string('notice_number', 50)->unique();
            $table->date('notice_date');
            $table->string('property_number', 50);
            $table->string('issued_by', 150)->nullable();
            $table->string('party_name', 150)->nullable();
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 30)->default('active');
            $table->date('release_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('property_number');
            $table->index('status');
        });

        Schema::create('property_cards', function (Blueprint $table) {
            $table->id();
            $table->string('card_governorate', 100);
            $table->string('card_region_name');
            $table->string('card_subdivision', 100)->nullable();
            $table->string('card_record_number', 50)->nullable();
            $table->decimal('card_total_area', 12, 2);
            $table->enum('card_area_unit', ['percentage', 'shares', 'meters'])->default('meters');
            $table->text('card_property_details')->nullable();
            $table->enum('card_status', ['active', 'frozen'])->default('active');
            $table->string('card_investment_type', 50)->nullable();
            $table->string('card_purchase_method')->nullable();
            $table->string('card_google_maps_url', 2048)->nullable();
            $table->date('card_sale_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['card_governorate', 'card_region_name']);
            $table->unique('card_record_number', 'property_cards_unique_record_number');
        });

        Schema::create('owner_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->decimal('ownership_percentage', 5, 2);
            $table->string('ownership_metric');
            $table->boolean('is_current')->default(true);
            $table->date('purchase_date')->nullable();
            $table->date('sale_date')->nullable();
            $table->timestamps();

            $table->index('owner_id', 'owner_property_owner_id_index');
            $table->index('property_id', 'owner_property_property_id_index');
            $table->unique([
                'owner_id',
                'property_id',
                'purchase_date',
                'sale_date',
                'ownership_percentage',
                'ownership_metric',
            ], 'owner_property_ownership_details_unique');
        });

        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->string('signal_id', 100);
            $table->date('signal_date')->nullable();
            $table->string('type', 50);
            $table->string('signal_owner', 200)->nullable();
            $table->json('signal_owners')->nullable();
            $table->string('signal_source', 200)->nullable();
            $table->json('signal_sources')->nullable();
            $table->string('signal_source_number', 50)->nullable();
            $table->date('signal_source_date')->nullable();
            $table->string('signal_victim', 200)->nullable();
            $table->json('signal_victims')->nullable();
            $table->foreignId('property_id')->nullable()->constrained('properties')->nullOnDelete();
            $table->foreignId('property_card_id')->nullable()->constrained('property_cards')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('owner_signal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('signal_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['owner_id', 'signal_id']);
        });

        Schema::create('owner_property_card', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->decimal('ownership_percentage', 5, 2);
            $table->string('ownership_metric');
            $table->boolean('is_current')->default(true);
            $table->date('purchase_date')->nullable();
            $table->date('sale_date')->nullable();
            $table->enum('purchase_method', ['court_judgment', 'regular_contract', 'commercial_register_contract'])->nullable();
            $table->string('case_number')->nullable();
            $table->string('decision_number')->nullable();
            $table->string('authority')->nullable();
            $table->date('judgment_date')->nullable();
            $table->date('regular_contract_date')->nullable();
            $table->string('contract_number')->nullable();
            $table->date('commercial_contract_date')->nullable();
            $table->timestamps();

            $table->index('owner_id', 'owner_property_card_owner_id_index');
            $table->index('property_card_id', 'owner_property_card_property_card_id_index');
            $table->unique([
                'owner_id',
                'property_card_id',
                'purchase_date',
                'sale_date',
                'ownership_percentage',
                'ownership_metric',
            ], 'owner_property_card_ownership_details_unique');
        });

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
            $table->string('currency', 20)->nullable();
            $table->timestamps();

            $table->index('property_card_id', 'property_owner_payments_property_card_id_index');
            $table->index('owner_id', 'property_owner_payments_owner_id_index');
        });

        Schema::create('property_card_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_card_id')->constrained('property_cards')->cascadeOnDelete();
            $table->string('file_name');
            $table->date('issued_at');
            $table->string('storage_disk');
            $table->string('storage_path');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->timestamps();

            $table->index('property_card_id', 'property_card_files_property_card_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_card_files');
        Schema::dropIfExists('property_owner_payments');
        Schema::dropIfExists('owner_property_card');
        Schema::dropIfExists('owner_signal');
        Schema::dropIfExists('signals');
        Schema::dropIfExists('owner_property');
        Schema::dropIfExists('property_cards');
        Schema::dropIfExists('reservation_notices');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('properties');
    }
};

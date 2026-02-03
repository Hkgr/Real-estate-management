<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }
};

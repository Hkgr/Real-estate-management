<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('owner_signal')) {
            return;
        }

        Schema::create('owner_signal', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')
                ->constrained('owners')
                ->cascadeOnDelete();

            $table->foreignId('signal_id')
                ->constrained('signals')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_signal');
    }
};
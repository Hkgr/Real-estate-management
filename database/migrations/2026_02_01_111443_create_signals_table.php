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
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->string('signal_id', 100);
            $table->string('signal_year', 4);
            $table->date('signal_date')->nullable();
            $table->enum('type', ['حجز ', 'دعوة', 'استيفاء رسوم', 'إنذار', 'استملاك']);
            $table->string('signal_owner', 200)->nullable();
            $table->string('signal_source', 200)->nullable();
            $table->string('signal_victim', 200)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signals');
    }
};

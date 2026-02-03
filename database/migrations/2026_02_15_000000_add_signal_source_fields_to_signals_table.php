<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            $table->string('signal_source_number', 50)->nullable()->after('signal_source');
            $table->date('signal_source_date')->nullable()->after('signal_source_number');
        });
    }

    public function down(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            $table->dropColumn(['signal_source_number', 'signal_source_date']);
        });
    }
};

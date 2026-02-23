<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_operations', 'judgment_notes')) {
            Schema::table('property_operations', function (Blueprint $table) {
                $table->text('judgment_notes')->nullable()->after('judgment_date');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_operations', 'judgment_notes')) {
            Schema::table('property_operations', function (Blueprint $table) {
                $table->dropColumn('judgment_notes');
            });
        }
    }
};

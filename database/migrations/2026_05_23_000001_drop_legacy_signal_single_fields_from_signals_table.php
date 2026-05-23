<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columnsToDrop = [
        'signal_owner',
        'signal_victim',
        'signal_source',
        'signal_source_number',
    ];

    public function up(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            foreach ($this->columnsToDrop as $column) {
                if (Schema::hasColumn('signals', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            if (! Schema::hasColumn('signals', 'signal_owner')) {
                $table->string('signal_owner')->nullable()->after('type');
            }

            if (! Schema::hasColumn('signals', 'signal_victim')) {
                $table->string('signal_victim')->nullable()->after('signal_owners');
            }

            if (! Schema::hasColumn('signals', 'signal_source')) {
                $table->string('signal_source')->nullable()->after('signal_victims');
            }

            if (! Schema::hasColumn('signals', 'signal_source_number')) {
                $table->string('signal_source_number')->nullable()->after('signal_sources');
            }
        }); 
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('signals', 'signal_date')) {
            Schema::table('signals', function (Blueprint $table) {
                $table->date('signal_date')->nullable()->after('signal_year');
            });
        }

        if (! Schema::hasColumn('signals', 'signal_year')) {
            return;
        }

        DB::table('signals')
            ->select(['id', 'signal_year'])
            ->whereNull('signal_date')
            ->whereNotNull('signal_year')
            ->orderBy('id')
            ->chunkById(200, function ($signals) {
                foreach ($signals as $signal) {
                    $year = trim((string) $signal->signal_year);

                    if (! preg_match('/^\d{4}$/', $year)) {
                        continue;
                    }

                    DB::table('signals')
                        ->where('id', $signal->id)
                        ->update(['signal_date' => Carbon::createFromDate((int) $year, 1, 1)->toDateString()]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('signals', 'signal_date')) {
            Schema::table('signals', function (Blueprint $table) {
                $table->dropColumn('signal_date');
            });
        }
    }
};

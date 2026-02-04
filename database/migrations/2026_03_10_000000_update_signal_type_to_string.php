<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE signals MODIFY type VARCHAR(50)');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE signals ALTER COLUMN type TYPE VARCHAR(50)');
        }

        DB::table('signals')->update([
            'type' => DB::raw('TRIM(type)'),
        ]);
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            DB::statement(
                "ALTER TABLE signals MODIFY type ENUM('حجز', 'دعوة', 'استيفاء رسوم', 'إنذار', 'استملاك')"
            );
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE signals ALTER COLUMN type TYPE VARCHAR(50)');
        }
    }
};

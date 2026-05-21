<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->string('father_name', 191)
                ->nullable()
                ->after('full_name');

            $table->string('real_estate_record_number', 100)
                ->nullable()
                ->after('father_name');

            $table->index('father_name', 'owners_father_name_index');
            $table->index('real_estate_record_number', 'owners_real_estate_record_number_index');
        });

        DB::statement("
            ALTER TABLE owners
            MODIFY owner_type VARCHAR(20)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NULL
        ");

        DB::statement("
            ALTER TABLE owners
            MODIFY birth_date DATE NULL
        ");
    }

    public function down(): void
    {
        Schema::table('owners', function (Blueprint $table) {
            $table->dropIndex('owners_father_name_index');
            $table->dropIndex('owners_real_estate_record_number_index');

            $table->dropColumn([
                'father_name',
                'real_estate_record_number',
            ]);
        });

        DB::statement("
            ALTER TABLE owners
            MODIFY owner_type VARCHAR(20)
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            NOT NULL DEFAULT 'individual'
        ");

        DB::statement("
            ALTER TABLE owners
            MODIFY birth_date DATE NULL
        ");
    }
};
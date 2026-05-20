<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tablesToDrop = [
        'model_has_permissions',
        'owner_property',
        'owner_property_card',
        'owner_signal',
        'role_has_permissions',
        'property_owner_payments',
        'reservation_notices',
        'properties',
        'permissions',
    ];

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            /*
             * نحذف أي foreign key من جداول ستبقى في النظام
             * لكنها تشير إلى جداول سنحذفها.
             *
             * مثال عندك:
             * signals.property_id -> properties.id
             */
            $placeholders = implode(',', array_fill(0, count($this->tablesToDrop), '?'));

            $foreignKeys = DB::select("
                SELECT DISTINCT
                    TABLE_NAME,
                    CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE CONSTRAINT_SCHEMA = DATABASE()
                  AND REFERENCED_TABLE_NAME IN ($placeholders)
                  AND TABLE_NAME NOT IN ($placeholders)
                  AND REFERENCED_TABLE_NAME IS NOT NULL
            ", array_merge($this->tablesToDrop, $this->tablesToDrop));

            foreach ($foreignKeys as $foreignKey) {
                DB::statement(sprintf(
                    'ALTER TABLE %s DROP FOREIGN KEY %s',
                    $this->quoteIdentifier($foreignKey->TABLE_NAME),
                    $this->quoteIdentifier($foreignKey->CONSTRAINT_NAME)
                ));
            }

            foreach ($this->tablesToDrop as $table) {
                Schema::dropIfExists($table);
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    public function down(): void
    {
        throw new RuntimeException(
            'This migration permanently deleted selected tables. Restore a database backup to recover them.'
        );
    }

    private function quoteIdentifier(string $identifier): string
    {
        return '`' . str_replace('`', '``', $identifier) . '`';
    }
};
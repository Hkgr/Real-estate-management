<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('property_cards', 'card_purchase_method')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->string('card_purchase_method')->nullable()->after('card_investment_type');
            });
        }

        if (Schema::hasColumn('owner_property_card', 'purchase_method')) {
            $ownerships = DB::table('owner_property_card')
                ->select('property_card_id', 'purchase_method')
                ->whereNotNull('purchase_method')
                ->orderBy('id')
                ->get()
                ->groupBy('property_card_id');

            foreach ($ownerships as $propertyCardId => $rows) {
                $purchaseMethod = $rows->first()->purchase_method ?? null;

                if ($purchaseMethod === null) {
                    continue;
                }

                DB::table('property_cards')
                    ->where('id', $propertyCardId)
                    ->whereNull('card_purchase_method')
                    ->update(['card_purchase_method' => $purchaseMethod]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('property_cards', 'card_purchase_method')) {
            Schema::table('property_cards', function (Blueprint $table) {
                $table->dropColumn('card_purchase_method');
            });
        }
    }
};

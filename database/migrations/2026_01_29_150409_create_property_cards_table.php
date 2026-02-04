<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_cards', function (Blueprint $table) {
            $table->id();

            // أسماء مختلفة عن القديم (كلها تبدأ card_)
            $table->string('card_governorate', 100);                // المحافظة
            $table->string('card_previous_owner')->nullable();      // المالك السابق

            $table->string('card_region_name');
                        $table->string('card_subdivision', 100)->nullable();    // المقسم                     // اسم المنطقة

            $table->decimal('card_total_area', 12, 2);              // مساحة العقار الكلية
            $table->decimal('card_owned_area', 12, 2);              // المساحة المملوكة
            $table->date('card_purchase_date')->nullable(); 
                        $table->text('card_property_details')->nullable();      // تفصيل العقار        // تاريخ الشراء

            // حالة العقار: مجمد/فاعل
            $table->enum('card_status', ['active', 'frozen'])->default('active');

            // مقياس الملكية: نسبة/أسهم/أمتار + قيمة واحدة
            $table->enum('card_ownership_metric', ['percentage', 'shares', 'meters'])->default('percentage');
            $table->decimal('card_ownership_value', 12, 2)->nullable();

            $table->string('card_google_maps_url', 2048)->nullable(); // رابط خريطة Google

            $table->timestamps();
            $table->softDeletes();

            $table->index(['card_governorate', 'card_region_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_cards');
    }
};

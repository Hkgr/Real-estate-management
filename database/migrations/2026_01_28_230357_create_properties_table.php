<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // جديد
            $table->string('governorate_name')->nullable();      // المحافظة
            $table->string('previous_owner_name')->nullable();   // المالك السابق

            // موجود سابقاً
            $table->string('region_name');                 // اسم المنطقة

            $table->decimal('total_area', 12, 2);          // مساحة العقار الكلية
            $table->decimal('owned_area', 12, 2);          // المساحة المملوكة
            $table->date('purchase_date');                 // تاريخ الشراء

            // جديد: حالة العقار
            $table->enum('status', ['active', 'frozen'])->default('active'); // فاعل/مجمد

            // جديد: نظام الملكية (وحدة + قيمة)
            $table->enum('ownership_unit', ['percent', 'shares', 'meters'])->default('percent');
            $table->decimal('ownership_value', 12, 2); // % أو أسهم أو م² حسب ownership_unit

            $table->text('location');                      // موقع العقار (عنوان/وصف)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // فهارس وقيود
            $table->index('region_name');
            $table->index('governorate_name');
            $table->index('status');
            $table->index('ownership_unit');

            $table->unique(['cadastral_zone_number', 'property_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

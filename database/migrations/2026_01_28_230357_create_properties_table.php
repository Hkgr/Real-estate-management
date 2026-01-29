<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            $table->string('region_name');                 // اسم المنطقة
            $table->string('cadastral_zone_number', 50);   // رقم المنطقة العقارية
            $table->string('property_number', 50);         // رقم العقار

            $table->decimal('total_area', 12, 2);          // مساحة العقار الكلية
            $table->decimal('owned_area', 12, 2);          // المساحة المملوكة
            $table->date('purchase_date');                 // تاريخ الشراء
            $table->decimal('ownership_percentage', 5, 2); // نسبة الملكية 0..100

            $table->text('location');                      // موقع العقار (عنوان/وصف)
            // اختياري (GPS):
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // مثال قيود مفيدة:
            $table->index('region_name');
            $table->unique(['cadastral_zone_number', 'property_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

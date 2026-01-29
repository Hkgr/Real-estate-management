<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservation_notices', function (Blueprint $table) {
            $table->id();

            $table->string('notice_number', 50)->unique();     // رقم الإشارة
            $table->date('notice_date');                       // تاريخ الإشارة

            // حالياً بدون علاقات: نخزّن رقم العقار كنص
            $table->string('property_number', 50);             // رقم العقار

            $table->string('issued_by', 150)->nullable();      // الجهة المُصدِرة
            $table->string('party_name', 150)->nullable();     // صاحب العلاقة (اختياري)
            $table->text('reason')->nullable();                // السبب/الوصف
            $table->text('notes')->nullable();                 // ملاحظات

            $table->string('status', 30)->default('active');   // active / released / canceled
            $table->date('release_date')->nullable();          // تاريخ فك الحجز (إن وجد)

            $table->timestamps();
            $table->softDeletes();

            $table->index('property_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservation_notices');
    }
};

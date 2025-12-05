<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels_chalets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity');
            $table->integer('room_size')->nullable()->comment('حجم الغرفة بالمتر المربع');
            $table->integer('beds')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->boolean('has_breakfast')->default(false);
            $table->boolean('is_available')->default(true);
            $table->integer('max_adults')->default(2);
            $table->integer('max_children')->default(0);
            $table->json('amenities')->nullable()->comment('وسائل الراحة المتاحة');
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // تعطيل فحص المفاتيح الأجنبية مؤقتاً
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        
        Schema::dropIfExists('hotels_chalets');
        
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
};

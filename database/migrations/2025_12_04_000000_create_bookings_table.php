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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->foreignId('hotel_chalet_id')->constrained('hotels_chalets')->onDelete('cascade');
            $table->string('booking_reference')->unique();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('adults');
            $table->integer('children')->nullable();
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'no_show'])->default('pending');
            $table->decimal('total_price', 10, 2);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'partially_refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['hotel_id', 'check_in_date', 'check_out_date']);
            $table->index(['check_in_date', 'check_out_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

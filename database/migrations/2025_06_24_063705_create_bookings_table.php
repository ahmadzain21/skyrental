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
            $table->unsignedBigInteger('iphone_id');
            $table->unsignedBigInteger('payment_id')->nullable();

            $table->string('booking_code', 20)->unique()->nullable();
            
            // Data penyewa non-login
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->decimal('price', 12, 2)->default(0.00);

            $table->date('requested_booking_date')->nullable();
            $table->time('requested_time')->nullable();

            // Waktu & durasi
            $table->date('start_booking_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('end_booking_date')->nullable();
            $table->time('end_time')->nullable();

            $table->boolean('reminder_sent')->default(false);
            
            $table->integer('duration');
            $table->timestamp('created');

            $table->foreign('iphone_id')->references('id')->on('iphones')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->enum('status', ['pending', 'confirmed', 'returned', 'cancelled'])->default('pending');
            $table->timestamps();
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

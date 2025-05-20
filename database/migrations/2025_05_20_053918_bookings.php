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
            $table->id("id_booking");
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_konsol');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('id_konsol')->references('id_konsol')->on('consoles');
            $table->date('start_time');
            $table->date('end_time');
            $table->enum('status', ['booked', 'ongoing','completed','cancelled']);
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

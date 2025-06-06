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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id("id_pesanan");
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger("id_aksesoris");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("id_aksesoris")->references("id_aksesoris")->on("accesories");
            $table->integer('quantity')->default(1);
            $table->bigInteger("jumlah_pembayaran");
            $table->string("snap_token")->nullable();
            $table->enum('status', ['Pending','Paid', 'cancelled'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};

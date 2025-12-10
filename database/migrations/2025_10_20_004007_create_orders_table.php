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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('magazine_id')->constrained('magazines');
            // $table->foreignId('cart_id')->constrained('carts');//abaikan

            // Data pembelian
            // $table->integer('quantity')->default(1);//abaikan
            $table->integer('total_price');
            $table->text('purchase_history')->nullable(); // bisa diisi riwayat detail
            // $table->string('payment');        // metode pembayaran (misal: 'credit_card', 'cash')

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

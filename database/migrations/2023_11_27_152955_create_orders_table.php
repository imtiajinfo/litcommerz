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
            $table->integer('user_id');
            $table->integer('total_product');
            $table->integer('payment_status');
            $table->double('payeble_amount', 8, 2);
            $table->double('total_amount', 8, 2);
            $table->double('discount', 8, 2);
            $table->double('coupon', 8, 2);
            $table->double('shipping_amount', 8, 2);
            $table->double('collect_amount', 8, 2);
            $table->double('due_amount', 8, 2);
            $table->timestamps();
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

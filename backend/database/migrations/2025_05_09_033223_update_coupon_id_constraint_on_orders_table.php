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
        Schema::table('orders', function (Blueprint $table) {
            // First drop the existing foreign key
            $table->dropForeign(['coupon_id']);

            // Then add the new foreign key with nullOnDelete()
            $table->foreign('coupon_id')->references('id')->on('coupons')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert to previous behavior (cascadeOnDelete)
            $table->dropForeign(['coupon_id']);
            $table->foreign('coupon_id')->references('id')->on('coupons')->cascadeOnDelete();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_details', 'payment_status']);
        });
    }
};
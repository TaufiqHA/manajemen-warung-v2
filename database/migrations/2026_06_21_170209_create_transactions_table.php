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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warung_id')->constrained('warungs')->cascadeOnDelete(); // Asumsikan ada tabel warung
            $table->foreignId('cashier_id')->constrained('users'); // Asumsikan kasir adalah entitas user
            $table->string('transaction_code', 50)->unique();
            $table->string('customer_name')->nullable();
            $table->bigInteger('total_amount');
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('tax_amount')->default(0);
            $table->bigInteger('grand_total');
            $table->enum('payment_method', ['CASH', 'TRANSFER', 'QRIS']);
            $table->bigInteger('paid_amount');
            $table->bigInteger('change_amount')->default(0);
            $table->string('status', 50)->default('PENDING');
            $table->text('note')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

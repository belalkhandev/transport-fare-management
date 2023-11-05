<?php

use App\Enums\PaymentGateway;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_billing_id')->constrained('transport_billings')->cascadeOnDelete();
            $table->string('trans_id')->unique();
            $table->string('gateway')->nullable();
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_trans_id')->nullable();
            $table->string('currency')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->date('transaction_date')->nullable();
            $table->enum('status', PaymentStatus::values())->default(PaymentStatus::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};

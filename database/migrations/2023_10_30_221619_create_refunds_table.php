<?php

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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->string('gateway_payment_id')->nullable();
            $table->string('refund_trans_id')->nullable();
            $table->string('refunded_to')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->double('charge', 8, 2)->nullable();
            $table->enum('status', ['processing', 'refunded']);
            $table->text('note')->nullable();
            $table->dateTime('process_initiated_at')->nullable();
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
        Schema::dropIfExists('refunds');
    }
};

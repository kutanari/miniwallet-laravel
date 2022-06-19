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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->tinyInteger('type');
            $table->uuid('wallet_id');
            $table->tinyInteger('status');
            $table->uuid('owned_by');
            $table->uuid('reference_id');
            $table->decimal('amount_from', 15, 0);
            $table->decimal('amount_to', 15, 0);
            $table->timestamps();

            $table->unique(['owned_by', 'wallet_id', 'reference_id']);
            $table->foreign('owned_by')->references('customer_xid')->on('accounts')->onDelete('cascade');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

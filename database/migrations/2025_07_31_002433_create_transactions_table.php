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
            $table->unsignedBigInteger('wh_id');  // Warehouse ID
            $table->unsignedBigInteger('m_id');   // Material ID
            $table->integer('qty');               // Quantity
            $table->tinyInteger('type')->comment('0: out, 1: in'); // Transaction type
            $table->integer('price');             // Price per unit
            $table->unsignedBigInteger('user_id'); // User who created the transaction
            $table->softDeletes();
            $table->timestamps();
            // Foreign Keys
            $table->foreign('wh_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('m_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

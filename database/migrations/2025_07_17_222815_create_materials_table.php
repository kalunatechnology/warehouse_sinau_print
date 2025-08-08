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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('m_code')->unique();
            $table->string('m_name')->unique();
            $table->integer('m_price');
            $table->string('m_type');
            $table->string('m_supplier');
            $table->unsignedBigInteger('unit_id');
            $table->string('unit_detail');
            $table->double('conversion', 10, 2);
            $table->integer('m_limit');
            $table->double('waste')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};

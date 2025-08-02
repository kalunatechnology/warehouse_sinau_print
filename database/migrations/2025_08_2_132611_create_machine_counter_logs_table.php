<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('machine_counter_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('machine_id');
            $table->integer('counter_before');
            $table->integer('counter_after');
            $table->unsignedBigInteger('changed_by');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('machine_id')
                  ->references('id')->on('machines')
                  ->onDelete('cascade');

            $table->foreign('changed_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->index('machine_id');
            $table->index('changed_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('machine_counter_logs');
    }
};

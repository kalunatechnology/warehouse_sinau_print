<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('machine_counters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('machine_id');
            $table->integer('counter');
            $table->timestamp('recorded_at')->useCurrent();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('machine_id')
                  ->references('id')
                  ->on('machines')
                  ->onDelete('cascade');

            $table->index('machine_id', 'machine_counters_machine_id_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('machine_counters');
    }
};

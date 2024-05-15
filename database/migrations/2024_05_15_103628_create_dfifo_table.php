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
        Schema::create('dfifo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hfifo_id');
            $table->unsignedBigInteger('hpurchase_id');
            $table->unsignedBigInteger('dpurchase_id');
            $table->string('part');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->bigInteger('profit_each');
            $table->bigInteger('profit_total');
            $table->integer('qty');
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
        Schema::dropIfExists('dfifo');
    }
};

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
        Schema::create('hfifo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hpurchase_id');
            $table->unsignedBigInteger('dpurchase_id');
            $table->string('part');
            $table->bigInteger('harga_beli');
            $table->bigInteger('qty_max');
            $table->bigInteger('qty_used');
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
        Schema::dropIfExists('hfifo');
    }
};

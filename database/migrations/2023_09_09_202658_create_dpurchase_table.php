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
        Schema::create('dpurchase', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hpurchase_id');
            $table->string('part');
            $table->string('nama');
            $table->bigInteger('harga');
            $table->bigInteger('qty');
            $table->bigInteger('subtotal');
            $table->timestamps();

            $table->foreign('hpurchase_id')->references('id')->on('hpurchase')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dpurchase');
    }
};

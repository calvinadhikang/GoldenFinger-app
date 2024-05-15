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
        Schema::create('dinvoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hinvoice_id');
            $table->string('part');
            $table->string('nama');
            $table->decimal('harga', 20, 2);
            $table->decimal('subtotal', 20, 2);
            $table->bigInteger('qty');
            $table->timestamps();

            $table->foreign('hinvoice_id')->references('id')->on('hinvoice')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dinvoice');
    }
};

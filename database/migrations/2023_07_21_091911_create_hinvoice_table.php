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
        Schema::create('hinvoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('kode');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('karyawan_id');
            $table->bigInteger('total');
            $table->bigInteger('ppn');
            $table->bigInteger('grand_total');
            $table->integer('status');
            $table->timestamp('jatuh_tempo');
            $table->text('contact_person');
            $table->bigInteger('komisi');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
            $table->unique('kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hinvoice');
    }
};

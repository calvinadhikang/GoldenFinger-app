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
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('nama');
            $table->integer('harga');
            $table->text('cancel_reason')->nullable();
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->timestamp('will_finish_at');
            $table->timestamp('taken_at')->nullable();
            $table->string('taken_by')->nullable();
            $table->unsignedBigInteger('handled_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('machine_id')->references('id')->on('vulkanisir_machine')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
            $table->foreign('canceled_by')->references('id')->on('karyawan')->onDelete('cascade');
            $table->foreign('handled_by')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
};

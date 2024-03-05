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
        Schema::create('hpurchase', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('karyawan_id');
            $table->decimal('total', 20, 2);
            $table->decimal('grand_total', 20, 2);
            $table->decimal('ppn_value', 20, 2);
            $table->bigInteger('ppn');
            $table->timestamp('jatuh_tempo')->nullable();
            $table->timestamp('recieved_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('paid_by')->nullable();
            $table->unsignedBigInteger('recieved_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hpurchase');
    }
};

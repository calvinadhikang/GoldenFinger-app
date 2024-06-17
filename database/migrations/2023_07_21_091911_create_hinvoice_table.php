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
            $table->string('kode');
            $table->text('surat_jalan');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('karyawan_id')->nullable();
            $table->decimal('total', 20, 2);
            $table->decimal('grand_total', 20, 2);
            $table->decimal('ppn_value', 20, 2);
            $table->bigInteger('ppn');
            $table->text('contact_person');
            $table->text('po');
            $table->bigInteger('komisi');
            $table->timestamp('jatuh_tempo')->nullable();
            $table->timestamps();
            $table->integer('status');
            // 0 = Butuh Konfirmasi 1 = Konfirmasi, 2 = Terbayar

            $table->timestamp('confirmed_at')->nullable();
            $table->unsignedBigInteger('confirmed_by')->nullable();

            $table->timestamp('paid_at')->nullable(); //Menunjukan pembayaran lunas saat kap
            $table->decimal('paid_total', 20, 2)->default(0);

            // Cancel Reason
            $table->text('cancel_reason')->nullable();
            $table->unsignedBigInteger('cancel_by')->nullable();

            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('customer_id')->references('id')->on('customer');
            $table->foreign('karyawan_id')->references('id')->on('karyawan');
            $table->unique('kode');
            $table->string('snap_token')->nullable();
            $table->string('penawaran_id')->nullable();
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

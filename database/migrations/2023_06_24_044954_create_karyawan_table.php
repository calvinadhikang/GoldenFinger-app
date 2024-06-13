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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('username');
            $table->text('password');
            $table->string('telp');
            $table->enum('role', ['Admin', 'Teknisi', 'Pemilik']);
            $table->boolean('is_shareholder')->default(false);
            $table->decimal('shares', 20, 2)->default(0);
            $table->enum('status', ['Aktif', 'Non-Aktif']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
};

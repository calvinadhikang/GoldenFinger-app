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
        Schema::create('stock_mutation', function (Blueprint $table) {
            $table->id();
            $table->string('barang_id');
            $table->integer('quantity');
            $table->decimal('harga', 10, 2);
            $table->enum('status', ['masuk', 'keluar']);
            $table->timestamps();

            $table->foreign('barang_id')->references('part')->on('barang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_mutation');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('invoice_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('last_year');
            $table->integer('last_month');
            $table->integer('data_count')->default(1);
            $table->timestamps();
        });

        DB::table('invoice_setting')->insert([
            'last_year' => date('y'),
            'last_month' => date('m'),
            'data_count' => 0, // You can set this to the desired initial value
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_setting');
    }
};

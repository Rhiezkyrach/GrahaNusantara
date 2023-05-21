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
        Schema::create('tbl_wartawan', function (Blueprint $table) {
            $table->id('id_wartawan');
            $table->string('nama_wartawan');
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('quotes')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('tbl_wartawan');
    }
};

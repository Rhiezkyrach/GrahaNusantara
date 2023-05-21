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
        Schema::create('tbl_iklan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->string('posisi');
            $table->string('AE')->nullable();
            $table->string('foto')->nullable();
            $table->tinyInteger('status');
            $table->text('kode')->nullable();
            $table->string('link')->nullable();
            $table->integer('urutan');
            $table->timestamp('awal_tayang');
            $table->timestamp('akhir_tayang');
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
        Schema::dropIfExists('tbl_iklan');
    }
};

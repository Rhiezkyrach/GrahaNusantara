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
        Schema::create('tbl_berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->foreignId('id_channel');
            $table->integer('id_categories')->nullable();
            $table->string('penulis');
            $table->string('oleh')->nullable();
            $table->string('foto_penulis')->nullable();
            $table->string('wartawan');
            $table->foreignId('id_wartawan');
            $table->date('tanggal_tayang');
            $table->time('waktu');
            $table->longText('isi');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('judul_atas')->nullable();
            $table->string('sub_judul')->nullable();
            $table->boolean('headline')->default(0);
            $table->boolean('publish')->default(0);
            $table->string('tag');
            $table->string('gambar_detail');
            $table->string('fokus')->nullable();
            $table->string('caption');
            $table->bigInteger('counter')->default(0);
            $table->string('video')->nullable();
            $table->text('kode_embed')->nullable();
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
        Schema::dropIfExists('tbl_berita');
    }
};

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
            $table->string('id_network', 4)->nullable();
            $table->foreignId('id_user')->nullable();
            $table->foreignId('id_kategori')->nullable();
            $table->foreignId('id_fokus')->nullable();
            $table->string('penulis');
            $table->string('oleh')->nullable();
            $table->string('foto_penulis')->nullable();
            $table->foreignId('id_wartawan');
            $table->string('wartawan');
            $table->date('tanggal_tayang');
            $table->time('waktu');
            $table->text('isi');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('judul_atas')->nullable();
            $table->string('sub_judul')->nullable();
            $table->boolean('headline')->default(0);
            $table->boolean('publish')->default(0);
            $table->string('tag')->nullable();
            $table->string('gambar_detail')->nullable();
            $table->string('caption')->nullable();
            $table->bigInteger('counter')->default(0);
            $table->string('video')->nullable();
            $table->text('kode_embed')->nullable();
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
        Schema::dropIfExists('tbl_berita');
    }
};

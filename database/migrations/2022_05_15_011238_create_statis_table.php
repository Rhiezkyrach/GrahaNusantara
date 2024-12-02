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
        Schema::create('tbl_statis', function (Blueprint $table) {
            $table->id('id_statis');
            $table->string('id_network', 4)->nullable();
            $table->integer('urutan');
            $table->longText('isi');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('gambar_detail')->nullable();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('tbl_statis');
    }
};

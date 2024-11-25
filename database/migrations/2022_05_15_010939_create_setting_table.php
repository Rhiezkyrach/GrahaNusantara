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
        Schema::create('tbl_setting', function (Blueprint $table) {
            $table->id();
            $table->string('id_network', 4)->nullable();
            $table->string('judul_situs');
            $table->string('tagline');
            $table->string('deskripsi');
            $table->text('keyword')->nullable();
            $table->string('logo')->nullable();
            $table->string('darklogo')->nullable();
            $table->string('favicon')->nullable();
            $table->text('headcode')->nullable();
            $table->text('footercode')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('google_map')->nullable();
            $table->string('google_news')->nullable();
            $table->string('copyright')->nullable();
            $table->string('google_api_key')->nullable();
            $table->string('whatsapp_api_key')->nullable();
            $table->string('openai_api_key')->nullable();
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
        Schema::dropIfExists('tbl_setting');
    }
};

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
            $table->string('id_network', 4)->nullable();
            $table->foreignId('id_user')->nullable();
            $table->string('nama_wartawan');
            $table->string('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kontak')->nullable();
            $table->string('foto')->nullable();
            $table->text('about_me')->nullable();
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
        Schema::dropIfExists('tbl_wartawan');
    }
};

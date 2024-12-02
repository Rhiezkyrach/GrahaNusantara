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
        Schema::create('tbl_network', function (Blueprint $table) {
            $table->id();
            $table->string('id_network', 4)->nullable();
            $table->string('nama');
            $table->string('slug');
            $table->string('url');
            $table->string('logo')->nullable();
            $table->integer('urutan');
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
        Schema::dropIfExists('tbl_network');
    }
};

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
        Schema::create('tbl_epapers', function (Blueprint $table) {
            $table->id();
            $table->string('id_network', 4)->nullable();
            $table->date('edisi');
            $table->string('slug')->unique();
            $table->string('cover');
            $table->string('pdf');
            $table->bigInteger('counter')->default(0);
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
        Schema::dropIfExists('tbl_epapers');
    }
};

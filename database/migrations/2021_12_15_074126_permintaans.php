<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Permintaans extends Migration
{

    public function up()
    {
        Schema::create("Permintaans",function(Blueprint $table){
           $table->string("id_permintaan")->primary();
           $table->string('id_nik');
           $table->foreign('id_nik')->references('id_nik')->on('karyawans');
           $table->date("tgl_permintaan");
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
         Schema::dropIfExists('failed_jobs');
    }
}

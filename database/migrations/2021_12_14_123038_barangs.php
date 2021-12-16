<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class Barangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("barangs",function(Blueprint $table){
           $table->string("id_barang",15)->unique()->primary();
           $table->string("nama_barang",150);
           $table->decimal("qty",8,0);
           $table->string("lokasi",100);
           $table->enum("ketersediaan",array("Tersedia","Kosong"));
           $table->enum("satuan",array("Pak","Lusin","Butir","Rim","Buah","Ekor","Kodi"));
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

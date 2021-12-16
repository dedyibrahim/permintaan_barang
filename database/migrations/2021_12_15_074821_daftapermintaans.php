<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Daftapermintaans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create("daftarpermintaans",function(Blueprint $table){
            $table->string("id_daftar_permintaan",15)->primary();
            $table->string('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barangs');
            $table->string('id_permintaan');
            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaans');
            $table->decimal("qty",8,0);
            $table->string("keterangan");

            $table->timestamps();
       });
       DB::unprepared('
       CREATE TRIGGER qty AFTER INSERT ON  daftarpermintaans FOR EACH ROW
         BEGIN

            UPDATE barangs SET qty = qty - NEW.qty

                WHERE id_barang = NEW.id_barang;

          END
       ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER qty');

        Schema::dropIfExists('failed_jobs');
    }
}

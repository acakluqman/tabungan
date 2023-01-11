<?php

use App\Models\Siswa;
use App\Models\JenisTagihan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id('id_tagihan');
            $table->foreignIdFor(JenisTagihan::class, 'id_jenis_tagihan');
            $table->foreignIdFor(Siswa::class, 'id_siswa');
            $table->date('tgl_tagihan');
            $table->date('tgl_jatuh_tempo');
            $table->unsignedBigInteger('id_status_tagihan');
            $table->timestamps();

            $table->foreign('id_jenis_tagihan')->references('id_jenis_tagihan')->on('jenis_tagihan')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};

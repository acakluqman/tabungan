<?php

use App\Models\Tahun;
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
        Schema::create('jenis_tagihan', function (Blueprint $table) {
            $table->id('id_jenis_tagihan');
            $table->foreignIdFor(Tahun::class, 'thn_ajaran');
            $table->string('nama');
            $table->float('jml_tagihan');
            $table->timestamps();

            $table->foreign('thn_ajaran')->references('thn_ajaran')->on('tahun_ajaran')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenis_tagihan');
    }
};

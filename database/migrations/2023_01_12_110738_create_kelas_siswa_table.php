<?php

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahun;
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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id('id_kelas_siswa');
            $table->foreignIdFor(Tahun::class, 'thn_ajaran');
            $table->foreignIdFor(Kelas::class, 'id_kelas');
            $table->foreignIdFor(Siswa::class, 'id_siswa');
            $table->timestamps();

            $table->unique(['thn_ajaran', 'id_kelas', 'id_siswa']);
            $table->foreign('thn_ajaran')->references('thn_ajaran')->on('tahun_ajaran')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_siswa');
    }
};

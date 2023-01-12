<?php

use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\User;
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
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id('id_tabungan');
            $table->enum('tipe', ['debit', 'kredit']);
            $table->foreignIdFor(Siswa::class, 'id_siswa');
            $table->unsignedBigInteger('nominal');
            $table->text('keterangan')->nullable();
            $table->dateTime('tgl_transaksi');
            $table->foreignIdFor(User::class, 'id_petugas')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabungan');
    }
};

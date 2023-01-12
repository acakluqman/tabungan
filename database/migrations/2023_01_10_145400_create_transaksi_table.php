<?php

use App\Models\Tagihan;
use App\Models\User;
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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignIdFor(Tagihan::class, 'id_tagihan');
            $table->unsignedBigInteger('total_tagihan');
            $table->unsignedBigInteger('total_bayar');
            $table->dateTime('tgl_transaksi');
            $table->foreignIdFor(User::class, 'id_petugas')->nullable();
            $table->timestamps();

            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan')->onUpdate('cascade')->onDelete('restrict');
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
        Schema::dropIfExists('transaksi');
    }
};

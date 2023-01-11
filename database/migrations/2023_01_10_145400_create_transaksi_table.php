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
            $table->enum('tipe_tx', ['debit', 'kredit']);
            $table->float('total_tagihan');
            $table->float('total_bayar');
            $table->dateTime('tgl_transaksi');
            $table->foreignIdFor(User::class, 'validator');
            $table->dateTime('tgl_validasi');
            $table->timestamps();

            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('validator')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('restrict');
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

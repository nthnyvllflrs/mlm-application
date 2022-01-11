<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenealogyWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genealogy_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('genealogy_id');
            $table->double('balance');
            $table->double('accumulated_balance');
            $table->timestamps();

            $table->foreign('genealogy_id')->references('id')->on('genealogies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genealogy_wallets');
    }
}

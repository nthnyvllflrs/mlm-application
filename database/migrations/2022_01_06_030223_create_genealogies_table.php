<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenealogiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genealogies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index();
            $table->unsignedBigInteger('representative_id');
            $table->string('type');
            $table->unsignedBigInteger('referral_id')->nullable(); // Nullable for the first genealogy
            $table->unsignedBigInteger('reference_id')->nullable(); // Nullable for the first genealogy
            $table->string('reference_position');
            $table->timestamps();

            // Foreign keys
            $table->foreign('representative_id')->references('id')->on('representatives')->onDelete('cascade');
            $table->foreign('referral_id')->references('id')->on('genealogies')->onDelete('cascade');
            $table->foreign('reference_id')->references('id')->on('genealogies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genealogies');
    }
}

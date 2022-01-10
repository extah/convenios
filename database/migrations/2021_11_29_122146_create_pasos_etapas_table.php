<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasosEtapasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasos_etapas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_proyecto', 255)->nullable();
            $table->string('paso1', 2)->nullable();
            $table->string('paso2', 2)->nullable();
            $table->string('paso3', 2)->nullable();
            $table->string('paso4', 2)->nullable();
            $table->string('finalizo', 2)->nullable();
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
        Schema::dropIfExists('pasos_etapas');
    }
}

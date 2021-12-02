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
            $table->boolean('paso1');
            $table->boolean('paso2');
            $table->boolean('paso3');
            $table->boolean('paso4');
            $table->boolean('finalizo');
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

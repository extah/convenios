<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaso3sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paso3s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_etapas')->nullable();
            $table->string('condicion_rendicion', 255)->nullable();
            $table->string('nombre_archivo', 255)->nullable();
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
        Schema::dropIfExists('paso3s');
    }
}

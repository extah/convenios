<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaso1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paso1s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_etapas')->nullable();
            $table->string('organismo_financiador', 255)->nullable();
            $table->string('nombre_proyecto', 255)->nullable();
            $table->double('monto', 15, 2)->default(0)->nullable();
            $table->string('cuenta_bancaria', 255)->nullable();
            $table->string('cbu', 30)->nullable();
            $table->date('fecha_inicio', 0)->nullable();
            $table->date('fecha_rendicion', 0)->nullable();
            $table->date('fecha_finalizacion', 0)->nullable();
            $table->string('tipo_rendicion', 255)->nullable();
            $table->double('monto_recibido', 15, 2)->default(0)->nullable(); 
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
        Schema::dropIfExists('paso1s');
    }
}

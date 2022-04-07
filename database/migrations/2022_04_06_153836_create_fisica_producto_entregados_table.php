<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisicaProductoEntregadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisica_producto_entregados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_etapas')->nullable();
            $table->bigInteger('id_compra')->nullable();
            $table->string('producto_entregado', 255)->nullable();
            $table->bigInteger('nro_acta')->nullable();
            $table->bigInteger('porcentaje')->nullable();
            $table->double('monto', 15, 2)->default(0)->nullable();
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
        Schema::dropIfExists('fisica_producto_entregados');
    }
}

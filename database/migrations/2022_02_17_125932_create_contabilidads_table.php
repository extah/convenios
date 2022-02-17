<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_etapas')->nullable();
            $table->bigInteger('id_compra')->nullable();
            $table->string('nro_factura', 255)->nullable();
            $table->date('fecha_emision', 0)->nullable();
            $table->string('beneficiario', 150)->nullable();
            $table->bigInteger('cuit')->nullable();
            $table->double('importe', 15, 2)->default(0)->nullable(); 
            $table->bigInteger('cae')->nullable();
            $table->bigInteger('nro_pago')->nullable();
            $table->string('nombre_archivo_factura', 255)->nullable();
            $table->string('nombre_archivo_comprobante_afip', 255)->nullable();
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
        Schema::dropIfExists('contabilidads');
    }
}

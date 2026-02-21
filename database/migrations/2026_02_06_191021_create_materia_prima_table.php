<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('materia_prima', function (Blueprint $table) {
            $table->id('id_materia_prima');
            $table->string('nombre_materia', 100);
            $table->integer('unidad_fija');
            $table->integer('stock_actual');
            $table->date('fecha_ingreso');
            $table->date('fecha_salida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materia_prima');
    }
};

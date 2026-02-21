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
        Schema::create('material_ocupado', function (Blueprint $table) {
            $table->id('id_material');
            $table->unsignedBigInteger('id_pan');
            $table->unsignedBigInteger('id_materia_prima');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('id_pan')->references('id_pan')->on('producto');
            $table->foreign('id_materia_prima')->references('id_materia_prima')->on('materia_prima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_ocupado');
    }
};

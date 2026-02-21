<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_empleados', function (Blueprint $table) {
            $table->id('id_info');
            $table->unsignedBigInteger('id_empleado');
            $table->decimal('salario', 10, 2)->default(0);
            $table->string('telefono')->nullable();
            $table->text('direccion')->nullable();
            $table->date('fecha_contratacion');
            $table->enum('estado', ['activo', 'inactivo', 'vacaciones'])->default('activo');
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->foreign('id_empleado')->references('id_empleado')->on('empleados')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_empleados');
    }
};

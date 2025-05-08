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
        Schema::create('ciudades', function (Blueprint $table) {
            $table->id();
            $table->string('ciudad');  // Nombre de la ciudad
            $table->decimal('latitud', 10, 7)->nullable();   // Latitud con precisión de 7 decimales
            $table->decimal('longitud', 10, 7)->nullable();  // Longitud con precisión de 7 decimales
            $table->unsignedBigInteger('pais_id')->nullable();  // Clave foránea que referencia a 'paises'

            $table->timestamps();

            // Agregar la clave foránea a la tabla 'paises' 
            $table->foreign('pais_id')->references('id')->on('paises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciudades');
    }
};

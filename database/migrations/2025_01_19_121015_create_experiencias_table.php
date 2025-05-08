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
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('vip')->default(false);
            $table->boolean('activa')->default(true);
            $table->longText('descripcion');
            $table->longText('descripcion_corta');
            $table->integer('duracion')->default(1);
            $table->decimal('precio_adulto', 10, 2)->default(1000);
            $table->decimal('precio_nino', 10, 2)->default(500);

            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('tipo_id')->default(1);
            $table->unsignedBigInteger('ciudad_id')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencias');
    }
};

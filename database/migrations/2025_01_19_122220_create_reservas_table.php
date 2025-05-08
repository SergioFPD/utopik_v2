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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->integer('adultos');
            $table->integer('menores')->default(0);
            $table->boolean('confirmado')->default(1);
            $table->integer('puntuacion')->default(0);

            $table->unsignedBigInteger('exp_fecha_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('experiencia_id')->nullable();

            $table->foreign('experiencia_id')->references('id')->on('experiencias')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};

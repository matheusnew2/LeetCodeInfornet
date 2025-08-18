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
        Schema::create('prestador_servico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prestador');
            $table->unsignedBigInteger('id_servico');
            $table->integer('km_saida');
            $table->double('valor_saida');
            $table->double('valor_km_excedente');
            $table->foreign('id_prestador')->references('id')->on('prestador');
            $table->foreign('id_servico')->references('id')->on('servico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestador_servico');
    }
};

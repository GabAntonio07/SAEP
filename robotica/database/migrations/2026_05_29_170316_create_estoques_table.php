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
        Schema::create('estoques', function (Blueprint $table) {
            $table->id();
            $table->integer('codigo');
            $table->string('nome');
            $table->string('fabricante');
            $table->float('preco');
            $table->integer('quantidade');
            $table->integer('nivel_minimo')->default(0);
            $table->float('numero_de_serie');
            $table->dateTime('tempo_de_vida')->default(now());
            $table->string('localizacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estoques');
    }
};

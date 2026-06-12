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
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('codigo')->unique();
            $table->string('fabricante');
            $table->decimal('preco');
            $table->integer('quantidade');
            $table->integer('nivel_minimo');
            $table->decimal('peso');
            $table->decimal('largura');
            $table->decimal('altura');
            $table->decimal('comprimento');
            $table->string('destino');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargas');
    }
};

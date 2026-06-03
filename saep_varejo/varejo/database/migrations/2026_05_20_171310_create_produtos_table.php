<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('produtos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->string('nome');
        $table->string('fornecedor');
        $table->decimal('preco', 10, 2);
        $table->integer('quantidade');
        $table->integer('nivel_minimo');
        $table->string('categoria');
        $table->date('data_validade');
        $table->decimal('temperatura_armazenamento', 5, 2);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
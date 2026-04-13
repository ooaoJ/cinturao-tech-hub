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
        Schema::create('documentos_projeto', function (Blueprint $table) {
            $table->id();

            $table->foreignId('projeto_id')->constrained('projetos')->cascadeOnDelete();

            $table->string('tipo'); // regras_negocio | requisitos
            $table->string('arquivo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_projeto');
    }
};

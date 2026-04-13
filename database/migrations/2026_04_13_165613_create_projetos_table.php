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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipe_id')->constrained('equipes')->cascadeOnDelete();

            $table->string('titulo');
            $table->text('descricao');
            $table->text('problema_resolvido');

            $table->string('link_prototipo')->nullable();
            $table->string('link_repositorio')->nullable();

            $table->string('status')->default('rascunho');
            $table->boolean('aprovado_orientador')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};

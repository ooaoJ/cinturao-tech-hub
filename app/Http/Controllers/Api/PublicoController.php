<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Projeto;

class PublicoController extends Controller
{
    public function projetos()
    {
        try {
            $projetos = Projeto::with([
                'equipe.orientador',
                'equipe.cidade',
                'documentos',
                'testes',
            ])
                ->where('aprovado_orientador', true)
                ->get();

            return response()->json([
                'message' => 'Projetos públicos listados com sucesso.',
                'projetos' => $projetos
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar projetos públicos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function projeto(string $id)
    {
        try {
            $projeto = Projeto::with([
                'equipe.orientador',
                'equipe.cidade',
                'documentos',
                'testes',
                'avaliacoes.criterios.criterio',
            ])
                ->where('aprovado_orientador', true)
                ->find($id);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto público não encontrado.'
                ], 404);
            }

            return response()->json([
                'message' => 'Projeto público encontrado com sucesso.',
                'projeto' => $projeto
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar projeto público.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

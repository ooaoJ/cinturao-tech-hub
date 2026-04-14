<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        try {
            $ranking = Projeto::select(
                'projetos.id',
                'projetos.titulo',
                'projetos.status',
                'projetos.aprovado_orientador',
                'equipes.nome as equipe_nome',
                DB::raw('AVG(avaliacoes.nota_final) as media_final')
            )
                ->join('equipes', 'equipes.id', '=', 'projetos.equipe_id')
                ->leftJoin('avaliacoes', 'avaliacoes.projeto_id', '=', 'projetos.id')
                ->where('projetos.aprovado_orientador', true)
                ->groupBy(
                    'projetos.id',
                    'projetos.titulo',
                    'projetos.status',
                    'projetos.aprovado_orientador',
                    'equipes.nome'
                )
                ->orderByDesc('media_final')
                ->get();

            return response()->json([
                'message' => 'Ranking gerado com sucesso.',
                'ranking' => $ranking
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao gerar ranking.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

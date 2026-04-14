<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avaliacao;
use App\Models\AvaliacaoCriterio;
use App\Models\Criterio;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AvaliacaoController extends Controller
{
    public function index(string $projetoId)
    {
        try {
            $projeto = Projeto::with([
                'avaliacoes.avaliador',
                'avaliacoes.criterios.criterio',
            ])->find($projetoId);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            return response()->json([
                'message' => 'Avaliações listadas com sucesso.',
                'avaliacoes' => $projeto->avaliacoes
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar avaliações.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request, string $projetoId)
    {
        try {
            $usuarioLogado = auth('api')->user();

            if (! $usuarioLogado) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            $projeto = Projeto::find($projetoId);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            $validated = $request->validate([
                'comentario_geral' => ['nullable', 'string'],
                'criterios' => ['required', 'array', 'min:1'],
                'criterios.*.criterio_id' => ['required', 'integer', 'exists:criterios,id'],
                'criterios.*.nota' => ['required', 'numeric', 'min:0', 'max:10'],
                'criterios.*.comentario' => ['nullable', 'string'],
            ]);

            $avaliacaoExistente = Avaliacao::where('projeto_id', $projeto->id)
                ->where('avaliador_id', $usuarioLogado->id)
                ->first();

            if ($avaliacaoExistente) {
                return response()->json([
                    'message' => 'Você já avaliou este projeto.'
                ], 409);
            }

            DB::beginTransaction();

            $avaliacao = Avaliacao::create([
                'projeto_id' => $projeto->id,
                'avaliador_id' => $usuarioLogado->id,
                'comentario_geral' => $validated['comentario_geral'] ?? null,
                'nota_final' => 0,
            ]);

            $somaPesos = 0;
            $somaNotasPonderadas = 0;

            foreach ($validated['criterios'] as $item) {
                $criterio = Criterio::find($item['criterio_id']);

                AvaliacaoCriterio::create([
                    'avaliacao_id' => $avaliacao->id,
                    'criterio_id' => $criterio->id,
                    'nota' => $item['nota'],
                    'comentario' => $item['comentario'] ?? null,
                ]);

                $somaPesos += $criterio->peso;
                $somaNotasPonderadas += ($item['nota'] * $criterio->peso);
            }

            $notaFinal = $somaPesos > 0 ? $somaNotasPonderadas / $somaPesos : 0;

            $avaliacao->update([
                'nota_final' => round($notaFinal, 2)
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Avaliação registrada com sucesso.',
                'avaliacao' => $avaliacao->load('criterios.criterio')
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Erro ao registrar avaliação.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

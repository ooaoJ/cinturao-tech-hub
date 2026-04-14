<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Projeto;
use App\Models\Teste;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TesteController extends Controller
{
    public function index(string $projetoId)
    {
        try {
            $projeto = Projeto::with('testes')->find($projetoId);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            return response()->json([
                'message' => 'Testes listados com sucesso.',
                'testes' => $projeto->testes
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar testes.',
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
                'descricao' => ['required', 'string'],
                'data_teste' => ['nullable', 'date'],
                'resultado' => ['nullable', 'string', 'max:255'],
                'observacoes' => ['nullable', 'string'],
            ]);

            $teste = Teste::create([
                'projeto_id' => $projeto->id,
                'descricao' => $validated['descricao'],
                'data_teste' => $validated['data_teste'] ?? null,
                'resultado' => $validated['resultado'] ?? null,
                'observacoes' => $validated['observacoes'] ?? null,
            ]);

            return response()->json([
                'message' => 'Teste registrado com sucesso.',
                'teste' => $teste
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao registrar teste.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

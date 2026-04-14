<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DocumentoProjeto;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DocumentoProjetoController extends Controller
{
    public function index(string $projetoId)
    {
        try {
            $projeto = Projeto::with('documentos')->find($projetoId);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            return response()->json([
                'message' => 'Documentos listados com sucesso.',
                'documentos' => $projeto->documentos
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar documentos.',
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
                'tipo' => ['required', 'string', 'max:255'],
                'arquivo' => ['required', 'string', 'max:255'],
            ]);

            $documento = DocumentoProjeto::create([
                'projeto_id' => $projeto->id,
                'tipo' => $validated['tipo'],
                'arquivo' => $validated['arquivo'],
            ]);

            return response()->json([
                'message' => 'Documento registrado com sucesso.',
                'documento' => $documento
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao registrar documento.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Projeto;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProjetoController extends Controller
{
    public function index()
    {
        try {
            $projetos = Projeto::with([
                'equipe.orientador',
                'equipe.cidade',
                'equipe.etapa',
                'documentos',
                'testes',
            ])->get();

            return response()->json([
                'message' => 'Projetos listados com sucesso.',
                'projetos' => $projetos
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar projetos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $projeto = Projeto::with([
                'equipe.orientador',
                'equipe.cidade',
                'equipe.etapa',
                'documentos',
                'testes',
            ])->find($id);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            return response()->json([
                'message' => 'Projeto encontrado com sucesso.',
                'projeto' => $projeto
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar projeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $usuarioLogado = auth('api')->user();

            if (! $usuarioLogado) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            $validated = $request->validate([
                'equipe_id' => ['required', 'integer', 'exists:equipes,id'],
                'titulo' => ['required', 'string', 'max:255'],
                'descricao' => ['required', 'string'],
                'problema_resolvido' => ['required', 'string'],
                'link_prototipo' => ['nullable', 'url'],
                'link_repositorio' => ['nullable', 'url'],
            ]);

            $equipe = Equipe::find($validated['equipe_id']);

            if (! $equipe) {
                return response()->json([
                    'message' => 'Equipe não encontrada.'
                ], 404);
            }

            $projetoExistente = Projeto::where('equipe_id', $validated['equipe_id'])->first();

            if ($projetoExistente) {
                return response()->json([
                    'message' => 'Esta equipe já possui um projeto cadastrado.'
                ], 409);
            }

            $projeto = Projeto::create([
                'equipe_id' => $validated['equipe_id'],
                'titulo' => $validated['titulo'],
                'descricao' => $validated['descricao'],
                'problema_resolvido' => $validated['problema_resolvido'],
                'link_prototipo' => $validated['link_prototipo'] ?? null,
                'link_repositorio' => $validated['link_repositorio'] ?? null,
                'status' => 'rascunho',
                'aprovado_orientador' => false,
            ]);

            return response()->json([
                'message' => 'Projeto criado com sucesso.',
                'projeto' => $projeto
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao criar projeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $usuarioLogado = auth('api')->user();

            if (! $usuarioLogado) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            $projeto = Projeto::find($id);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            if ($projeto->status === 'finalizado') {
                return response()->json([
                    'message' => 'Não é possível editar um projeto finalizado.'
                ], 409);
            }

            $validated = $request->validate([
                'titulo' => ['sometimes', 'string', 'max:255'],
                'descricao' => ['sometimes', 'string'],
                'problema_resolvido' => ['sometimes', 'string'],
                'link_prototipo' => ['nullable', 'url'],
                'link_repositorio' => ['nullable', 'url'],
                'status' => ['sometimes', 'string'],
            ]);

            $projeto->update($validated);

            return response()->json([
                'message' => 'Projeto atualizado com sucesso.',
                'projeto' => $projeto
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao atualizar projeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function aprovar(string $id)
    {
        try {
            $usuarioLogado = auth('api')->user();

            if (! $usuarioLogado) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            if ($usuarioLogado->cargo_id !== 2) {
                return response()->json([
                    'message' => 'Somente orientadores podem aprovar projetos.'
                ], 403);
            }

            $projeto = Projeto::with('equipe')->find($id);

            if (! $projeto) {
                return response()->json([
                    'message' => 'Projeto não encontrado.'
                ], 404);
            }

            if ($projeto->aprovado_orientador) {
                return response()->json([
                    'message' => 'O projeto já foi aprovado.'
                ], 409);
            }

            $projeto->update([
                'aprovado_orientador' => true,
                'status' => 'aprovado',
            ]);

            return response()->json([
                'message' => 'Projeto aprovado com sucesso.',
                'projeto' => $projeto
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao aprovar projeto.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

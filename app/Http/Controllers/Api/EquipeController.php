<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\EquipeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EquipeController extends Controller
{
    public function index()
    {
        try {
            $equipes = Equipe::with([
                'orientador',
                'cidade',
                'etapa',
                'usuarios.cargo',
                'usuarios.cidade',
            ])->get();

            return response()->json([
                'message' => 'Equipes listadas com sucesso.',
                'equipes' => $equipes
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao listar equipes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $equipe = Equipe::with([
                'orientador',
                'cidade',
                'etapa',
                'usuarios.cargo',
                'usuarios.cidade',
            ])->find($id);

            if (! $equipe) {
                return response()->json([
                    'message' => 'Equipe não encontrada.'
                ], 404);
            }

            return response()->json([
                'message' => 'Equipe encontrada com sucesso.',
                'equipe' => $equipe
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar equipe.',
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
                'nome' => ['required', 'string', 'max:255'],
                'orientador_id' => ['required', 'integer', 'exists:users,id'],
                'cidade_id' => ['required', 'integer', 'exists:cidades,id'],
                'etapa_id' => ['required', 'integer', 'exists:etapas,id'],
            ]);

            $orientador = User::find($validated['orientador_id']);

            if (! $orientador) {
                return response()->json([
                    'message' => 'Orientador não encontrado.'
                ], 404);
            }

            if ($orientador->cargo_id !== 2) {
                return response()->json([
                    'message' => 'O usuário informado não é um orientador.'
                ], 409);
            }

            if ($orientador->status !== 'aprovado') {
                return response()->json([
                    'message' => 'O orientador precisa estar aprovado.'
                ], 409);
            }

            $equipe = Equipe::create([
                'nome' => $validated['nome'],
                'orientador_id' => $validated['orientador_id'],
                'cidade_id' => $validated['cidade_id'],
                'etapa_id' => $validated['etapa_id'],
            ]);

            return response()->json([
                'message' => 'Equipe criada com sucesso.',
                'equipe' => $equipe
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao criar equipe.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function adicionarIntegrante(Request $request)
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
                'user_id' => ['required', 'integer', 'exists:users,id'],
                'funcao_id' => ['required', 'integer', 'exists:funcoes_equipe,id'],
            ]);

            $equipe = Equipe::with('usuarios')->find($validated['equipe_id']);
            $user = User::find($validated['user_id']);

            if (! $equipe) {
                return response()->json([
                    'message' => 'Equipe não encontrada.'
                ], 404);
            }

            if (! $user) {
                return response()->json([
                    'message' => 'Usuário não encontrado.'
                ], 404);
            }

            if ($user->cargo_id !== 1) {
                return response()->json([
                    'message' => 'Somente alunos podem ser adicionados como integrantes.'
                ], 409);
            }

            if ($user->status !== 'aprovado') {
                return response()->json([
                    'message' => 'Somente usuários aprovados podem entrar em uma equipe.'
                ], 409);
            }

            $jaEstaEmEquipe = EquipeUser::where('user_id', $validated['user_id'])->exists();

            if ($jaEstaEmEquipe) {
                return response()->json([
                    'message' => 'Este usuário já está em uma equipe.'
                ], 409);
            }

            if ($equipe->usuarios->count() >= 4) {
                return response()->json([
                    'message' => 'A equipe já possui o limite máximo de 4 alunos.'
                ], 409);
            }

            EquipeUser::create([
                'equipe_id' => $validated['equipe_id'],
                'user_id' => $validated['user_id'],
                'funcao_id' => $validated['funcao_id'],
            ]);

            return response()->json([
                'message' => 'Integrante adicionado com sucesso.'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao adicionar integrante.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function removerIntegrante(string $id)
    {
        try {
            $usuarioLogado = auth('api')->user();

            if (! $usuarioLogado) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            $equipeUser = EquipeUser::find($id);

            if (! $equipeUser) {
                return response()->json([
                    'message' => 'Integrante da equipe não encontrado.'
                ], 404);
            }

            $equipeUser->delete();

            return response()->json([
                'message' => 'Integrante removido com sucesso.'
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao remover integrante.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

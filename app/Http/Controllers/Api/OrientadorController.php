<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrientadorController extends Controller
{
    public function aprovar(Request $request)
    {
        try {

            $orientador = auth('api')->user();

            if (! $orientador) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            if ($orientador->cargo_id !== 2) {
                return response()->json([
                    'message' => 'É necessário ser um orientador para aprovar um novo usuário.'
                ], 403);
            }

            $validated = $request->validate([
                'usuario_id' => ['required', 'integer', 'exists:users,id'],
            ]);

            $user = User::find($validated['usuario_id']);

            if (! $user) {
                return response()->json([
                    'message' => 'O usuário não foi encontrado.'
                ], 404);
            }

            if ($user->status === 'aprovado') {
                return response()->json([
                    'message' => 'O usuário já foi aprovado.'
                ], 409);
            }

            $user->update([
                'status' => 'aprovado'
            ]);

            return response()->json([
                'message' => 'O usuário foi aprovado com sucesso.'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao aprovar o usuário.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pendentes()
    {
        try{
            $orientador = auth('api')->user();

            if (! $orientador) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            if ($orientador->cargo_id !== 2) {
                return response()->json([
                    'message' => 'É necessário ser um orientador para acessar esta rota.'
                ], 403);
            }

            $usuarios = User::with(['cargo', 'cidade'])
                ->where('status', 'pendente')
                ->get();

            return response()->json([
                'message' => 'Usuários pendentes listados com sucesso.',
                'usuarios' => $usuarios
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar usuários pendentes.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reprovar(Request $request)
    {
        try {
            $orientador = auth('api')->user();

            if (! $orientador) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            if ($orientador->cargo_id !== 2) {
                return response()->json([
                    'message' => 'É necessário ser um orientador para reprovar um usuário.'
                ], 403);
            }

            $validated = $request->validate([
                'usuario_id' => ['required', 'integer', 'exists:users,id'],
            ]);

            $user = User::find($validated['usuario_id']);

            if (! $user) {
                return response()->json([
                    'message' => 'O usuário não foi encontrado.'
                ], 404);
            }

            if ($user->status !== 'pendente') {
                return response()->json([
                    'message' => 'Só é possível reprovar usuários pendentes.'
                ], 409);
            }

            $user->update([
                'status' => 'reprovado'
            ]);

            return response()->json([
                'message' => 'O usuário foi reprovado com sucesso.'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao reprovar usuário.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function aprovados()
    {
        try {
            $orientador = auth('api')->user();

            if (! $orientador) {
                return response()->json([
                    'message' => 'Usuário não autenticado.'
                ], 401);
            }

            if ($orientador->cargo_id !== 2) {
                return response()->json([
                    'message' => 'É necessário ser um orientador para acessar esta rota.'
                ], 403);
            }

            $usuarios = User::with(['cargo', 'cidade'])
                ->where('status', 'aprovado')
                ->get();

            return response()->json([
                'message' => 'Usuários aprovados listados com sucesso.',
                'usuarios' => $usuarios
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar usuários aprovados.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

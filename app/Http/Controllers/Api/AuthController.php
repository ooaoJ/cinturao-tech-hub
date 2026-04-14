<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'matricula' => ['required', 'string', 'max:50', 'unique:users,matricula'],
                'password' => ['required', 'string', 'min:6'],
                'cargo_id' => ['required', 'exists:cargos,id'],
                'cidade_id' => ['required', 'exists:cidades,id'],
                'bio' => ['nullable', 'string'],
                'foto' => ['nullable', 'string'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'matricula' => $validated['matricula'],
                'password' => Hash::make($validated['password']),
                'status' => 'pendente',
                'cargo_id' => $validated['cargo_id'],
                'cidade_id' => $validated['cidade_id'],
                'bio' => $validated['bio'] ?? null,
                'foto' => $validated['foto'] ?? null,
            ]);

            return response()->json([
                'message' => 'O usuário foi cadastrado com sucesso.',
                'user' => $user,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro interno ao cadastrar o usuário.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'matricula' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where('matricula', $validated['matricula'])->first();

            if (! $user) {
                return response()->json([
                    'message' => 'Erro ao validar os dados, tente novamente.',
                ], 404);
            }

            if (! Hash::check($validated['password'], $user->password )) {
                return response()->json([
                    'message' => 'Erro ao validar os dados, tente novamente.',
                ], 401);
            }

            if ($user->status === 'pendente') {
                return response()->json([
                    'message' => 'O usuário ainda não foi aprovado.',
                ], 403);
            }

            if ($user->status === 'reprovado') {
                return response()->json([
                    'message' => 'O usuário teve o cadastro reprovado.',
                ], 403);
            }

            $token = auth('api')->login($user);

            if (! $token) {
                return response()->json([
                    'message' => 'Não foi possível gerar o token.',
                ], 500);
            }

            return $this->respondWithToken($token);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação.',
                'errors' => $e->errors(),
            ], 422);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Erro ao gerar o token JWT.',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro interno ao realizar login.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function me(): JsonResponse
    {
        try {
            $user = auth('api')->user();

            if (! $user) {
                return response()->json([
                    'message' => 'Usuário não autenticado.',
                ], 401);
            }

            return response()->json($user, 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao buscar usuário autenticado.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            auth('api')->logout();

            return response()->json([
                'message' => 'Logout realizado com sucesso.',
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao realizar logout.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            $token = auth('api')->refresh();

            return $this->respondWithToken($token);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao atualizar o token.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ], 200);
    }
}

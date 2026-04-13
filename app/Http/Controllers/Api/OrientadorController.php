<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrientadorController extends Controller
{
    public function aprovar(Request $request)
    {

        try{

            $request->validate([
                'usuario_id' => 'required|string|exists:users,id',
            ]);

            if(auth()->user()->cargo_id !== 2) {
                return response()->json([
                    'message' => 'É necessário ser um orientador para aprovar um novo usuário.'
                ], 403);
            }

            $user = User::where('id', $request->usuario_id)->first();

            if(!$user) {
                return response()->json([
                    'message' => 'O usuário não foi encontrado.'
                ]);
            }

            if($user->status === 'aprovado') {
                return response()->json([
                    'message' => 'O usuário já foi aprovado.'
                ]);
            }

            $user->update([
                'status' => 'aprovado'
            ]);

            $user->save();

            return response()->json([
                'message' => 'O usuário foi aprovado com sucesso.'
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Erro ao validar os dados, tente novamente.',
                'error' => $e->getMessage()
            ]);
        }
    }
}

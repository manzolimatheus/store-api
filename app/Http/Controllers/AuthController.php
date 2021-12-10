<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {

        $email_check = User::where('email', $request->email)->count();

        if ($email_check > 0) {
            return response()->json(['message'=>'Esse email já foi registrado por outro usuário.', 'status'=>500]);
        } else {
            try {
                $validatedData = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8',
                ]);

                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'Usuário cadastrado com sucesso!',
                    'status' => 201
                ]);
            } catch (Exception $e) {
                return response()->json(['message' => 'Erro ao cadastrar o usuário!', 'status' => 500]);
            }
        }
    }

    public function login(Request $request)
    {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'message' => 'Usuário inválido!'
                ], 401);
            }

            $user = User::where('email', $request['email'])->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 200
            ]);

    }

    public function profile(Request $request)
    {
        return $request->user();
    }

    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            $user->delete();

            return response()->json(['message' => 'Usuário deletado com sucesso!', 'status' => 201]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao deletar este usuário!', 'status' => 500]);
        }
    }

    public function getCount(){
        $users = User::all()->count();

        return response()->json($users);
    }
}

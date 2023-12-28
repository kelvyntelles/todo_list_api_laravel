<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $name = $fields['name'];
        $email = $fields['email'];
        $password = Hash::make($fields['password']);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $data = ['message' => 'Usuário criado com sucesso!'];
        return response()->json($data, 201);
    }

    public function login(Request $request) {
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([['message' => 'autorizado'], [
                'token' => $request->user()->createToken('invoice')->plainTextToken
            ]]);
        }

        return response()->json(['message' => 'Não Autorizado'], 403);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Autentica un usuario y genera un token Bearer para el consumo del API.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'codigo' => 401,
                'mensaje' => 'Credenciales inválidas. Verifique su email y contraseña.',
            ], 401);
        }

        $token = $user->createToken('softland_api_token')->plainTextToken;

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Autenticación exitosa',
            'token_tipo' => 'Bearer',
            'token' => $token,
            'usuario' => new UsuarioResource($user),
        ], 200);
    }

    /**
     * Cierra la sesión revocando el token actual.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'codigo' => 200,
            'mensaje' => 'Sesión y token cerrados correctamente',
        ], 200);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

// Rotas que precisam de sessão para a SPA
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    $user = Auth::user();

    if (is_null($user->email_verified_at)) {
        Auth::logout(); // Faz o logout se o e-mail não for verificado

        // Retorna uma resposta JSON com status 422 para o frontend tratar
        return response()->json([
            'message' => 'Seu e-mail ainda não foi verificado. Por favor, verifique sua caixa de entrada.',
            'errors' => [
                'email' => ['Seu e-mail ainda não foi verificado. Por favor, verifique sua caixa de entrada.']
            ]
        ], 422);
    }

    $request->session()->regenerate();

    return response()->json(['message' => 'Login bem-sucedido.']);
});

// Você pode adicionar a rota de logout aqui também
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['message' => 'Logout bem-sucedido.']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
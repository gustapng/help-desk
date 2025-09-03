<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[0-9]/', 'regex:/[@$!%*#?&.]/'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return response()->json([
        'message' => 'Cadastro realizado com sucesso!',
        'user' => $user,
    ], 201);
});

Route::get('/auth/verify-email/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Usuário não encontrado.'], 404);
    }

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Link de verificação inválido.'], 403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    // TODO - RESOLVER O RETORNO DA API
    return redirect('http://localhost:5173/login?verified=true');
})->middleware('signed')->name('verification.verify');

Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
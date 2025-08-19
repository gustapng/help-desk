<?php

// backend/routes/api.php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Auth;
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

    event(new Registered($user)); // Trigger email verification

    return response()->json([
        // 'access_token' => $token,
        // 'token_type' => 'Bearer',
        'message' => 'Usuário registrado com sucesso. Por favor, verifique seu e-mail para ativar sua conta.'
    ]);
});

// Route::post('/login', function (Request $request) {
//     $credentials = $request->validate([
//         'email' => ['required', 'email'],
//         'password' => ['required'],
//     ]);

//     if (!Auth::attempt($credentials)) {
//         throw ValidationException::withMessages([
//             'email' => ['As credenciais fornecidas estão incorretas.'],
//         ]);
//     }

//     $user = Auth::user();

//     if (is_null($user->email_verified_at)) {
//         Auth::logout();

//         throw ValidationException::withMessages([
//             'email' => ['Seu e-mail ainda não foi verificado. Por favor, verifique sua caixa de entrada.'],
//         ]);
//     }

//     $request->session()->regenerate();

//     return response()->json(['message' => 'Login bem-sucedido.']);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::get('/auth/verify-email/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->json(['message' => 'Invalid verification link.'], 403);
    }

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    return redirect('http://localhost:5173/login?verified=true');
})->middleware('signed')->name('verification.verify');
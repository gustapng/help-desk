<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Link de redefinição enviado para seu e-mail.']);
        }

        return response()->json(['message' => 'Não foi possível encontrar um usuário com esse email.'], 422);
    }

    public function resetPassword(Request $request) {
        $request->validate([        
            'token' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[0-9]/', 'regex:/[@$!%*#?&.]/']]
        );

        $status = Password::reset($request->all(), function($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Redefinição de senha realizada com sucesso!']);
        }

        return response()->json(['message' => 'O token de redefinição é inválido.'], 422);
    }
}
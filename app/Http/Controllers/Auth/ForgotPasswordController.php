<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $status = Password::sendResetLink($request->only('email'));
        $isSent = $status === Password::RESET_LINK_SENT;
        $isAjax = $request->boolean('ajax');

        if ($isAjax) {
            return resJson([
                'message' => __($status),
            ], $isSent ? 200 : 422);
        }

        return $isSent
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}

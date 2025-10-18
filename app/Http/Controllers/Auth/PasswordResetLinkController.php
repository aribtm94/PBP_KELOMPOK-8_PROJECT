<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // For testing only: do not actually send email. Instead, check whether
        // the provided email exists and show the same success toast while
        // redirecting to login. This simulates the 'email sent' flow without
        // sending actual emails.
        $email = $request->input('email');
        $userExists = User::where('email', $email)->exists();

        if (! $userExists) {
            return back()->withInput($request->only('email'))
                        ->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        // Email exists — for testing we still don't send emails, but proceed
        // to show the success toast and redirect to login.
        return redirect()->route('login')->with('toast', [
            'title' => 'Permintaan Terkirim',
            'message' => 'Tautan reset telah dikirimkan.',
            'variant' => 'blue',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SessionRevokeRequest;
use App\Models\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        activity()
            ->performedOn($request->user())
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->getSession()->getId()
            ])
            ->event('auth')
            ->log('logged in');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        activity()
            ->performedOn($request->user())
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->getSession()->getId()
            ])
            ->event('auth')
            ->log('logged out');

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function revoke(SessionRevokeRequest $request): RedirectResponse
    {
        $session = Session::find($request->get('id'));

        activity()
            ->performedOn($request->user())
            ->withProperties([
                'ip_address' => $session->ip,
                'user_agent' => $session->user_agent,
                'session_id' => $session->id
            ])
            ->event('auth')
            ->log('revoked');

        if ($token = $session->token){
            JWTAuth::setToken($token)->invalidate(true);
        }

        $session->delete();
        return redirect()->back();
    }
}

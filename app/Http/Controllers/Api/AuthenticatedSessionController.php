<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthenticatedSessionResource;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): AuthenticatedSessionResource
    {
        $token = $request->authenticate();

        $payload = Auth::guard('api')->payload();
        $user = Auth::guard('api')->user();

        activity()
            ->inLog('api')
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $payload->get('jti')
            ])
            ->event('auth')
            ->log('logged in');

        $session = new Session();

        $session->id = $payload->get('jti');
        $session->user_id = $user->id;
        $session->ip_address = $request->ip();
        $session->user_agent = $request->userAgent();
        $session->payload = \Str::toBase64(json_encode($payload));
        $session->last_activity = time();
        $session->save();

        return new AuthenticatedSessionResource((object)[
            'token' => $token
        ]);
    }

    public function update(Request $request): AuthenticatedSessionResource
    {
        $token = Auth::guard('api')->refresh();

        $user = Auth::guard('api')->user();
        $payload = Auth::guard('api')->payload();

        activity()
            ->inLog('api')
            ->performedOn($user)
            ->causedBy($user)
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $payload->get('jti')
            ])
            ->event('auth')
            ->log('session refresh');

        return new AuthenticatedSessionResource((object)[
            'token' => $token
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
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

        Auth::guard('api')->logout(true);

        return response()->json([
            'status'  => true,
            'message' => 'Successfully logged out',
            'data'    => null
        ]);
    }
}

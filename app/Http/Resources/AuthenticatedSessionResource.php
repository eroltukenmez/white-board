<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);

        self::withoutWrapping();
    }

    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ];
    }
}

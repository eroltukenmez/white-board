<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'departments' => DepartmentResource::collection($this->whenLoaded('departments'))
        ];
    }

    public function with(Request $request): array
    {
        return [
            'status' => true,
            'message' => 'OK'
        ];
    }
}

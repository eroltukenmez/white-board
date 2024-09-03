<?php

namespace App\Http\Resources;

use App\Enums\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isApi = $request->is('api/*');

        $data = [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'location' => new LocationCollection($this->whenLoaded('location')),
            'type' => ApplicationType::getTitle($this->type),
            'description' => $this->description,
            'source' => $this->source,
            'created_at' => $this->created_at->format('d.m.Y H:i'),
        ];

        if (!$isApi){
            $data['actions'] = '<a href="'.route('application.show',$this->id).'">Show</a>';
        }

        if ($isApi && $request->user()->id === $this->user_id)
            unset($data['user']);


        return $data;
    }
}

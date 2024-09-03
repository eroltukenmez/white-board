<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => LocationCollection::collection($this->whenLoaded('children')),
            'parent'   => $this->getAllParents($this)
        ];
    }

    /**
     * Get all parent relationships recursively.
     *
     * @param LocationCollection $location
     * @return array|null
     */
    private function getAllParents($location): ?array
    {
        $parent = $location->parent;
        if ($parent) {
            return [
                'id' => $parent->id,
                'name' => $parent->name,
                'parent' => $this->getAllParents($parent),
            ];
        }

        return null;
    }
}

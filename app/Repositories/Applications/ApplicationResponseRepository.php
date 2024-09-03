<?php

namespace App\Repositories\Applications;

use App\Models\ApplicationResponse;
use Illuminate\Database\Eloquent\Collection;

class ApplicationResponseRepository implements ApplicationResponseRepositoryInterface
{

    public function create(array $data)
    {
        return ApplicationResponse::create($data);
    }

    public function getAll(): Collection
    {
        return ApplicationResponse::all();
    }

    public function find($id):ApplicationResponse
    {
        return ApplicationResponse::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $response = ApplicationResponse::findOrFail($id);
        $response->update($data);
        return $response;
    }
}

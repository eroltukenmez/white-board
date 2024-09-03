<?php

namespace App\Repositories\Applications;

use App\Models\ApplicationAssignment;
use Illuminate\Database\Eloquent\Collection;

class ApplicationAssignmentRepository implements ApplicationAssignmentRepositoryInterface
{

    public function create(array $data):ApplicationAssignment
    {
        return ApplicationAssignment::create($data);
    }

    public function getAll(): Collection
    {
        return ApplicationAssignment::all();
    }

    public function find($id): ApplicationAssignment
    {
        return ApplicationAssignment::findOrFail($id);
    }

    public function update($id, array $data):ApplicationAssignment
    {
        $assignment = ApplicationAssignment::findOrFail($id);
        $assignment->update($data);
        return $assignment;
    }
}

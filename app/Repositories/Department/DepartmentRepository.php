<?php

namespace App\Repositories\Department;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{

    public function create(array $data):Department
    {
        return Department::create($data);
    }

    public function getAll(): Collection
    {
        return Department::all();
    }

    public function find($id): Department
    {
        return Department::findOrFail($id);
    }

    public function update($id, array $data): Department
    {
        $model = Department::findOrFail($id);
        $model->update($data);
        return $model;
    }
}

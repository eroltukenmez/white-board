<?php

namespace App\Repositories\Department;

interface DepartmentRepositoryInterface
{
    public function create(array $data);
    public function getAll();
    public function find($id);
    public function update($id, array $data);
}

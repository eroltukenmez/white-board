<?php

namespace App\Repositories\Applications;

interface ApplicationAssignmentRepositoryInterface
{
    public function create(array $data);
    public function getAll();
    public function find($id);
    public function update($id, array $data);
}

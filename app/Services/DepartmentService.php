<?php

namespace App\Services;

use App\Repositories\Department\DepartmentRepositoryInterface;

class DepartmentService
{
    public function __construct(
        protected DepartmentRepositoryInterface $repository
    ){}

    public function getDepartments()
    {
        return $this->repository->getAll();
    }
}

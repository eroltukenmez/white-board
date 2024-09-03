<?php

namespace App\Repositories\Applications;

interface ApplicationRepositoryInterface
{
    public function searchAndPaginate(array $filters, int $perPage);
    public function create(array $data);
    public function getAll();
    public function find($id);
    public function update($id, array $data);
}

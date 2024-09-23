<?php

namespace App\Repositories\Applications;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationRepository implements ApplicationRepositoryInterface
{

    public function searchAndPaginate(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = Application::query()->with(['user','location']);

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['search'])) {
            $query->where('description', 'like', '%' . $filters['search'] . '%');
        }


        if (isset($filters['sortBy'],$filters['sortDirection'])) {
            if (\Str::contains($filters['sortBy'],'.')){
                list ($relation,$column) = explode('.',$filters['sortBy']);

            }else{
                $query->orderBy($filters['sortBy'], $filters['sortDirection']);
            }
        }

        return $query->paginate($perPage);
    }


    public function create(array $data):Application
    {
        return Application::create($data);
    }

    public function getAll(): Collection
    {
        return Application::all();
    }

    public function findWithUserAndLocation($id):Application
    {
        return Application::with(['user','location'])->findOrFail($id);
    }

    public function find($id):Application
    {
        return Application::findOrFail($id);
    }

    public function update($id, array $data):Application
    {
        $application = Application::findOrFail($id);
        $application->update($data);
        return $application;
    }
}

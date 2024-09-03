<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ){}

    public function index()
    {

    }

    function fetchData()
    {
        return DepartmentResource::collection(
            $this->service->getDepartments()
        );
    }


}

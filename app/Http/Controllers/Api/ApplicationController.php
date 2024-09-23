<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApplicationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationStoreRequest;
use App\Http\Resources\ApplicationCollection;
use App\Models\Application;
use App\Services\ApplicationService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct(
        protected ApplicationService $applicationService
    )
    {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'sortBy', 'sortDirection']);

        $filters['user_id'] = $request->user()->id;

        return ApplicationCollection::collection(
            $this->applicationService->getApplications($filters,$request->input('perPage',10))
        );
    }

    public function show(Application $application)
    {
        return new ApplicationCollection(
            $this->applicationService->getApplication($application->id)
        );
    }

    public function store(ApplicationStoreRequest $request)
    {
        $this->applicationService->createApplication($request->validated());

        return response()->json([
            'status' => true,
            'messages' => 'created'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationType;
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

    public function index()
    {
        return Inertia::render('Application/ApplicationList');
    }

    public function fetchData(Request $request)
    {
        $filters = $request->only(['search', 'sortBy', 'sortDirection']);

        return ApplicationCollection::collection(
            $this->applicationService->getApplications($filters,$request->input('perPage',10))
        );
    }

    public function create()
    {
        $types = ApplicationType::select();
        return Inertia::render('Application/CreateApplicationForm',compact('types'));
    }

    public function store(ApplicationStoreRequest $request)
    {
        $this->applicationService->createApplication($request->validated());

        return redirect()->route('application.create');
    }

    public function getApplicationDetail(Application $application)
    {
        return new ApplicationCollection(
            $this->applicationService->getApplication($application->id)
        );
    }

    public function show(Application $application)
    {
        return Inertia::render('Application/ShowApplication',[
            'application_id' => $application->id
        ]);
    }
}

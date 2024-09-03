<?php

namespace App\Services;

use App\Repositories\Applications\ApplicationAssignmentRepositoryInterface;
use App\Repositories\Applications\ApplicationRepositoryInterface;
use App\Repositories\Applications\ApplicationResponseRepositoryInterface;

class ApplicationService
{
    public function __construct(
        protected ApplicationRepositoryInterface $applicationRepository,
        protected ApplicationAssignmentRepositoryInterface $assignmentRepository,
        protected ApplicationResponseRepositoryInterface $responseRepository
    ){}

    public function getApplications(array $filters, int $perPage)
    {
        return $this->applicationRepository->searchAndPaginate($filters,$perPage);
    }

    public function getApplication(string $applicationId): \App\Models\Application
    {
        return $this->applicationRepository->findWithUserAndLocation($applicationId);
    }

    public function createApplication(array $data)
    {
        return $this->applicationRepository->create($data);
    }

    public function assignApplication($applicationId, $userId)
    {
        //TODO: create assigned code
    }

    public function respondToApplication($applicationId, $userId, array $responseData)
    {
        //TODO: create response for user or department
    }

}

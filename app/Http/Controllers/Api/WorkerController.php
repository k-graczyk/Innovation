<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\DTO\StoreWorkerDTO;
use App\Http\Requests\StoreWorkerRequest;
use App\Http\Resources\WorkerResource;
use App\Http\Services\Worker\Api\WorkerService;

class WorkerController extends Controller
{
    public function __construct(private WorkerService $workerService)
    {
    }

    public function store(StoreWorkerRequest $request)
    {
        $dto = new StoreWorkerDTO();
        $dto->setFirstname(data_get($request, 'first_name'));
        $dto->setLastName(data_get($request, 'last_name'));
        return new WorkerResource($this->workerService->store($dto));
    }
}

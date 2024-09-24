<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\DTO\StoreWorktimeDTO;
use App\Http\Requests\StoreWorktimeRequest;
use App\Http\Services\Worktime\Api\WorktimeService;

class WorktimeController extends Controller
{
    public function __construct(private WorktimeService $worktimeService)
    {
    }

    public function store(StoreWorktimeRequest $request)
    {
        $dto = new StoreWorktimeDTO();
        $dto->setWorkerId(data_get($request, 'worker_id'));
        $dto->setDateStart(data_get($request, 'date_start'));
        $dto->setDateEnd(data_get($request, 'date_end'));

        $this->worktimeService->store($dto);

        return response()->json('Czas pracy został dodany');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\DTO\DailySumDTO;
use App\Http\DTO\MonthlySumDTO;
use App\Http\DTO\StoreWorktimeDTO;
use App\Http\Requests\StoreWorktimeRequest;
use App\Http\Resources\DailyWorktimeResource;
use App\Http\Resources\MonthlyWorktimeResource;
use App\Http\Services\Worktime\Api\WorktimeService;
use Illuminate\Http\Request;

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

    public function dailySum(Request $request)
    {
        $dto = new DailySumDTO();
        $dto->setWorkerId(data_get($request, 'worker_id'));
        $dto->setDate(data_get($request, 'date'));
        return new DailyWorktimeResource($this->worktimeService->dailySum($dto));
    }
    public function monthlySum(Request $request)
    {
        $dto = new MonthlySumDTO();
        $dto->setWorkerId(data_get($request, 'worker_id'));
        $dto->setDate(data_get($request, 'date'));
        return new MonthlyWorktimeResource($this->worktimeService->monthlySum($dto));
    }
}

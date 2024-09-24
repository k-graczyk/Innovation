<?php

namespace App\Http\Services\Worktime\Api;

use App\Exceptions\ResponseException;
use App\Http\DTO\StoreWorktimeDTO;
use App\Models\Worktime;
use Illuminate\Support\Carbon;

class WorktimeService
{
    public function store(StoreWorktimeDTO $dto)
    {
        $dateStart = $dto->getDateStart();
        $dateEnd = $dto->getDateEnd();

        $formattedDateStart = Carbon::createFromFormat('d.m.Y H:i', $dateStart);
        $formattedDateEnd = Carbon::createFromFormat('d.m.Y H:i', $dateEnd);

        $dayStart = Carbon::createFromFormat('d.m.Y H:i', $dateStart)->format('Y-m-d');
        $exists = Worktime::where('worker_id', $dto->getWorkerId())
            ->where('day_start', $dayStart)
            ->exists();

        if ($formattedDateEnd->diffInHours($formattedDateStart, true) > 12) {
            throw new ResponseException('Różnica między datami nie może być większa niż 12 godzin.');
        }

        if ($exists) {
            throw new ResponseException('Ten dzień już istnieje dla podanego pracownika.');
        }

        return Worktime::create([
            'worker_id' => $dto->getWorkerId(),
            'date_start' => $formattedDateStart,
            'date_end' => $formattedDateEnd,
            'day_start' => $dayStart,
        ]);
    }
}
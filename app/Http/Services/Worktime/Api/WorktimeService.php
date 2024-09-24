<?php

namespace App\Http\Services\Worktime\Api;

use App\Exceptions\ResponseException;
use App\Http\DTO\DailySumDTO;
use App\Http\DTO\MonthlySumDTO;
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
    public function dailySum(DailySumDTO $dto)
    {
        $dayStart = Carbon::createFromFormat('d.m.Y', $dto->getDate())->format('Y-m-d');
        $worktime = Worktime::where('day_start', $dayStart)
            ->where('worker_id', $dto->getWorkerId())
            ->first();

        $this->handleNoResults($worktime);

        $roundedHours = $this->calculateRoundedHours(data_get($worktime, 'date_start'), data_get($worktime, 'date_end'));

        $rate = config('worktime.rate');
        $sum = $this->calculatePay($roundedHours, $rate);

        return [
            'hours' => $roundedHours,
            'rate' => $rate,
            'sum' => $sum,
        ];
    }

    public function monthlySum(MonthlySumDTO $dto)
    {
        $month = Carbon::createFromFormat('m.Y', $dto->getDate())->format('Y-m');
        $workerId = $dto->getWorkerId();

        $worktimes = Worktime::where('worker_id', $workerId)
            ->where('day_start', 'like', $month . '%')
            ->get();

        $this->handleNoResults($worktimes);

        $totalWorkedHours = 0;
        $rate = config('worktime.rate');
        $overtimeMultiplier = config('worktime.overtime_rate_multiplier');
        $monthlyHoursLimit = config('worktime.monthly_hours');

        foreach ($worktimes as $worktime) {
            $roundedHours = $this->calculateRoundedHours(data_get($worktime, 'date_start'), data_get($worktime, 'date_end'));
            $totalWorkedHours += $roundedHours;
        }

        $totalNormalHours = min($totalWorkedHours, $monthlyHoursLimit);
        $totalOvertimeHours = max(0, $totalWorkedHours - $monthlyHoursLimit);

        $totalPay = $this->calculatePay($totalNormalHours, $rate, $totalOvertimeHours, $overtimeMultiplier);

        return [
            'normal_hours' => $totalNormalHours,
            'overtime_hours' => $totalOvertimeHours,
            'rate' => $rate,
            'overtime_rate' => $rate * $overtimeMultiplier,
            'total' => $totalPay,
        ];
    }

    private function calculateRoundedHours($dateStart, $dateEnd)
    {
        $formattedDateStart = Carbon::parse($dateStart);
        $formattedDateEnd = Carbon::parse($dateEnd);

        $totalMinutes = $formattedDateEnd->diffInMinutes($formattedDateStart, true);
        $fullHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;

        if ($remainingMinutes <= 15) {
            return $fullHours;
        } elseif ($remainingMinutes <= 45) {
            return $fullHours + 0.5;
        } else {
            return $fullHours + 1;
        }
    }

    private function calculatePay($workedHours, $rate, $overtimeHours = 0, $overtimeMultiplier = 1)
    {
        $normalPay = $workedHours * $rate;
        $overtimePay = $overtimeHours * $rate * $overtimeMultiplier;
        return $normalPay + $overtimePay;
    }

    private function handleNoResults($worktime)
    {
        if (!$worktime) {
            throw new ResponseException('Brak wyników dla podanych parametrów');
        }
    }
}
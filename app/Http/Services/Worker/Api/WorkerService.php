<?php

namespace App\Http\Services\Worker\Api;

use App\Http\DTO\StoreWorkerDTO;
use App\Models\Worker;

class WorkerService
{
    public function store(StoreWorkerDTO $dto)
    {
        $worker = Worker::create([
            'first_name' => $dto->getFirstName(),
            'last_name' => $dto->getLastName(),
        ]);
        return ['id' => data_get($worker, 'id')];
    }
}
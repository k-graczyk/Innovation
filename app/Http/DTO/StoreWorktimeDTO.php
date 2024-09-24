<?php

namespace App\Http\DTO;

class StoreWorktimeDTO
{
    private $workerId;
    private $dateStart;
    private $dateEnd;

    public function setWorkerId(string $workerId): void
    {
        $this->workerId = $workerId;
    }
    public function getWorkerId(): string
    {
        return $this->workerId;
    }

    public function setDateStart(string $dateStart): void
    {
        $this->dateStart = $dateStart;
    }
    public function getDateStart(): string
    {
        return $this->dateStart;
    }
    public function setDateEnd(string $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }
}
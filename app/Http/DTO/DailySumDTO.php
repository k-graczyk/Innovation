<?php

namespace App\Http\DTO;

class DailySumDTO
{
    private $id;
    private $date;

    public function setWorkerId(string $workerId): void
    {
        $this->id = $workerId;
    }

    public function getWorkerId(): string
    {
        return $this->id;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

}
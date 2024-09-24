<?php

namespace App\Http\DTO;

class StoreWorkerDTO
{
    private $firstName;
    private $lastName;

    public function setFirstname(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function getFirstName(): string
    {
        return $this->firstName;
    }
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
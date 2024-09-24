<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonthlyWorktimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'normal_hours' => data_get($this, 'normal_hours'), // ilość godzin
            'overtime_hours' => data_get($this, 'overtime_hours'), // ilość nadgodzin
            'rate' => data_get($this, 'rate') . ' PLN', //stawka
            'overtime_rate' => data_get($this, 'overtime_rate') . ' PLN', // stawka nadgodzinowa
            'total' => data_get($this, 'total') . ' PLN', //suma po przeliczeniu
        ];
    }
}

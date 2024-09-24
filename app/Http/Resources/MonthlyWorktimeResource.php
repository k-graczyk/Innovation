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
            'ilość godzin' => data_get($this, 'normal_hours'),
            'ilość nadgodzin' => data_get($this, 'overtime_hours'),
            'stawka' => data_get($this, 'rate') . ' PLN',
            'stawka nadgodzinowa' => data_get($this, 'overtime_rate') . ' PLN',
            'suma po przeliczeniu' => data_get($this, 'total') . ' PLN',
        ];
    }
}

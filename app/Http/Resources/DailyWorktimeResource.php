<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyWorktimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'hours' => data_get($this, 'hours'), // ilość godzin
            'rate' => data_get($this, 'rate') . ' PLN', // stawka
            'sum' => data_get($this, 'sum') . ' PLN', //suma po przeliczeniu
        ];
    }
}

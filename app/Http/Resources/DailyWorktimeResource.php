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
            'ilość godzin' => data_get($this, 'hours'),
            'stawka' => data_get($this, 'rate') . ' PLN',
            'suma po przeliczeniu' => data_get($this, 'sum') . ' PLN',
        ];
    }
}

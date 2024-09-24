<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'first_name',
        'last_name'
    ];

    public function worktimes(): HasMany
    {
        return $this->hasMany(Worktime::class);
    }
}

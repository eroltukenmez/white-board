<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ApplicationAssignment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'application_id','assignee_id','assignee_type','reason',
    ];

    public function assignee(): MorphTo
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory,HasUuids, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name', 'parent_id'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo($this,'parent_id');
    }

    public function child()
    {
        return $this->hasMany($this,'parent_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();
    }

    public function applications(): MorphMany
    {
        return $this->morphMany(ApplicationAssignment::class, 'assignee');
    }
}

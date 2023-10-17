<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends ModelsRole
{
    use HasFactory, SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*']);
        // ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
}

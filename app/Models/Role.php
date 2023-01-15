<?php

namespace App\Models;

use App\Enums\AdministrativeRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;
    use LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'permissions'])
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    public function getCreatedAtAttribute($value)
    {
        if ($value !== null) {
            return  $this->attributes['created_at'] = Carbon::parse($value)->diffForHumans();
        }
    }

    protected $appends = ['isDeletable', 'isEditable'];

    public function getIsDeletableAttribute($value)
    {
        $administrativeRole = AdministrativeRole::values();

        if (! in_array($this->id, $administrativeRole)) {
            return true;
        } else {
            return false;
        }
    }

    public function getIsEditableAttribute($value)
    {
        if ($this->id === 1) {
            return false;
        } else {
            return true;
        }
    }
}

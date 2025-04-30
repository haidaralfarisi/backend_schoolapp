<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeacherClass extends Model
{
    protected $guarded = ['id'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function class(): HasMany
    {
        return $this->hasMany(School::class, 'school_id', 'school_id');
    }

}

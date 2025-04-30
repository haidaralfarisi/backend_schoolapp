<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'school_name',
        'region',
        'address',
        'email'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'userschools', 'school_id', 'user_id');

        // return $this->belongsToMany(User::class, 'userschools')->withTimestamps();
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'school_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'school_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'school_id');
    }

    public function studentNotes()
    {
        return $this->hasMany(StudentNote::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function lessonplans()
    {
        return $this->hasMany(LessonPlan::class, 'school_id');
    }

    public function schoolinfos()
    {
        return $this->hasMany(SchoolInfo::class, 'school_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Sesuaikan nama tabel

    protected $fillable = [
        'class_id', // Identifier unik kelas
        'school_id',
        'class_name',
        'grade',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_classes')->withTimestamps();
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'class_id');
    }

    public function studentNotes()
    {
        return $this->hasMany(StudentNote::class, 'class_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function lessonplans()
    {
        return $this->hasMany(LessonPlan::class, 'class_id', 'class_id');
    }

    public function ereports()
    {
        return $this->hasMany(Ereport::class, 'class_id');
    }

    
}

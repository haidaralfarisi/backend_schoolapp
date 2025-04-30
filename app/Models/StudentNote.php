<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'student_id',
        'title',
        'content',
        'image'
    ];

    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function studentNotes()
    {
        return $this->hasMany(StudentNote::class, 'class_id');
    }
}

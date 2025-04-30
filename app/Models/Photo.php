<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'school_id',
        'class_id',
        'student_id',
        'photo_type',
        'location',
        'image',
        'description'
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function classes()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}

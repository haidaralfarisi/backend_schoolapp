<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_id',
        'user_id',
        'title',
        'desc',
        'file_pdf'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function classes()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }
}

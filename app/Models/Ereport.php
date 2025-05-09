<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ereport extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id'); // id di student berupa string
    }

    public function tahunAjarans()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'tahun_ajaran_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

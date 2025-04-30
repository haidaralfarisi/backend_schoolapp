<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'school_id',
        'class_id',
        'description',
        'url'
    ];


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }
}

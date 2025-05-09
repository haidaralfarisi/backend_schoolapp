<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'student_id', // ID unik siswa
    //     'nisn',
    //     'fullname',
    //     'username',
    //     'gender',
    //     'pob',
    //     'dob',
    //     'school_id',
    //     'class_id',
    //     'user_id',
    //     'entry_year',
    protected $guarded = ['id'];


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'student_parents')->withPivot('relation')->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function ereports()
    {
        return $this->hasMany(Ereport::class, 'student_id', 'id');
    }
}

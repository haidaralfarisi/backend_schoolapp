<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nip',
        'fullname',
        'email',
        'password',
        'username',
        'level',
        'photo',
    ];

    public function schools(): BelongsToMany
    {
        // return $this->belongsToMany(School::class, 'userschools')->withTimestamps();
        return $this->belongsToMany(School::class, 'userschools', 'user_id', 'school_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'teacher_classes')->withTimestamps();
    }

    public function lessonplans()
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function children()
    {
        return $this->belongsToMany(Student::class, 'student_parents')->withPivot('relation')->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

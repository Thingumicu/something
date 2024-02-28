<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table='teachers';

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'name',
        'short',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_teacher', 'teacher_id', 'lesson_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table='lessons';

    protected $fillable = [
        'id',
        'classids',
        'subjectid',
        'periodspercard',
        'periodsperweek',
        'teacherids',
        'groupids',
        'termsdefid',
        'weeksdefid',
        'daysdefid',
    ];

    public function classes(){
        return $this->belongsToMany(Clas::class,'class_lesson','lesson_id','class_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'lesson_teacher', 'lesson_id', 'teacher_id');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'lesson_group', 'lesson_id', 'group_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjectid');
    }

}

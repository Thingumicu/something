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
}

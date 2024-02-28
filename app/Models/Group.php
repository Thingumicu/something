<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table='groups';

    protected $fillable = [
        'id',
        'name',
        'classid',
        'entireclass',
        'divisiontag',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_group', 'group_id', 'lesson_id');
    }
}

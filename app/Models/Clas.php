<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    protected $table='classes';

    protected $fillable = [
        'id',
        'name',
        'short',
        'partner_id',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'class_lesson');
    }



}

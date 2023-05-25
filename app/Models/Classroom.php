<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $table='classrooms';

    protected $fillable = [
        'id',
        'name',
        'short',
        'partner_id',
    ];
}

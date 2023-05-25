<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weeksdef extends Model
{
    protected $table='weeksdefs';

    protected $fillable = [
        'id',
        'name',
        'short',
        'weeks',
    ];
}

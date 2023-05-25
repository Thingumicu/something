<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daysdef extends Model
{
    protected $table='daysdefs';

    protected $fillable = [
        'id',
        'name',
        'short',
        'days',
    ];
}

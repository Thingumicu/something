<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termsdef extends Model
{
    protected $table='termsdefs';

    protected $fillable = [
        'id',
        'name',
        'short',
        'terms',
    ];
}

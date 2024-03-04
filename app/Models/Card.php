<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table='cards';

    protected $fillable = [
        'lessonid',
        'classroomids',
        'period',
        'weeks',
        'terms',
        'days',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lessonid');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroomids');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period');
    }

    public function daysDef()
    {
        return $this->belongsTo(Daysdef::class, 'days');
    }

    public function index()
    {
        $cards = Card::with(['lesson.subject', 'lesson.teacher', 'classroom', 'period', 'daysDef'])->get();

        return view('cards', compact('cards'));
    }

}

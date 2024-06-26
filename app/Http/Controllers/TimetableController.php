<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Clas;
use App\Models\Classroom;
use App\Models\Day;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Term;
use App\Models\Week;

class TimetableController extends Controller
{
    public function showCards()
    {
        $cards = Card::all();

        return view('cards', compact('cards'));
    }

    public function showClasses()
    {
        $classes = Clas::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['[subject]','[subject]','[subject]','[subject]','[subject]'];

        return view('classes', compact('headers','contents','classes'));
    }

    public function showClassrooms()
    {
        $classrooms = Classroom::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['C/L/S','C/L/S','C/L/S','C/L/S','C/L/S'];

        return view('classrooms', compact('headers','contents','classrooms'));
    }

    public function showDaysdefs()
    {
        $daysdefs = Day::all();

        return view('daysdefs', compact('daysdefs'));
    }

    public function showGrades()
    {
        $grades = Grade::all();

        return view('grades', compact('grades'));
    }

    public function showGroups()
    {
        $groups = Group::all();

        return view('groups', compact('groups'));
    }

    public function showLessons()
    {
        $lessons = Lesson::all();

        return view('lessons', compact('lessons'));
    }

    public function showPeriods()
    {
        $periods = Period::all();

        return view('periods', compact('periods'));
    }

    public function showSubjects()
    {
        $subjects = Subject::all();

        return view('subjects', compact('subjects'));
    }

    public function showTeachers()
    {
        $teachers = Teacher::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['C/L/S','C/L/S','C/L/S','C/L/S','C/L/S'];

        return view('teachers', compact('headers','contents','teachers'));
    }

    public function showTermsdefs()
    {
        $termsdefs = Term::all();

        return view('termsdefs', compact('termsdefs'));
    }

    public function showWeeksdefs()
    {
        $weeksdefs = Week::all();

        return view('weeksdefs', compact('weeksdefs'));
    }

    public function welcome(){
        return view('welcome');
    }

    public function test(){
        return view('test');
    }

}

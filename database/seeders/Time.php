<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Clas;
use App\Models\Classroom;
use App\Models\Daysdef;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Termsdef;
use App\Models\Weeksdef;
use Illuminate\Database\Seeder;

class Time extends Seeder
{
    /**
     * Run database seeding
     */

    public function run(): void
    {
        $xml = simplexml_load_string(file_get_contents('C:\licenta\something\time.xml'));

        //Teachers
        foreach ($xml->teachers->teacher as $teacher) {
            Teacher::create([
                'id' => (string)$teacher['id'],
                'firstname' => (string)$teacher['firstname'],
                'lastname' => (string)$teacher['lastname'],
                'name' => (string)$teacher['name'],
                'short' => (string)$teacher['short'],
            ]);
        }
        //Periods
        foreach ($xml->periods->period as $period) {
            Period::create([
                'name' => (string)$period['name'],
                'short' => (string)$period['short'],
                'period' => (string)$period['period'],
                'starttime' => (string)$period['starttime'],
                'stoptime' => (string)$period['stoptime'],
            ]);
        }
        //Grades
        foreach ($xml->grades->grade as $grade) {
            Grade::create([
                'name' => (string)$grade['name'],
                'short' => (string)$grade['short'],
                'grade' => (string)$grade['grade'],
            ]);
        }
        //Terms
        foreach ($xml->termsdefs->termsdef as $term) {
            Termsdef::create([
                'id' => (string)$term['id'],
                'name' => (string)$term['name'],
                'short' => (string)$term['short'],
                'terms' => (string)$term['terms'],
            ]);
        }
        //Days
        foreach ($xml->daysdefs->daysdef as $daysdef) {
            Daysdef::create([
                'id' => (string)$daysdef['id'],
                'name' => (string)$daysdef['name'],
                'short' => (string)$daysdef['short'],
                'days' => (string)$daysdef['days'],
            ]);
        }
        //Weeks
        foreach ($xml->weeksdefs->weeksdef as $weeksdef) {
            Weeksdef::create([
                'id' => (string)$weeksdef['id'],
                'name' => (string)$weeksdef['name'],
                'short' => (string)$weeksdef['short'],
                'weeks' => (string)$weeksdef['weeks'],
            ]);
        }
        //Classrooms
        foreach ($xml->classrooms->classroom as $classroom) {
            Classroom::create([
                'id' => (string)$classroom['id'],
                'name' => (string)$classroom['name'],
                'short' => (string)$classroom['short'],
                'partner_id' => (string)$classroom['partner_id'],
            ]);
        }
        //Classes
        foreach ($xml->classes->class as $class) {
            Clas::create([
                'id' => (string)$class['id'],
                'name' => (string)$class['name'],
                'short' => (string)$class['short'],
                'partner_id' => (string)$class['partner_id'],
            ]);
        }
        //Subjects
        foreach ($xml->subjects->subject as $subject) {
            Subject::create([
                'id' => (string)$subject['id'],
                'name' => (string)$subject['name'],
                'short' => (string)$subject['short'],
                'partner_id' => (string)$subject['partner_id'],
            ]);
        }
        //Groups
        foreach ($xml->groups->group as $group) {
            Group::create([
                'id' => (string)$group['id'],
                'name' => (string)$group['name'],
                'classid' => (string)$group['classid'],
                'entireclass' => (string)$group['entireclass'],
                'divisiontag' => (string)$group['divisiontag'],
            ]);
        }
        //Lessons_Old
        foreach ($xml->lessons->lesson as $lesson) {
            $classids = explode(',',(string)$lesson['classids']);
            $teacherids = explode(',',(string)$lesson['teacherids']);
            $groupids = explode(',',(string)$lesson['groupids']);
            Lesson::create([
                'id' => (string)$lesson['id'],
                'classids' => implode(',',$classids),
                'subjectid' => (string)$lesson['subjectid'],
                'periodspercard' => (string)$lesson['periodspercard'],
                'periodsperweek' => (string)$lesson['periodsperweek'],
                'teacherids' => implode(',',$teacherids),
                'groupids' => implode(',',$groupids),
                'weeksdefid' => (string)$lesson['weeksdefid'],
                'daysdefid' => (string)$lesson['daysdefid'],
            ]);
        }
//        // Lessons
//        foreach ($xml->lessons->lesson as $lesson) {
//            $classids = explode(',', (string)$lesson['classids']);
//            $teacherids = explode(',', (string)$lesson['teacherids']);
//            $groupids = explode(',', (string)$lesson['groupids']);
//
//            $newLesson = Lesson::create([
//                'id' => (string)$lesson['id'],
//                'subjectid' => (string)$lesson['subjectid'],
//                'periodspercard' => (string)$lesson['periodspercard'],
//                'periodsperweek' => (string)$lesson['periodsperweek'],
//                'weeksdefid' => (string)$lesson['weeksdefid'],
//                'daysdefid' => (string)$lesson['daysdefid'],
//            ]);
//
//            // Attach relationships
//            $newLesson->classes()->attach($classids);
//            $newLesson->teachers()->attach($teacherids);
//            $newLesson->groups()->attach($groupids);
//        }

        //Cards
        foreach ($xml->cards->card as $card) {
            Card::create([
                'lessonid' => (string)$card['lessonid'],
                'classroomids' => (string)$card['classroomids'],
                'period' => (string)$card['period'],
                'weeks' => (string)$card['weeks'],
                'terms' => (string)$card['terms'],
                'days' => (string)$card['days'],
            ]);
        }

    }
}
